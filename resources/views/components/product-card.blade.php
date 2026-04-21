@props([
    'product' => [],
])

<article class="product-card">
    <a href="{{ route('coop-shop.detail', ['id' => $product->id]) }}" class="product-card__image-wrap">
        <img
            src="{{ $product->hinh_anh }}"
            alt="{{ $product->tieu_de }}"
            class="product-card__image"
        >
    </a>

    <div class="product-card__body">
        <h3 class="product-card__title">
            <a href="{{ route('coop-shop.detail', ['id' => $product->id]) }}">
                {{ $product->tieu_de }}
            </a>
        </h3>

        <div class="product-card__unit">
            Đơn vị tính: {{ $product->don_vi_tinh }}
        </div>

        <div class="product-card__promo">
            Khuyến mãi:
            @if (!empty($product->khuyen_mai))
                {{ $product->khuyen_mai }}
            @else
                Không có
            @endif
        </div>

        <div class="product-card__footer">
            <div class="product-card__price-block">
                <div class="product-card__price-row">
                    <div class="product-card__price">
                        {{ number_format($product->gia_ban, 0, ',', '.') }}đ
                    </div>

                    <div class="product-card__stock">
                        Tồn kho: {{ (int) ($product->ton_kho ?? 0) }}
                    </div>
                </div>

                @if (!empty($product->gia_goc))
                    <div class="product-card__old-price">
                        {{ number_format($product->gia_goc, 0, ',', '.') }}đ
                    </div>
                @endif
            </div>

            <a href="{{ route('coop-shop.detail', ['id' => $product->id]) }}" class="buy-btn">
                Mua
            </a>
        </div>
    </div>
</article>
