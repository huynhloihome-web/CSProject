<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderStatusController extends Controller
{
    public function index()
    {
        $orders = DB::table('don_hang')
            ->where('user_id', Auth::id())
            ->get();

        return view('coop-shop.order-status.index', compact('orders'));
    }

    public function show($id)
    {
        $order = DB::table('don_hang')
            ->where('ma_don_hang', $id)
            ->first();

        $items = DB::table('chi_tiet_don_hang')
            ->join('san_pham_bhx', 'chi_tiet_don_hang.id_san_pham', '=', 'san_pham_bhx.id')
            ->where('chi_tiet_don_hang.ma_don_hang', $id)
            ->select(
                'san_pham_bhx.ten_sp',
                'san_pham_bhx.gia_ban',
                'chi_tiet_don_hang.so_luong'
            )
            ->get();

        return view('coop-shop.order-status.show', compact('order', 'items'));
    }

    public function received($id)
    {
        DB::table('don_hang')
            ->where('ma_don_hang', $id)
            ->update(['status' => 'received']);

        return back();
    }

    public function returnOrder($id)
    {
        DB::table('don_hang')
            ->where('ma_don_hang', $id)
            ->update(['status' => 'returning']);

        return back();
    }
}