<x-coop-layout title="Xác nhận đơn hàng">

<style>
.checkout-wrapper{
background:#ffffff;
border-radius:18px;
box-shadow:0 10px 24px rgba(15, 23, 42, 0.06);
padding:24px;
}

.checkout-title{
font-size:32px;
font-weight:800;
margin-bottom:20px;
color:#213047;
}

.section-title{
font-weight:700;
font-size:18px;
margin-bottom:10px;
color:#213047;
}

.address-box{
border:1px solid #e5e7eb;
border-radius:12px;
padding:16px;
margin-bottom:20px;
background:#f8fafc;
}

.product-table{
width:100%;
border-collapse:collapse;
}

.product-table th,
.product-table td{
border-bottom:1px solid #e5e7eb;
padding:12px;
text-align:left;
}

.total-box{
text-align:right;
font-size:24px;
font-weight:800;
color:#f36a1e;
margin-top:16px;
}

.confirm-btn{
margin-top:20px;
background:#2563eb;
color:white;
border:none;
padding:12px 22px;
border-radius:8px;
font-weight:700;
cursor:pointer;
}

.back-btn{
margin-top:20px;
margin-right:10px;
background:#64748b;
color:white;
border:none;
padding:12px 22px;
border-radius:8px;
font-weight:700;
cursor:pointer;
}
</style>

<div class="checkout-wrapper">

<div class="checkout-title">
Xác nhận đơn hàng
</div>

<!-- ✅ FIX Ở ĐÂY -->
<form method="POST" action="{{ route('coop-shop.order.store') }}">
@csrf

<input type="hidden" name="address_id" value="{{ $address->id }}">
<input type="hidden" name="hinh_thuc_thanh_toan" value="{{ $payment }}">

<div class="section-title">
Địa chỉ giao hàng
</div>

<div class="address-box">

<div>
<b>{{ $address->ho_ten }}</b>
- {{ $address->so_dien_thoai }}
</div>

<div>
{{ $address->dia_chi_chi_tiet }},
{{ $address->phuong_xa }},
{{ $address->quan_huyen }},
{{ $address->tinh_thanh }}
</div>

</div>

<div class="section-title">
Sản phẩm
</div>

<table class="product-table">
<thead>
<tr>
<th>Tên sản phẩm</th>
<th>Số lượng</th>
<th>Đơn giá</th>
<th>Thành tiền</th>
</tr>
</thead>

<tbody>

@foreach($products as $row)

<tr>
<td>{{ $row->tieu_de }}</td>
<td>{{ $cart[$row->id] }}</td>
<td>{{ number_format($row->gia_ban,0,',','.') }}đ</td>
<td>
{{ number_format($row->gia_ban * $cart[$row->id],0,',','.') }}đ
</td>
</tr>

@endforeach

</tbody>
</table>

<div class="total-box">
Tổng tiền: {{ number_format($total,0,',','.') }}đ
</div>

<button type="button"
onclick="history.back()"
class="back-btn">
Quay lại
</button>

<button type="submit" class="confirm-btn">
XÁC NHẬN ĐẶT HÀNG
</button>

</form>

</div>

</x-coop-layout>