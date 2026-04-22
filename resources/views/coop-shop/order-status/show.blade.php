<x-coop-layout>

<div class="featured-products">

    <div class="section-heading">
        <h1>📦 Chi tiết đơn hàng</h1>
    </div>

    <div class="product-card">
        <div class="product-card__body">

            <h3 class="product-card__title">
                Mã đơn: #{{ $order->ma_don_hang }}
            </h3>

            <p><strong>👤 Tên:</strong> {{ $order->ten_nguoi_nhan ?? '---' }}</p>
            <p><strong>📞 SĐT:</strong> {{ $order->so_dien_thoai ?? '---' }}</p>
            <p><strong>📍 Địa chỉ:</strong> {{ $order->dia_chi ?? '---' }}</p>

            <hr>

            <h4>🛒 Sản phẩm:</h4>

            <table style="width:100%; border-collapse:collapse; font-size:14px;">
    
                <thead>
                    <tr style="border-bottom:1px solid #ccc;">
                        <th style="text-align:left;">Sản phẩm</th>
                        <th style="text-align:center;">SL</th>
                        <th style="text-align:right;">Giá</th>
                        <th style="text-align:right;">Thành tiền</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($items as $item)
                        <tr style="border-bottom:1px dashed #ddd;">
                            
                            <td style="padding:6px 0;">
                                {{ $item->ten_sp }}
                            </td>

                            <td style="text-align:center;">
                                {{ $item->so_luong }}
                            </td>

                            <td style="text-align:right;">
                                {{ number_format($item->gia_ban) }}
                            </td>

                            <td style="text-align:right; font-weight:600;">
                                {{ number_format($item->gia_ban * $item->so_luong) }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>

            <hr>

            <p>
                <strong>💰 Tổng tiền:</strong>
                <span style="color: var(--orange); font-weight: bold;">
                    {{ number_format($order->tong_tien) }} đ
                </span>
            </p>

            <hr>

            <p><strong>🚚 Vận chuyển:</strong> Giao hàng qua Lalamove</p>

            <p>
                <strong>📌 Trạng thái:</strong>

                @if($order->status == 'shipping')
                    🚚 Đang vận chuyển
                @elseif($order->status == 'received')
                    ✅ Đã nhận hàng
                @elseif($order->status == 'returning')
                    🔄 Đang trả hàng
                @elseif($order->status == 'refunded')
                    💸 Đã hoàn tiền
                @endif
            </p>

            <hr>

            @if($order->status == 'shipping')
                <form method="POST" action="{{ route('order.received', $order->ma_don_hang) }}">
                    @csrf
                    <button class="buy-btn">
                        Xác nhận đã nhận hàng
                    </button>
                </form>
            @endif

            @if(in_array($order->status, ['shipping','received']))
                <form method="POST" action="{{ route('order.return', $order->ma_don_hang) }}">
                    @csrf
                    <button class="buy-btn" style="background:red">
                        Yêu cầu trả hàng & hoàn tiền
                    </button>
                </form>
            @endif

        </div>
    </div>

</div>

</x-coop-layout>