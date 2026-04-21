<x-coop-layout>

<div class="featured-products">

    <div class="section-heading">
        <h1>🧾 Danh sách đơn hàng</h1>
    </div>

    <div class="product-grid">

        @foreach($donHangs as $donHang)
            <div class="product-card">

                <div class="product-card__body">

                    <h3 class="product-card__title">
                        Mã đơn: #{{ $donHang->ma_don_hang }}
                    </h3>

                    {{-- Trạng thái --}}
                    <div class="product-card__promo">
                        @if($donHang->status == 'shipping')
                            Đang vận chuyển
                        @else
                            Đã nhận hàng
                        @endif
                    </div>

                    <div class="product-card__footer">

                        <div class="product-card__price-block">
                            <div class="product-card__price-row">
                                <span class="product-card__price">
                                    {{ number_format($donHang->tong_tien) }} đ
                                </span>
                            </div>
                        </div>

                        {{-- Button --}}
                        @if($donHang->status == 'shipping')
                            <form action="{{ route('donhang.received', $donHang->ma_don_hang) }}" method="POST">
                                @csrf
                                <button class="buy-btn">
                                    Đã nhận hàng
                                </button>
                            </form>
                        @endif

                    </div>

                </div>

            </div>
        @endforeach

    </div>

</div>

</x-coop-layout>