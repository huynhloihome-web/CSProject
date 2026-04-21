<header class="shop-header">
    <style>
        .user-menu {
            position: relative;
        }

        .user-menu__button {
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .user-menu__dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 200px;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.14);
            padding: 8px 0;
            display: none;
            z-index: 999;
            overflow: hidden;
        }

        .user-menu:hover .user-menu__dropdown {
            display: block;
        }

        .user-menu__item,
        .user-menu__logout-btn {
            display: block;
            width: 100%;
            padding: 12px 16px;
            text-decoration: none;
            color: #213047;
            background: #ffffff;
            border: none;
            text-align: left;
            font-size: 15px;
            cursor: pointer;
        }

        .user-menu__item:hover,
        .user-menu__logout-btn:hover {
            background: #f5fff8;
            color: #08be46;
        }

        .user-menu__divider {
            height: 1px;
            background: #ebedf0;
            margin: 6px 0;
        }

        .user-menu__name {
            font-weight: 700;
            white-space: nowrap;
            max-width: 160px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>

    @php
        $homeUrl = Route::has('coop-shop.home') ? route('coop-shop.home') : url('/');
        $cartUrl = Route::has('coop-shop.cart') ? route('coop-shop.cart') : url('/gio-hang');
        $loginUrl = Route::has('login') ? route('login') : url('/login');
        $logoutRouteExists = Route::has('logout');
        $manageUrl = 'javascript:void(0)';
    @endphp

    <div class="shop-header__inner">
        <a href="{{ $homeUrl }}" class="brand">
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
            @auth
                <div class="user-menu">
                    <button type="button" class="btn-login user-menu__button">
                        <span class="user-menu__name">{{ Auth::user()->name }}</span>
                        <i class="bi bi-chevron-down"></i>
                    </button>

                    <div class="user-menu__dropdown">
                        <a href="{{ $manageUrl }}" class="user-menu__item">
                            Quản lý
                        </a>

                        <div class="user-menu__divider"></div>

                        @if($logoutRouteExists)
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="user-menu__logout-btn">
                                    Đăng xuất
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @else
                <a href="{{ $loginUrl }}" class="btn-login">Đăng nhập</a>
            @endauth

            <a href="{{ $cartUrl }}" class="btn-cart" aria-label="Giỏ hàng" style="position: relative;">
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