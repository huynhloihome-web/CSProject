<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopManageProductController;

class CoopShopController extends Controller
{
    public function index(Request $request)
    {
        $sort = $this->getSort($request);

        $categories = DB::table('danh_muc')
            ->orderBy('id', 'asc')
            ->get();

        $query = DB::table('san_pham_bhx')
            ->select(
                'id',
                'tieu_de',
                'gia_goc',
                'gia_ban',
                'ton_kho',
                'hinh_anh',
                'don_vi_tinh',
                'khuyen_mai',
                'danh_muc_id',
                'status'
            )
            ->where('status', 1);

        if ($sort !== '') {
            $query->orderBy('gia_ban', $sort);
        } else {
            $query->orderBy('id', 'asc');
        }

        $products = $query->limit(20)->get();

        $pageTitle = 'Sản phẩm nổi bật';
        $activeCategoryId = 0;

        return view('coop-shop.index', compact(
            'categories',
            'products',
            'pageTitle',
            'activeCategoryId',
            'sort'
        ));
    }

    public function category(Request $request, $id)
    {
        $sort = $this->getSort($request);

        $categories = DB::table('danh_muc')
            ->orderBy('id', 'asc')
            ->get();

        $category = DB::table('danh_muc')
            ->where('id', $id)
            ->first();

        if (!$category) {
            abort(404);
        }

        $query = DB::table('san_pham_bhx')
            ->select(
                'id',
                'tieu_de',
                'gia_goc',
                'gia_ban',
                'ton_kho',
                'hinh_anh',
                'don_vi_tinh',
                'khuyen_mai',
                'danh_muc_id',
                'status'
            )
            ->where('status', 1)
            ->where('danh_muc_id', $id);

        if ($sort !== '') {
            $query->orderBy('gia_ban', $sort);
        } else {
            $query->orderBy('id', 'asc');
        }

        $products = $query->get();

        $pageTitle = $category->ten;
        $activeCategoryId = (int) $id;

        return view('coop-shop.index', compact(
            'categories',
            'products',
            'pageTitle',
            'activeCategoryId',
            'sort'
        ));
    }

    public function login()
    {
        if (Route::has('login')) {
            return redirect()->route('login');
        }

        return redirect()->route('coop-shop.home');
    }

    public function cart()
    {
        if (Route::has('coop-shop.cart')) {
            return redirect()->route('coop-shop.cart');
        }

        return redirect()->route('coop-shop.home');
    }

    private function getSort(Request $request): string
    {
        $sort = $request->input('sort');

        if ($sort === 'asc' || $sort === 'desc') {
            return $sort;
        }

        return '';
    }
}
