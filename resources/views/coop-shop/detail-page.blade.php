<x-coop-layout :title="$product->tieu_de">
    <style>
        .detail-status-message{
            margin-bottom:18px;
            background:#dcfce7;
            color:#166534;
            border:1px solid #86efac;
            padding:12px 16px;
            border-radius:10px;
            font-weight:600;
        }

        .detail-content-wrapper{
            background:#ffffff;
            border-radius:18px;
            box-shadow:0 10px 24px rgba(15, 23, 42, 0.06);
            padding:28px;
            margin-bottom:28px;
        }

        .detail-grid{
            display:grid;
            grid-template-columns:460px 1fr;
            gap:32px;
            align-items:start;
        }

        .detail-image-box{
            background:#ffffff;
            border:1px solid #ececec;
            border-radius:18px;
            padding:20px;
            min-height:420px;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .detail-image-box img{
            width:100%;
            max-height:380px;
            object-fit:contain;
            object-position:center;
        }

        .detail-title{
            font-size:34px;
            font-weight:800;
            line-height:1.35;
            margin-bottom:18px;
            color:#213047;
        }

        .detail-meta{
            margin-bottom:10px;
            font-size:17px;
            color:#334155;
            line-height:1.6;
        }

        .detail-promo{
            margin:14px 0;
            color:#0a8f34;
            font-weight:700;
            font-size:18px;
            line-height:1.6;
        }

        .detail-price{
            font-size:42px;
            color:#f36a1e;
            font-weight:800;
            line-height:1.1;
            margin-top:14px;
        }

        .detail-price-row{
            display:flex;
            align-items:center;
            gap:14px;
            flex-wrap:wrap;
        }

        .detail-stock{
            margin-top:14px;
            padding:8px 12px;
            border-radius:999px;
            background:#ecfdf3;
            color:#15803d;
            font-size:15px;
            font-weight:700;
            line-height:1;
        }

        .detail-old-price{
            margin-top:8px;
            color:#94a3b8;
            text-decoration:line-through;
            font-size:22px;
        }

        .detail-form{
            margin-top:26px;
            padding-top:22px;
            border-top:1px solid #e5e7eb;
        }

        .detail-form label{
            display:block;
            font-weight:700;
            margin-bottom:8px;
            color:#213047;
        }

        .detail-form input[type="number"]{
            width:120px;
            height:44px;
            border:1px solid #dbe1e8;
            border-radius:10px;
            padding:0 12px;
            margin-right:12px;
            outline:none;
        }

        .add-cart-btn{
            height:44px;
            border:none;
            background:#08be46;
            color:#ffffff;
            padding:0 22px;
            border-radius:10px;
            font-weight:700;
            cursor:pointer;
        }

        .add-cart-btn:hover{
            background:#05a63c;
        }

        .detail-desc{
            margin-top:26px;
            background:#f8fafc;
            border-radius:14px;
            padding:18px 20px;
            color:#334155;
            line-height:1.75;
        }

        .detail-desc-title{
            font-size:20px;
            font-weight:800;
            margin-bottom:12px;
            color:#213047;
        }

        .related-title{
            margin:0;
            font-size:2rem;
            font-weight:800;
            color:#213047;
        }

        @media(max-width:1100px){
            .detail-grid{
                grid-template-columns:1fr;
            }
        }

        @media(max-width:640px){
            .detail-title{
                font-size:28px;
            }

            .detail-price{
                font-size:34px;
            }

            .detail-content-wrapper{
                padding:18px;
            }
        }
    </style>

    <div class="shop-page">
        <x-category-sidebar
            :categories="$categories"
            :activeCategoryId="$activeCategoryId"
            :sort="$sort"
        />

        <section class="featured-products">
            @if(session('status'))
                <div class="detail-status-message">
                    {{ session('status') }}
                </div>
            @endif

            <div class="detail-content-wrapper">
                <div class="detail-grid">
                    <div class="detail-image-box">
                        <img src="{{ $product->hinh_anh }}" alt="{{ $product->tieu_de }}">
                    </div>

                    <div>
                        <div class="detail-title">{{ $product->tieu_de }}</div>

                        @if(!empty($product->ten_sp))
                            <div class="detail-meta">
                                <b>Tên ngắn:</b> {{ $product->ten_sp }}
                            </div>
                        @endif

                        @if(!empty($product->thuong_hieu))
                            <div class="detail-meta">
                                <b>Thương hiệu:</b> {{ $product->thuong_hieu }}
                            </div>
                        @endif

                        @if(!empty($product->xuat_xu))
                            <div class="detail-meta">
                                <b>Xuất xứ:</b> {{ $product->xuat_xu }}
                            </div>
                        @endif

                        <div class="detail-meta">
                            <b>Đơn vị tính:</b> {{ $product->don_vi_tinh }}
                        </div>

                        @if(!empty($product->trong_luong))
                            <div class="detail-meta">
                                <b>Khối lượng:</b> {{ $product->trong_luong }}
                            </div>
                        @endif

                        @if(!empty($product->bao_quan))
                            <div class="detail-meta">
                                <b>Bảo quản:</b> {{ $product->bao_quan }}
                            </div>
                        @endif

                        <div class="detail-promo">
                            Khuyến mãi:
                            @if(!empty($product->khuyen_mai))
                                {{ $product->khuyen_mai }}
                            @else
                                Không có
                            @endif
                        </div>

                        <div class="detail-price-row">
                            <div class="detail-price">
                                {{ number_format($product->gia_ban, 0, ',', '.') }}đ
                            </div>
                            <div class="detail-stock">
                                Tồn kho: {{ (int) ($product->ton_kho ?? 0) }}
                            </div>
                        </div>

                        @if(!empty($product->gia_goc))
                            <div class="detail-old-price">
                                {{ number_format($product->gia_goc, 0, ',', '.') }}đ
                            </div>
                        @endif

                        <div class="detail-form">
                            <form method="post" action="{{ route('coop-shop.cart.add') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">

                                <label>Số lượng mua</label>

                                <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                                    <input type="number" name="num" min="1" value="1">
                                    <button type="submit" class="add-cart-btn">Thêm vào giỏ hàng</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @if(!empty($product->mo_ta) || !empty($product->thanh_phan))
                    <div class="detail-desc">
                        <div class="detail-desc-title">Thông tin sản phẩm</div>

                        @if(!empty($product->mo_ta))
                            <div>
                                <b>Mô tả:</b> {{ $product->mo_ta }}
                            </div>
                        @endif

                        @if(!empty($product->thanh_phan))
                            <div style="margin-top:12px;">
                                <b>Thành phần:</b> {{ $product->thanh_phan }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="section-heading">
                <h2 class="related-title">Sản phẩm liên quan</h2>
            </div>

            <div class="product-grid">
                @forelse($relatedProducts as $row)
                    <x-product-card :product="$row" />
                @empty
                    <div class="empty-state">
                        Chưa có sản phẩm liên quan.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</x-coop-layout>
