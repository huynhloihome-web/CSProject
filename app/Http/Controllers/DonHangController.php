<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonHang;

class DonHangController extends Controller
{
    public function index()
    {
        $donHangs = DonHang::where('user_id', auth()->id())->get();

        return view('coop-shop.donhang.index', compact('donHangs'));
    }

    public function markAsReceived($id)
    {
        $donHang = DonHang::findOrFail($id);

        if ($donHang->user_id != auth()->id()) {
            abort(403);
        }

        $donHang->status = 'received';
        $donHang->save();

        return back()->with('success', 'Đã nhận hàng!');
    }
}