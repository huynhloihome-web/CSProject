<x-coop-layout title="Giỏ hàng">
    <style>
        .cart-wrapper{
            background:#ffffff;
            border-radius:18px;
            box-shadow:0 10px 24px rgba(15, 23, 42, 0.06);
            padding:24px;
        }

        .cart-title{
            font-size:32px;
            font-weight:800;
            margin-bottom:20px;
            color:#213047;
        }

        .cart-table{
            width:100%;
            border-collapse:collapse;
        }

        .cart-table th,
        .cart-table td{
            border-bottom:1px solid #e5e7eb;
            padding:14px 10px;
            vertical-align:middle;
        }

        .cart-table th{
            text-align:left;
            font-size:15px;
            color:#475569;
        }

        .cart-product{
            display:flex;
            align-items:center;
            gap:14px;
        }

        .cart-product img{
            width:90px;
            height:90px;
            object-fit:contain;
            background:#fff;
            border:1px solid #ececec;
            border-radius:10px;
            padding:6px;
        }

        .cart-product-name{
            font-weight:700;
            color:#213047;
        }

        .cart-promo{
            color:#0a8f34;
            font-size:14px;
            font-weight:600;
            margin-top:6px;
        }

        .cart-total{
            text-align:right;
            margin-top:22px;
            font-size:28px;
            font-weight:800;
            color:#f36a1e;
        }

        .cart-remove-btn{
            border:none;
            background:#ef4444;
            color:#ffffff;
            padding:10px 14px;
            border-radius:8px;
            font-weight:700;
            cursor:pointer;
        }

        .cart-order-box{
            margin-top:24px;
            text-align:center;
            padding-top:20px;
            border-top:1px solid #e5e7eb;
        }

        .cart-order-box select{
            width:220px;
            height:42px;
            border:1px solid #d1d5db;
            border-radius:8px;
            padding:0 10px;
            margin-bottom:12px;
            outline:none;
        }

        .cart-order-btn{
            border:none;
            background:#2563eb;
            color:white;
            padding:10px 18px;
            border-radius:8px;
            font-weight:700;
            cursor:pointer;
        }

        .empty-cart{
            text-align:center;
            padding:40px 20px;
            color:#64748b;
            font-weight:600;
            background:#ffffff;
            border-radius:18px;
            box-shadow:0 10px 24px rgba(15, 23, 42, 0.06);
        }

        .status-message{
            margin-bottom:18px;
            background:#dcfce7;
            color:#166534;
            border:1px solid #86efac;
            padding:12px 16px;
            border-radius:10px;
            font-weight:600;
        }

        .error-box{
            margin-bottom:18px;
            background:#fef2f2;
            color:#b91c1c;
            border:1px solid #fecaca;
            padding:12px 16px;
            border-radius:10px;
        }

        @media(max-width:768px){
            .cart-table,
            .cart-table thead,
            .cart-table tbody,
            .cart-table tr,
            .cart-table th,
            .cart-table td{
                display:block;
                width:100%;
            }

            .cart-table thead{
                display:none;
            }

            .cart-table td{
                border-bottom:none;
                padding:10px 0;
            }

            .cart-table tr{
                border-bottom:1px solid #e5e7eb;
                padding:12px 0;
            }
        }
    </style>

    @if(session('status'))
        <div class="status-message">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error-box">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if(count($products) > 0)
        <div class="cart-wrapper">
            <div class="cart-title">Giỏ hàng</div>

            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $row)
                        <tr>
                            <td>
                                <div class="cart-product">
                                    <img src="{{ $row->hinh_anh }}" alt="{{ $row->tieu_de }}">
                                    <div>
                                        <div class="cart-product-name">{{ $row->tieu_de }}</div>
                                        <div>Đơn vị tính: {{ $row->don_vi_tinh }}</div>
                                        <div class="cart-promo">
                                            Khuyến mãi:
                                            @if(!empty($row->khuyen_mai))
                                                {{ $row->khuyen_mai }}
                                            @else
                                                Không có
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $quantities[$row->id] }}</td>
                            <td>{{ number_format($row->gia_ban, 0, ',', '.') }}đ</td>
                            <td>{{ number_format($row->gia_ban * $quantities[$row->id], 0, ',', '.') }}đ</td>
                            <td>
                                <form method="post" action="{{ route('coop-shop.cart.remove') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $row->id }}">
                                    <button type="submit" class="cart-remove-btn">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="cart-total">
                Tổng cộng: {{ number_format($totalMoney, 0, ',', '.') }}đ
            </div>

            <div class="cart-order-box">
                @auth
                    <form method="post" action="{{ route('coop-shop.order.store') }}">
                        @csrf

                        <div style="font-weight:bold; margin-bottom:8px;">Hình thức thanh toán</div>
                        <select name="hinh_thuc_thanh_toan">
                            <option value="1">Tiền mặt</option>
                            <option value="2">Chuyển khoản</option>
                            <option value="3">Thanh toán VNPay</option>
                        </select>
                        <br>

                        <button type="submit" class="cart-order-btn">ĐẶT HÀNG</button>
                    </form>
                @else
                    <div style="font-weight:bold; color:#dc2626;">
                        Vui lòng đăng nhập trước khi đặt hàng
                    </div>
                @endauth
            </div>
        </div>
    @else
        <div class="empty-cart">
            Giỏ hàng của bạn đang trống.
        </div>
    @endif
</x-coop-layout>