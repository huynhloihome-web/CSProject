<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopCheckoutController extends Controller
{
    public function confirm(Request $request)
    {
        $userId = auth()->id();

        // 🔥 ƯU TIÊN: address_id từ request (user vừa chọn)
        $addressId = $request->address_id;

        // 🔥 FALLBACK: nếu không có → lấy từ session
        if (!$addressId) {
            $addressId = session('selected_address');
        }

        // 🔥 FALLBACK CUỐI: lấy địa chỉ mặc định trong DB
        if (!$addressId) {
            $defaultAddress = DB::table('user_addresses')
                ->where('user_id', $userId)
                ->where('is_default', 1)
                ->first();

            $addressId = $defaultAddress->id ?? null;
        }

        // ❌ không có địa chỉ nào
        if (!$addressId) {
            return redirect()
                ->back()
                ->with('status', 'Vui lòng thêm địa chỉ giao hàng');
        }

        // lấy địa chỉ hợp lệ
        $address = DB::table('user_addresses')
            ->where('id', $addressId)
            ->where('user_id', $userId)
            ->first();

        if (!$address) {
            return redirect()
                ->back()
                ->with('status', 'Địa chỉ không hợp lệ');
        }

        // giỏ hàng
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('coop-shop.cart')
                ->with('status', 'Giỏ hàng trống');
        }

        // sản phẩm
        $products = DB::table('san_pham_bhx')
            ->whereIn('id', array_keys($cart))
            ->get();

        // tổng tiền
        $total = 0;

        foreach ($products as $p) {
            $total += $p->gia_ban * $cart[$p->id];
        }

        return view('coop-shop.checkout-confirm', [
            'address' => $address,
            'products' => $products,
            'cart' => $cart,
            'total' => $total,
            'payment' => $request->hinh_thuc_thanh_toan ?? null
        ]);
    }
}