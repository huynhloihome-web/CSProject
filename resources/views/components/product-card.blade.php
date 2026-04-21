@props([
    'product' => []
])

<article class="product-card">
    <div class="product-card__image-wrap">
        <img
            src="{{ $product->hinh_anh }}"
            alt="{{ $product->tieu_de }}"
            class="product-card__image"
        >
    </div>

    <div class="product-card__body">
        <h3 class="product-card__title">{{ $product->tieu_de }}</h3>

        <div class="product-card__unit">
            Đơn vị tính: {{ $product->don_vi_tinh }}
        </div>

        <div class="product-card__promo">
            Khuyến mãi:
            @if(!empty($product->khuyen_mai))
                {{ $product->khuyen_mai }}
            @else
                Không có
            @endif
        </div>

        <div class="product-card__footer">
            <div class="product-card__price-block">
                <div class="product-card__price">
                    {{ number_format($product->gia_ban, 0, ',', '.') }}đ
                </div>

                @if (!empty($product->gia_goc))
                    <div class="product-card__old-price">
                        {{ number_format($product->gia_goc, 0, ',', '.') }}đ
                    </div>
                @endif
            </div>

            <button type="button" class="buy-btn">Mua</button>
        </div>
    </div>
</article>