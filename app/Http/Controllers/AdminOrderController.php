<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminOrderController extends Controller
{
    // 📌 DANH SÁCH ĐƠN HÀNG + FILTER
    public function index(Request $request)
    {
        $query = DB::table('don_hang');

        $status = $request->status;

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->orderBy('ma_don_hang', 'desc')->get();

        return view('coop-shop.manage-orders.index', compact('orders', 'status'));
    }

    // 📌 XEM CHI TIẾT ĐƠN HÀNG
    public function show($id)
    {
        $order = DB::table('don_hang')
            ->where('ma_don_hang', $id)
            ->first();

        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng!');
        }

        $items = DB::table('chi_tiet_don_hang')
            ->join('san_pham_bhx', 'chi_tiet_don_hang.id_san_pham', '=', 'san_pham_bhx.id')
            ->where('chi_tiet_don_hang.ma_don_hang', $id)
            ->select(
                'san_pham_bhx.ten_sp',
                'san_pham_bhx.gia_ban',
                'chi_tiet_don_hang.so_luong'
            )
            ->get();

        $return = DB::table('return_requests')
            ->where('order_id', $id)
            ->latest()
            ->first();

        return view('coop-shop.manage-orders.show', compact('order', 'items', 'return'));
    }

    // ✅ DUYỆT HOÀN TIỀN
    public function approve($id)
    {
        DB::table('don_hang')
            ->where('ma_don_hang', $id)
            ->update([
                'status' => 'refunded'
            ]);

        DB::table('return_requests')
            ->where('order_id', $id)
            ->update([
                'status' => 'approved'
            ]);

        return back()->with('success', 'Đã duyệt hoàn tiền!');
    }

    // ❌ TỪ CHỐI YÊU CẦU
    public function reject($id)
    {
        DB::table('don_hang')
            ->where('ma_don_hang', $id)
            ->update([
                'status' => 'received'
            ]);

        DB::table('return_requests')
            ->where('order_id', $id)
            ->update([
                'status' => 'rejected'
            ]);

        return back()->with('success', 'Đã từ chối yêu cầu!');
    }

    // 📩 YÊU CẦU BỔ SUNG (KHÔNG LƯU NOTE, CHỈ GỬI MAIL)
    public function needInfo(Request $request, $id)
    {
        // validate
        $request->validate([
            'note' => 'required|string|max:1000'
        ]);

        // cập nhật trạng thái
        DB::table('return_requests')
            ->where('order_id', $id)
            ->update([
                'status' => 'need_more_info'
            ]);

        // lấy đơn hàng
        $order = DB::table('don_hang')
            ->where('ma_don_hang', $id)
            ->first();

        if ($order) {
            // lấy user
            $user = DB::table('users')
                ->where('id', $order->user_id)
                ->first();

            // gửi mail
            if ($user && $user->email) {
                Mail::raw(
                    "Xin chào,\n\nĐơn hàng #{$id} cần bổ sung thông tin.\n\nNội dung:\n{$request->note}\n\nVui lòng cập nhật sớm.",
                    function ($message) use ($user) {
                        $message->to($user->email)
                                ->subject('Yêu cầu bổ sung đơn hàng - Coop Shop');
                    }
                );
            }
        }

        return back()->with('success', 'Đã gửi yêu cầu bổ sung đến khách hàng!');
    }
}