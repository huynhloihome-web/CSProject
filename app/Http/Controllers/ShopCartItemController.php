<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopCartItemController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id'  => ['required', 'numeric'],
            'num' => ['required', 'numeric', 'min:1']
        ]);

        $product = DB::table('san_pham_bhx')
            ->where('id', $request->id)
            ->first();

        if (!$product) {
            return redirect()->back()->with('status', 'Sản phẩm không tồn tại.');
        }

        $cart = session()->get('cart', []);
        $id = (int) $request->id;
        $num = (int) $request->num;

        if (isset($cart[$id])) {
            $cart[$id] += $num;
        } else {
            $cart[$id] = $num;
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('status', 'Đã thêm sản phẩm vào giỏ hàng.');
    }
}