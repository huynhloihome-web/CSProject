<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ShopManageProductController;

class ShopManageProductController extends Controller
{
    public function index()
    {
        $products = DB::table('san_pham_bhx')
            ->select(
                'id',
                'tieu_de',
                'gia_goc',
                'gia_ban',
                'hinh_anh',
                'don_vi_tinh',
                'khuyen_mai',
                'ten_sp',
                'thuong_hieu',
                'xuat_xu',
                'trong_luong',
                'bao_quan',
                'thanh_phan',
                'mo_ta',
                'status'
            )
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        return view('coop-shop.manage-products.index', compact('products'));
    }

    public function show($id)
    {
        $product = DB::table('san_pham_bhx')
            ->select(
                'id',
                'tieu_de',
                'ten_sp',
                'gia_goc',
                'gia_ban',
                'hinh_anh',
                'don_vi_tinh',
                'trong_luong',
                'khuyen_mai',
                'thuong_hieu',
                'xuat_xu',
                'bao_quan',
                'thanh_phan',
                'mo_ta',
                'status'
            )
            ->where('id', $id)
            ->where('status', 1)
            ->first();

        if (!$product) {
            abort(404);
        }

        return view('coop-shop.manage-products.show', compact('product'));
    }

    public function destroy($id)
    {
        $product = DB::table('san_pham_bhx')
            ->where('id', $id)
            ->where('status', 1)
            ->first();

        if (!$product) {
            return redirect()
                ->route('coop-shop.manage.products.index')
                ->with('status', 'Sản phẩm không tồn tại hoặc đã bị xóa.');
        }

        DB::table('san_pham_bhx')
            ->where('id', $id)
            ->update([
                'status' => 0
            ]);

        return redirect()
            ->route('coop-shop.manage.products.index')
            ->with('status', 'Đã xóa sản phẩm thành công.');
    }
}
