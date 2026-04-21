<x-coop-layout title="Chi tiết sản phẩm">
    <style>
        .manage-detail-wrapper {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            padding: 28px;
        }

        .manage-detail-title {
            font-size: 32px;
            font-weight: 800;
            color: #213047;
            margin-bottom: 20px;
        }

        .manage-detail-grid {
            display: grid;
            grid-template-columns: 420px 1fr;
            gap: 28px;
            align-items: start;
        }

        .manage-detail-image {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 16px;
            min-height: 360px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .manage-detail-image img {
            width: 100%;
            max-height: 320px;
            object-fit: contain;
        }

        .manage-detail-info-item {
            margin-bottom: 12px;
            line-height: 1.7;
            color: #334155;
        }

        .manage-detail-price {
            font-size: 34px;
            color: #f36a1e;
            font-weight: 800;
            margin-top: 10px;
        }

        .manage-detail-old-price {
            margin-top: 8px;
            color: #94a3b8;
            text-decoration: line-through;
            font-size: 20px;
        }

        .manage-detail-back {
            display: inline-block;
            margin-top: 24px;
            padding: 10px 16px;
            border-radius: 8px;
            background: #08be46;
            color: #fff;
            font-weight: 700;
            text-decoration: none;
        }

        @media(max-width: 992px) {
            .manage-detail-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="manage-detail-wrapper">
        <div class="manage-detail-title">Chi tiết sản phẩm</div>

        <div class="manage-detail-grid">
            <div class="manage-detail-image">
                <img src="{{ $product->hinh_anh }}" alt="{{ $product->tieu_de }}">
            </div>

            <div>
                <div class="manage-detail-info-item"><b>Tiêu đề:</b> {{ $product->tieu_de }}</div>
                <div class="manage-detail-info-item"><b>Tên ngắn:</b> {{ $product->ten_sp }}</div>
                <div class="manage-detail-info-item"><b>Đơn vị tính:</b> {{ $product->don_vi_tinh }}</div>
                <div class="manage-detail-info-item"><b>Khối lượng:</b> {{ $product->trong_luong }}</div>
                <div class="manage-detail-info-item"><b>Khuyến mãi:</b> {{ $product->khuyen_mai ?: 'Không có' }}</div>
                <div class="manage-detail-info-item"><b>Thương hiệu:</b> {{ $product->thuong_hieu }}</div>
                <div class="manage-detail-info-item"><b>Xuất xứ:</b> {{ $product->xuat_xu }}</div>
                <div class="manage-detail-info-item"><b>Bảo quản:</b> {{ $product->bao_quan }}</div>
                <div class="manage-detail-info-item"><b>Thành phần:</b> {{ $product->thanh_phan }}</div>
                <div class="manage-detail-info-item"><b>Mô tả:</b> {{ $product->mo_ta }}</div>

                <div class="manage-detail-price">
                    {{ number_format((float) $product->gia_ban, 0, ',', '.') }}đ
                </div>

                <div class="manage-detail-old-price">
                    {{ number_format((float) $product->gia_goc, 0, ',', '.') }}đ
                </div>

                <a href="{{ route('coop-shop.manage.products.index') }}" class="manage-detail-back">
                    Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</x-coop-layout>