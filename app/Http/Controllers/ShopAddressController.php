<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopAddressController extends Controller
{
    public function index(Request $request)
    {
        $addresses = DB::table('user_addresses')
            ->where('user_id', Auth::id())
            ->orderByDesc('is_default')
            ->get();

        // lưu payment
        if ($request->hinh_thuc_thanh_toan) {
            session(['payment' => $request->hinh_thuc_thanh_toan]);
        }

        return view('coop-shop.address', compact('addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required',
            'so_dien_thoai' => 'required',
            'dia_chi_chi_tiet' => 'required',
            'phuong_xa' => 'required',
            'quan_huyen' => 'required',
            'tinh_thanh' => 'required',
        ]);

        if ($request->is_default) {
            DB::table('user_addresses')
                ->where('user_id', Auth::id())
                ->update(['is_default' => 0]);

            $isDefault = 1;
        } else {
            $count = DB::table('user_addresses')
                ->where('user_id', Auth::id())
                ->count();

            $isDefault = $count == 0 ? 1 : 0;
        }

        DB::table('user_addresses')->insert([
            'user_id' => Auth::id(),
            'ho_ten' => $request->ho_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'dia_chi_chi_tiet' => $request->dia_chi_chi_tiet,
            'phuong_xa' => $request->phuong_xa,
            'quan_huyen' => $request->quan_huyen,
            'tinh_thanh' => $request->tinh_thanh,
            'is_default' => $isDefault,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('coop-shop.address');
    }
}