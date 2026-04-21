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

    public function received($id)
    {
        DB::table('don_hang')
            ->where('ma_don_hang', $id)
            ->update(['status' => 'received']);

        return back();
    }
}