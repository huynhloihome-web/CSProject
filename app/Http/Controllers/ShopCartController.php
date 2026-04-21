<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopCartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $products = collect();
        $quantities = [];
        $totalMoney = 0;

        if (!empty($cart)) {
            $ids = array_keys($cart);

            $products = DB::table('san_pham_bhx')
                ->select(
                    'id',
                    'tieu_de',
                    'gia_ban',
                    'gia_goc',
                    'hinh_anh',
                    'don_vi_tinh',
                    'khuyen_mai'
                )
                ->whereIn('id', $ids)
                ->orderBy('id', 'asc')
                ->get();

            foreach ($products as $row) {
                $quantities[$row->id] = $cart[$row->id];
                $totalMoney += $row->gia_ban * $cart[$row->id];
            }
        }

        return view('coop-shop.cart-page', compact('products', 'quantities', 'totalMoney'));
    }

    public function remove(Request $request)
    {
        $request->validate([
            'id' => ['required', 'numeric']
        ]);

        $cart = session()->get('cart', []);
        $id = (int) $request->id;

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('coop-shop.cart')
            ->with('status', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
}