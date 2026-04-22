<x-coop-layout title="Thanh toán">

<style>
.checkout{
display:grid;
grid-template-columns: 1.4fr 0.6fr;
gap:20px;
}

.card{
background:#fff;
border-radius:14px;
padding:18px;
box-shadow:0 6px 20px rgba(0,0,0,0.05);
}

.title{
font-size:20px;
font-weight:700;
margin-bottom:15px;
}

.address-item{
border:1px solid #e5e7eb;
border-radius:10px;
padding:14px;
margin-bottom:10px;
display:flex;
gap:10px;
cursor:pointer;
transition:.2s;
}

.address-item:hover{
border-color:#22c55e;
background:#f0fdf4;
}

.address-default{
background:#22c55e;
color:white;
padding:2px 6px;
border-radius:6px;
font-size:12px;
margin-left:6px;
}

.add-address{
margin-top:10px;
border:1px dashed #22c55e;
background:#f0fdf4;
padding:12px;
border-radius:10px;
cursor:pointer;
font-weight:600;
}

.form-address{
margin-top:12px;
display:none;
}

.form-address input{
width:100%;
height:40px;
margin-bottom:8px;
border:1px solid #ddd;
border-radius:8px;
padding:0 10px;
}

.product{
display:flex;
gap:10px;
margin-bottom:12px;
}

.product img{
width:60px;
height:60px;
object-fit:cover;
border-radius:8px;
border:1px solid #eee;
}

.row{
display:flex;
justify-content:space-between;
margin-bottom:8px;
}

.total{
font-size:22px;
font-weight:700;
color:#ef4444;
}

.btn-main{
width:100%;
background:#22c55e;
color:white;
border:none;
padding:14px;
border-radius:10px;
font-weight:700;
font-size:16px;
cursor:pointer;
}

.voucher{
display:flex;
gap:10px;
}

.voucher input{
flex:1;
height:40px;
border:1px solid #ddd;
border-radius:8px;
padding:0 10px;
}

.voucher button{
background:#22c55e;
color:white;
border:none;
padding:0 16px;
border-radius:8px;
}
</style>


<div class="checkout">

<!-- LEFT -->
<div>

<div class="card">
<div class="title">Địa chỉ nhận hàng</div>

<!-- ✅ FORM CHỌN ĐỊA CHỈ -->
<form method="GET" action="{{ route('coop-shop.checkout.confirm') }}">

<input type="hidden" name="hinh_thuc_thanh_toan" value="{{ session('payment',1) }}">

@foreach($addresses as $item)
<label class="address-item">

<input type="radio"
name="address_id"
value="{{ $item->id }}"
{{ $item->is_default ? 'checked' : '' }}>

<div>
<b>{{ $item->ho_ten }}</b> - {{ $item->so_dien_thoai }}

@if($item->is_default)
<span class="address-default">Mặc định</span>
@endif

<div>
{{ $item->dia_chi_chi_tiet }},
{{ $item->phuong_xa }},
{{ $item->quan_huyen }},
{{ $item->tinh_thanh }}
</div>

</div>

</label>
@endforeach

<button type="submit" class="btn-main">
Tiếp tục xác nhận
</button>

</form>


<!-- ADD ADDRESS BUTTON -->
<div class="add-address" onclick="toggleAddress()">
+ Thêm địa chỉ mới
</div>


<!-- ✅ FORM THÊM ĐỊA CHỈ -->
<form method="POST" action="{{ route('coop-shop.address.store') }}" class="form-address" id="formAddress">
@csrf

<input name="ho_ten" placeholder="Họ tên">
<input name="so_dien_thoai" placeholder="Số điện thoại">
<input name="dia_chi_chi_tiet" placeholder="Địa chỉ chi tiết">
<input name="phuong_xa" placeholder="Phường / Xã">
<input name="quan_huyen" placeholder="Quận / Huyện">
<input name="tinh_thanh" placeholder="Tỉnh / Thành phố">

<label style="display:flex;gap:6px;margin:6px 0;">
<input type="checkbox" name="is_default" value="1">
Đặt làm địa chỉ mặc định
</label>

<button type="submit" class="btn-main">
Lưu địa chỉ
</button>

</form>

</div>


<div class="card">
<div class="title">Mã giảm giá</div>

<div class="voucher">
<input placeholder="Nhập mã giảm giá">
<button type="button">Áp dụng</button>
</div>

</div>

</div>


<!-- RIGHT -->
<div>

<div class="card">
<div class="title">Đơn hàng của bạn</div>

@php
$cart = session('cart',[]);
$total=0;
@endphp

@foreach(DB::table('san_pham_bhx')->whereIn('id',array_keys($cart))->get() as $p)

@php
$line = $p->gia_ban * $cart[$p->id];
$total += $line;
@endphp

<div class="product">

<img src="{{ $p->hinh_anh }}">

<div style="flex:1">
<div>{{ $p->tieu_de }}</div>
<div style="color:#64748b">
x {{ $cart[$p->id] }}
</div>
</div>

<div>
{{ number_format($line,0,',','.') }}đ
</div>

</div>

@endforeach

<hr>

<div class="row">
<div>Tạm tính</div>
<div>{{ number_format($total,0,',','.') }}đ</div>
</div>

<div class="row">
<div>Phí vận chuyển</div>
<div>15.000đ</div>
</div>

<div class="row">
<div>Giảm giá</div>
<div>-0đ</div>
</div>

<hr>

<div class="row">
<div><b>Tổng thanh toán</b></div>
<div class="total">
{{ number_format($total+15000,0,',','.') }}đ
</div>
</div>

</div>

</div>

</div>


<script>
function toggleAddress(){
let form = document.getElementById('formAddress');
form.style.display = form.style.display === 'block' ? 'none' : 'block';
}
</script>

</x-coop-layout>