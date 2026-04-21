<header class="shop-header">
    <div class="shop-header__inner">
        <a href="{{ route('coop-shop.home') }}" class="brand">
            <span class="brand__logo">
                <i class="bi bi-basket2-fill"></i>
            </span>

            <span class="brand__text">
                <span class="brand__name">Coop Shop</span>
                <span class="brand__tagline">Thực phẩm tươi ngon mỗi ngày</span>
            </span>
        </a>

        <form class="shop-search" action="{{ route('coop-shop.search') }}" method="get">
            <div class="shop-search__box">
                <input
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    placeholder="Tìm sản phẩm..."
                    aria-label="Tìm sản phẩm"
                >
                <button type="submit" aria-label="Tìm kiếm">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>

        <div class="shop-actions">
            <a href="{{ route('coop-shop.login') }}" class="btn-login">Đăng nhập</a>

            <a href="{{ route('coop-shop.cart') }}" class="btn-cart" aria-label="Giỏ hàng" style="position: relative;">
                <i class="bi bi-cart3"></i>

                <span
                    id="cart-number-product"
                    style="
                        position:absolute;
                        top:-4px;
                        right:-4px;
                        min-width:22px;
                        height:22px;
                        border-radius:50%;
                        background:#ffffff;
                        color:#08be46;
                        font-size:12px;
                        font-weight:bold;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        padding:0 5px;
                        line-height:1;
                    "
                >
                    {{ array_sum(session('cart', [])) }}
                </span>
            </a>
        </div>
    </div>
</header>