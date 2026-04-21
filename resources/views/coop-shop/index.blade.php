<x-coop-layout :title="$pageTitle">
    <div class="shop-page">
        <x-category-sidebar
            :categories="$categories"
            :activeCategoryId="$activeCategoryId"
            :sort="$sort"
        />

        <section class="featured-products">
            @php
                if ($activeCategoryId != 0) {
                    $defaultUrl = route('coop-shop.category', ['id' => $activeCategoryId]);
                    $ascUrl = route('coop-shop.category', ['id' => $activeCategoryId, 'sort' => 'asc']);
                    $descUrl = route('coop-shop.category', ['id' => $activeCategoryId, 'sort' => 'desc']);
                } else {
                    $defaultUrl = route('coop-shop.home');
                    $ascUrl = route('coop-shop.home', ['sort' => 'asc']);
                    $descUrl = route('coop-shop.home', ['sort' => 'desc']);
                }
            @endphp

            <div class="section-heading section-heading--with-sort">
                <h1>{{ $pageTitle }}</h1>

                <div class="sort-actions">
                    <a href="{{ $defaultUrl }}" class="sort-btn {{ $sort == '' ? 'is-active' : '' }}">
                        Mặc định
                    </a>
                    <a href="{{ $ascUrl }}" class="sort-btn {{ $sort == 'asc' ? 'is-active' : '' }}">
                        Giá tăng dần
                    </a>
                    <a href="{{ $descUrl }}" class="sort-btn {{ $sort == 'desc' ? 'is-active' : '' }}">
                        Giá giảm dần
                    </a>
                </div>
            </div>

            <div class="product-grid">
                @forelse ($products as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="empty-state">
                        Chưa có sản phẩm hiển thị.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</x-coop-layout>