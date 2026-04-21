<?php

namespace App\Http\Controllers;

use App\Notifications\ShopOrderSuccessNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ShopOrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'hinh_thuc_thanh_toan' => ['required', 'numeric'],
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('coop-shop.cart')
                ->with('status', 'Giỏ hàng đang trống, không thể đặt hàng.');
        }

        $productIds = array_keys($cart);

        $products = DB::table('san_pham_bhx')
            ->select(
                'id',
                'tieu_de',
                'gia_ban',
                'gia_goc',
                'ton_kho',
                'hinh_anh',
                'don_vi_tinh',
                'khuyen_mai'
            )
            ->whereIn('id', $productIds)
            ->orderBy('id', 'asc')
            ->get();

        if ($products->count() === 0 || $products->count() !== count($productIds)) {
            return redirect()
                ->route('coop-shop.cart')
                ->with('status', 'Không tìm thấy sản phẩm hợp lệ để đặt hàng.');
        }

        foreach ($products as $row) {
            $soLuong = (int) ($cart[$row->id] ?? 0);

            if ($soLuong < 1) {
                return redirect()
                    ->route('coop-shop.cart')
                    ->with('status', 'Giỏ hàng có dữ liệu không hợp lệ.');
            }

            if ((int) $row->ton_kho < $soLuong) {
                return redirect()
                    ->route('coop-shop.cart')
                    ->with('status', 'Sản phẩm "' . $row->tieu_de . '" chỉ còn ' . (int) $row->ton_kho . ' sản phẩm trong kho.');
            }
        }

        $tongTien = 0;
        $mailData = [];
        $maDonHang = 0;

        try {
            DB::transaction(function () use (
                $request,
                $cart,
                $products,
                &$tongTien,
                &$mailData,
                &$maDonHang
            ) {
                foreach ($products as $row) {
                    $soLuong = (int) $cart[$row->id];
                    $tongTien += $row->gia_ban * $soLuong;
                }

                $order = [
                    'user_id' => Auth::id(),
                    'ngay_dat_hang' => now(),
                    'tinh_trang' => 1,
                    'hinh_thuc_thanh_toan' => $request->hinh_thuc_thanh_toan,
                    'tong_tien' => $tongTien,
                ];

                $maDonHang = DB::table('don_hang')->insertGetId($order, 'ma_don_hang');

                $detailRows = [];

                foreach ($products as $row) {
                    $soLuong = (int) $cart[$row->id];

                    $detailRows[] = [
                        'ma_don_hang' => $maDonHang,
                        'id_san_pham' => $row->id,
                        'so_luong' => $soLuong,
                        'don_gia' => $row->gia_ban,
                    ];

                    $updatedRows = DB::table('san_pham_bhx')
                        ->where('id', $row->id)
                        ->where('ton_kho', '>=', $soLuong)
                        ->update([
                            'ton_kho' => DB::raw('ton_kho - ' . $soLuong),
                        ]);

                    if ($updatedRows === 0) {
                        throw new \RuntimeException('Sản phẩm "' . $row->tieu_de . '" không đủ tồn kho để hoàn tất đơn hàng.');
                    }

                    $mailData[] = (object) [
                        'tieu_de' => $row->tieu_de,
                        'so_luong' => $soLuong,
                        'gia_ban' => $row->gia_ban,
                        'thanh_tien' => $row->gia_ban * $soLuong,
                    ];
                }

                DB::table('chi_tiet_don_hang')->insert($detailRows);
            });
        } catch (\RuntimeException $exception) {
            return redirect()
                ->route('coop-shop.cart')
                ->with('status', $exception->getMessage());
        }

        Notification::route('mail', Auth::user()->email)
            ->notify(new ShopOrderSuccessNotification(
                $maDonHang,
                $mailData,
                $tongTien,
                $this->getPaymentText($request->hinh_thuc_thanh_toan),
                Auth::user()->name
            ));

        session()->forget('cart');

        return redirect()
            ->route('coop-shop.cart')
            ->with('status', 'Đặt hàng thành công. Email xác nhận đã được gửi.');
    }

    private function getPaymentText($value)
    {
        if ($value == 1) {
            return 'Tiền mặt';
        }

        if ($value == 2) {
            return 'Chuyển khoản';
        }

        if ($value == 3) {
            return 'Thanh toán VNPay';
        }

        return 'Khác';
    }
}
