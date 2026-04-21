<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function create()
    {
        $categories = DB::table('danh_muc')
            ->select('id', 'ten')
            ->orderBy('ten', 'asc')
            ->get();

        return view('coop-shop.manage-products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ma_sp' => ['nullable', 'string', 'max:50'],
            'tieu_de' => ['required', 'string', 'max:500'],
            'ten_sp' => ['required', 'string', 'max:255'],
            'gia_ban' => ['required', 'numeric', 'min:0'],
            'gia_goc' => ['required', 'numeric', 'min:0', 'gte:gia_ban'],
            'hinh_anh' => ['required', 'url', 'max:500'],
            'danh_muc_id' => ['required', 'integer', 'exists:danh_muc,id'],
            'don_vi_tinh' => ['required', 'string', 'max:50'],
            'trong_luong' => ['nullable', 'string', 'max:50'],
            'thuong_hieu' => ['nullable', 'string', 'max:100'],
            'xuat_xu' => ['nullable', 'string', 'max:100'],
            'bao_quan' => ['nullable', 'string', 'max:100'],
            'thanh_phan' => ['nullable', 'string'],
            'mo_ta' => ['nullable', 'string'],
            'khuyen_mai' => ['nullable', 'string'],
            'noi_bat' => ['nullable', 'boolean'],
        ]);

        $category = DB::table('danh_muc')
            ->select('id', 'ten')
            ->where('id', $validated['danh_muc_id'])
            ->first();

        if (! $category) {
            return back()
                ->withErrors(['danh_muc_id' => 'Danh mục không tồn tại.'])
                ->withInput();
        }

        DB::table('san_pham_bhx')->insert([
            'ma_sp' => $validated['ma_sp'] ?: 'SP' . now()->format('YmdHis'),
            'tieu_de' => $validated['tieu_de'],
            'ten_sp' => $validated['ten_sp'],
            'gia_ban' => $validated['gia_ban'],
            'gia_goc' => $validated['gia_goc'],
            'hinh_anh' => $validated['hinh_anh'],
            'danh_muc_id' => $category->id,
            'danh_muc_ten' => $category->ten,
            'don_vi_tinh' => $validated['don_vi_tinh'],
            'trong_luong' => $validated['trong_luong'] ?? null,
            'thuong_hieu' => $validated['thuong_hieu'] ?? null,
            'xuat_xu' => $validated['xuat_xu'] ?? null,
            'bao_quan' => $validated['bao_quan'] ?? null,
            'thanh_phan' => $validated['thanh_phan'] ?? null,
            'mo_ta' => $validated['mo_ta'] ?? null,
            'noi_bat' => $request->boolean('noi_bat') ? 1 : 0,
            'khuyen_mai' => $validated['khuyen_mai'] ?? null,
            'status' => 1,
        ]);

        return redirect()
            ->route('coop-shop.manage.products.index')
            ->with('status', 'Đã thêm sản phẩm mới thành công.');
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

        if (! $product) {
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

        if (! $product) {
            return redirect()
                ->route('coop-shop.manage.products.index')
                ->with('status', 'Sản phẩm không tồn tại hoặc đã bị xóa.');
        }

        DB::table('san_pham_bhx')
            ->where('id', $id)
            ->update([
                'status' => 0,
            ]);

        return redirect()
            ->route('coop-shop.manage.products.index')
            ->with('status', 'Đã xóa sản phẩm thành công.');
    }
}
