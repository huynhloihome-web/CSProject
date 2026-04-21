<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Đặt hàng thành công</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            color:#1f2937;
        }
        .wrap{
            width:80%;
            margin:0 auto;
        }
        .title{
            text-align:center;
            font-size:22px;
            font-weight:bold;
            color:#08be46;
            margin-bottom:20px;
        }
        .info{
            margin-bottom:20px;
            line-height:1.8;
        }
        .order-table{
            width:100%;
            border-collapse:collapse;
        }
        .order-table th,
        .order-table td{
            border:1px solid #d1d5db;
            padding:10px;
        }
        .order-table th{
            background:#f3f4f6;
        }
        .total{
            text-align:right;
            font-size:18px;
            font-weight:bold;
            color:#f36a1e;
            margin-top:16px;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="title">ĐẶT HÀNG THÀNH CÔNG</div>

        <div class="info">
            Xin chào <b>{{ $tenKhachHang }}</b>,<br>
            Bạn đã đặt hàng thành công tại <b>Coop Shop</b>.<br>
            Mã đơn hàng: <b>#{{ $maDonHang }}</b><br>
            Hình thức thanh toán: <b>{{ $hinhThucThanhToan }}</b>
        </div>

        <table class="order-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $row)
                    <tr>
                        <td align="center">{{ $key + 1 }}</td>
                        <td>{{ $row->tieu_de }}</td>
                        <td align="center">{{ $row->so_luong }}</td>
                        <td align="right">{{ number_format($row->gia_ban, 0, ',', '.') }}đ</td>
                        <td align="right">{{ number_format($row->thanh_tien, 0, ',', '.') }}đ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            Tổng cộng: {{ number_format($tongTien, 0, ',', '.') }}đ
        </div>
    </div>
</body>
</html>