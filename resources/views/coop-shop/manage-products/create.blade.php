<x-coop-layout title="Thêm sản phẩm">
    <style>
        .create-product-wrapper {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            padding: 28px;
        }

        .create-product-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .create-product-title {
            font-size: 30px;
            font-weight: 800;
            color: #213047;
            margin: 0;
        }

        .create-product-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border-radius: 8px;
            background: #e2e8f0;
            color: #1e293b;
            text-decoration: none;
            font-weight: 700;
        }

        .create-product-form {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group--full {
            grid-column: 1 / -1;
        }

        .form-label {
            font-weight: 700;
            color: #334155;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 15px;
            color: #0f172a;
            background: #ffffff;
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #08be46;
            box-shadow: 0 0 0 3px rgba(8, 190, 70, 0.15);
        }

        .form-error {
            color: #dc2626;
            font-size: 14px;
            font-weight: 600;
        }

        .form-hint {
            color: #64748b;
            font-size: 13px;
        }

        .form-checkbox {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            color: #334155;
        }

        .form-checkbox input {
            width: 18px;
            height: 18px;
        }

        .form-actions {
            grid-column: 1 / -1;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 8px;
        }

        .btn-save {
            border: none;
            padding: 12px 22px;
            border-radius: 10px;
            background: #08be46;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }

        .validation-summary {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 10px;
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #991b1b;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .create-product-form {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="create-product-wrapper">
        <div class="create-product-header">
            <h1 class="create-product-title">Thêm sản phẩm mới</h1>
            <a href="{{ route('coop-shop.manage.products.index') }}" class="create-product-back">Quay lại danh sách</a>
        </div>

        @if ($errors->any())
        <div class="validation-summary">
            Vui lòng kiểm tra lại thông tin sản phẩm trước khi lưu.
        </div>
        @endif

        <form method="POST" action="{{ route('coop-shop.manage.products.store') }}" class="create-product-form">
            @csrf

            <div class="form-group">
                <label for="ma_sp" class="form-label">Mã sản phẩm</label>
                <input id="ma_sp" name="ma_sp" type="text" class="form-input" value="{{ old('ma_sp') }}" maxlength="50">
                <div class="form-hint">Có thể để trống, hệ thống sẽ tự tạo mã.</div>
                @error('ma_sp')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="danh_muc_id" class="form-label">Danh mục</label>
                <select id="danh_muc_id" name="danh_muc_id" class="form-select" required>
                    <option value="">Chọn danh mục</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('danh_muc_id') == $category->id)>{{ $category->ten }}</option>
                    @endforeach
                </select>
                @error('danh_muc_id')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group form-group--full">
                <label for="tieu_de" class="form-label">Tiêu đề sản phẩm</label>
                <input id="tieu_de" name="tieu_de" type="text" class="form-input" value="{{ old('tieu_de') }}" maxlength="500" required>
                @error('tieu_de')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="ten_sp" class="form-label">Tên ngắn</label>
                <input id="ten_sp" name="ten_sp" type="text" class="form-input" value="{{ old('ten_sp') }}" maxlength="255" required>
                @error('ten_sp')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="hinh_anh" class="form-label">URL hình ảnh</label>
                <input id="hinh_anh" name="hinh_anh" type="url" class="form-input" value="{{ old('hinh_anh') }}" maxlength="500" required>
                @error('hinh_anh')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="gia_goc" class="form-label">Giá gốc</label>
                <input id="gia_goc" name="gia_goc" type="number" min="0" step="0.01" class="form-input" value="{{ old('gia_goc') }}" required>
                @error('gia_goc')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="gia_ban" class="form-label">Giá bán</label>
                <input id="gia_ban" name="gia_ban" type="number" min="0" step="0.01" class="form-input" value="{{ old('gia_ban') }}" required>
                @error('gia_ban')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="don_vi_tinh" class="form-label">Đơn vị tính</label>
                <input id="don_vi_tinh" name="don_vi_tinh" type="text" class="form-input" value="{{ old('don_vi_tinh') }}" maxlength="50" required>
                @error('don_vi_tinh')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="trong_luong" class="form-label">Trọng lượng</label>
                <input id="trong_luong" name="trong_luong" type="text" class="form-input" value="{{ old('trong_luong') }}" maxlength="50">
                @error('trong_luong')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="thuong_hieu" class="form-label">Thương hiệu</label>
                <input id="thuong_hieu" name="thuong_hieu" type="text" class="form-input" value="{{ old('thuong_hieu') }}" maxlength="100">
                @error('thuong_hieu')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="xuat_xu" class="form-label">Xuất xứ</label>
                <input id="xuat_xu" name="xuat_xu" type="text" class="form-input" value="{{ old('xuat_xu') }}" maxlength="100">
                @error('xuat_xu')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="bao_quan" class="form-label">Bảo quản</label>
                <input id="bao_quan" name="bao_quan" type="text" class="form-input" value="{{ old('bao_quan') }}" maxlength="100">
                @error('bao_quan')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="khuyen_mai" class="form-label">Khuyến mãi</label>
                <textarea id="khuyen_mai" name="khuyen_mai" class="form-textarea">{{ old('khuyen_mai') }}</textarea>
                @error('khuyen_mai')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group form-group--full">
                <label for="thanh_phan" class="form-label">Thành phần</label>
                <textarea id="thanh_phan" name="thanh_phan" class="form-textarea">{{ old('thanh_phan') }}</textarea>
                @error('thanh_phan')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group form-group--full">
                <label for="mo_ta" class="form-label">Mô tả</label>
                <textarea id="mo_ta" name="mo_ta" class="form-textarea">{{ old('mo_ta') }}</textarea>
                @error('mo_ta')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group form-group--full">
                <label class="form-checkbox" for="noi_bat">
                    <input id="noi_bat" name="noi_bat" type="checkbox" value="1" @checked(old('noi_bat'))>
                    Đánh dấu là sản phẩm nổi bật
                </label>
                @error('noi_bat')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Lưu sản phẩm</button>
            </div>
        </form>
    </div>
</x-coop-layout>
