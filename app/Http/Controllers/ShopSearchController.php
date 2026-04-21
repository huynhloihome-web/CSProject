<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopSearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim((string) $request->input('keyword', ''));

        $categories = DB::table('danh_muc')
            ->orderBy('id', 'asc')
            ->get();

        $products = collect();

        if ($keyword !== '') {

            // escape đơn giản tránh lỗi SQL
            $kw = addslashes($keyword);

            $products = DB::table('san_pham_bhx')
                ->select(
                    'id',
                    'tieu_de',
                    'gia_goc',
                    'gia_ban',
                    'hinh_anh',
                    'don_vi_tinh',
                    'khuyen_mai',
                    'danh_muc_id',
                    DB::raw("
                        CASE
                            WHEN tieu_de COLLATE utf8mb4_bin LIKE '$kw%' THEN 1
                            WHEN tieu_de REGEXP '(^|[[:space:]])$kw([[:space:]]|$)' THEN 2
                            WHEN tieu_de COLLATE utf8mb4_bin LIKE '%$kw%' THEN 3
                            WHEN tieu_de LIKE '%$kw%' THEN 4
                            ELSE 5
                        END as relevance
                    ")
                )
                ->where(function ($query) use ($keyword) {
                    $query->whereRaw("tieu_de COLLATE utf8mb4_bin LIKE ?", [$keyword . '%'])
                          ->orWhereRaw("tieu_de REGEXP ?", ['(^|[[:space:]])' . $keyword . '([[:space:]]|$)'])
                          ->orWhereRaw("tieu_de COLLATE utf8mb4_bin LIKE ?", ['%' . $keyword . '%'])
                          ->orWhere('tieu_de', 'like', '%' . $keyword . '%');
                })
                ->orderBy('relevance', 'asc')
                ->orderBy('id', 'desc')
                ->get();
        }

        $pageTitle = $keyword !== ''
            ? 'Kết quả tìm kiếm cho: ' . $keyword
            : 'Tìm kiếm sản phẩm';

        $activeCategoryId = 0;
        $sort = '';

        return view('coop-shop.search-page', compact(
            'categories',
            'products',
            'pageTitle',
            'activeCategoryId',
            'sort',
            'keyword'
        ));
    }
}