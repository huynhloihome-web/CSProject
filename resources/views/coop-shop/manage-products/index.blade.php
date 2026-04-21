<x-coop-layout title="Quản lý sản phẩm">
    <style>
        .manage-wrapper {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            padding: 24px;
        }

        .manage-title {
            text-align: center;
            font-size: 32px;
            font-weight: 800;
            color: #2563eb;
            margin-bottom: 20px;
        }

        .status-message {
            margin-bottom: 18px;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
            padding: 12px 16px;
            border-radius: 10px;
            font-weight: 600;
        }

        .admin-thumb {
            width: 56px;
            height: 56px;
            object-fit: contain;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 4px;
        }

        .action-group {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-view {
            display: inline-block;
            padding: 8px 12px;
            background: #0d6efd;
            color: #ffffff;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-delete {
            border: none;
            padding: 8px 12px;
            background: #dc3545;
            color: #ffffff;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }

        table.dataTable thead th {
            white-space: nowrap;
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 6px 8px;
            background: #fff;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #08be46 !important;
            color: #fff !important;
            border-color: #08be46 !important;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

    @if(session('status'))
        <div class="status-message">
            {{ session('status') }}
        </div>
    @endif

    <div class="manage-wrapper">
        <div class="manage-title">QUẢN LÝ SẢN PHẨM</div>

        <table id="manage-product-table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th>Tên ngắn</th>
                    <th>Đơn vị tính</th>
                    <th>Khuyến mãi</th>
                    <th>Giá gốc</th>
                    <th>Giá bán</th>
                    <th>Ảnh</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $row)
                    <tr>
                        <td>{{ $row->tieu_de }}</td>
                        <td>{{ $row->ten_sp }}</td>
                        <td>{{ $row->don_vi_tinh }}</td>
                        <td>{{ $row->khuyen_mai ?: 'Không có' }}</td>
                        <td>{{ number_format((float) $row->gia_goc, 0, ',', '.') }}đ</td>
                        <td>{{ number_format((float) $row->gia_ban, 0, ',', '.') }}đ</td>
                        <td>
                            <img src="{{ $row->hinh_anh }}" alt="{{ $row->tieu_de }}" class="admin-thumb">
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('coop-shop.manage.products.show', $row->id) }}" class="btn-view">
                                    Xem
                                </a>

                                <form method="POST" action="{{ route('coop-shop.manage.products.destroy', $row->id) }}" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                    @csrf
                                    <button type="submit" class="btn-delete">Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#manage-product-table').DataTable({
                pageLength: 10,
                language: {
                    lengthMenu: "_MENU_ mục mỗi trang",
                    search: "Tìm kiếm:",
                    zeroRecords: "Không tìm thấy dữ liệu phù hợp",
                    info: "Hiển thị _START_ đến _END_ của _TOTAL_ sản phẩm",
                    infoEmpty: "Không có dữ liệu",
                    infoFiltered: "(lọc từ _MAX_ sản phẩm)",
                    paginate: {
                        first: "Đầu",
                        last: "Cuối",
                        next: "Sau",
                        previous: "Trước"
                    }
                }
            });
        });
    </script>
</x-coop-layout>