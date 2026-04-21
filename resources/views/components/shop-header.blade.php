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

        <form class="shop-search" action="#" method="get" onsubmit="return false;">
            <div class="shop-search__box">
                <input type="text" placeholder="Tìm sản phẩm..." aria-label="Tìm sản phẩm">
                <button type="submit" aria-label="Tìm kiếm">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>

        <div class="shop-actions">
            <a href="{{ route('coop-shop.login') }}" class="btn-login">Đăng nhập</a>

            <a href="{{ route('coop-shop.cart') }}" class="btn-cart" aria-label="Giỏ hàng">
                <i class="bi bi-cart3"></i>
            </a>
        </div>
    </div>
</header>