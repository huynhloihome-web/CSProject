<x-coop-layout>

<div class="featured-products">

    <div class="section-heading">
        <h1>🧾 Đơn hàng của tôi</h1>
    </div>

    <div class="product-grid">

        @foreach($orders as $order)
            <div class="product-card">

                <div class="product-card__body">

                    <h3 class="product-card__title">
                        Mã đơn: #{{ $order->ma_don_hang }}
                    </h3>

                    <div class="product-card__promo">
                        @if($order->status == 'shipping')
                            <span style="color: var(--orange)">🚚 Đang vận chuyển</span>
                        @else
                            <span style="color: var(--green-text)">✅ Đã nhận hàng</span>
                        @endif
                    </div>

                    <div class="product-card__footer">

                        <div class="product-card__price-block">
                            <span class="product-card__price">
                                {{ number_format($order->tong_tien) }} đ
                            </span>
                        </div>

                        @if($order->status == 'shipping')
                            <form action="{{ route('order.received', $order->ma_don_hang) }}" method="POST">
                                @csrf
                                <button class="buy-btn">Đã nhận hàng</button>
                            </form>
                        @endif

                    </div>

                </div>

            </div>
        @endforeach

    </div>

</div>

</x-coop-layout>