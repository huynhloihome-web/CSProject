<x-coop-layout>

<div class="featured-products">

    <div class="section-heading">
        <h1>Quản lý đơn hàng</h1>
    </div>

    {{-- FILTER --}}
    <div style="margin-bottom:20px; display:flex; gap:10px; flex-wrap:wrap;">

        {{-- TẤT CẢ --}}
        <a href="{{ route('admin.orders') }}"
            style="
                background: {{ request('status') == null ? '#084298' : '#0d6efd' }};
                color:white;
                padding:8px 14px;
                border-radius:8px;
                text-decoration:none;
                font-weight:500;
            "
        >
            Tất cả
        </a>

        {{-- ĐANG GIAO --}}
        <a href="?status=shipping"
            style="
                background: {{ request('status') == 'shipping' ? '#495057' : '#6c757d' }};
                color:white;
                padding:8px 14px;
                border-radius:8px;
                text-decoration:none;
                font-weight:500;
            "
        >
            🚚 Đang giao
        </a>

        {{-- ĐÃ GIAO --}}
        <a href="?status=received"
            style="
                background: {{ request('status') == 'received' ? '#1e7e34' : '#28a745' }};
                color:white;
                padding:8px 14px;
                border-radius:8px;
                text-decoration:none;
                font-weight:500;
            "
        >
            ✅ Đã giao
        </a>

        {{-- TRẢ HÀNG --}}
        <a href="?status=returning"
            style="
                background: {{ request('status') == 'returning' ? '#a71d2a' : '#dc3545' }};
                color:white;
                padding:8px 14px;
                border-radius:8px;
                text-decoration:none;
                font-weight:500;
            "
        >
            🔄 Trả hàng
        </a>

    </div>

    {{-- DANH SÁCH --}}
    @forelse($orders as $order)
        <div class="product-card" style="margin-bottom:15px;">
            <div class="product-card__body">

                <h3 class="product-card__title">
                    Mã đơn: #{{ $order->ma_don_hang }}
                </h3>

                <p>
                    <strong>💰 Tổng tiền:</strong>
                    {{ number_format($order->tong_tien) }} đ
                </p>

                <p>
                    <strong>Trạng thái:</strong>

                    @if($order->status == 'shipping')
                        <span style="color:#6c757d;">🚚 Đang giao</span>
                    @elseif($order->status == 'received')
                        <span style="color:#28a745;">✅ Đã giao</span>
                    @elseif($order->status == 'returning')
                        <span style="color:#dc3545;">🔄 Yêu cầu trả hàng</span>
                    @elseif($order->status == 'refunded')
                        <span style="color:#0d6efd;">💸 Đã hoàn tiền</span>
                    @endif
                </p>

                {{-- NÚT XEM CHI TIẾT --}}
                <div style="margin-top:10px;">
                    <a href="{{ route('admin.orders.show', $order->ma_don_hang) }}"
                        style="
                            background:#0d6efd;
                            color:white;
                            padding:6px 12px;
                            border-radius:6px;
                            text-decoration:none;
                            font-size:14px;
                        "
                    >
                        Xem chi tiết
                    </a>
                </div>

            </div>
        </div>
    @empty
        <p>Không có đơn hàng nào.</p>
    @endforelse

</div>

</x-coop-layout>