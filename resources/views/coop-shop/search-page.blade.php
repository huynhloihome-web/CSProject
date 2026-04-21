<x-coop-layout :title="$pageTitle">
    <div class="shop-page">
        <x-category-sidebar
            :categories="$categories"
            :activeCategoryId="$activeCategoryId"
            :sort="$sort"
        />

        <section class="featured-products">
            <div class="section-heading">
                <h1>{{ $pageTitle }}</h1>
            </div>

            @if($keyword === '')
                <div class="empty-state">
                    Vui lòng nhập từ khóa để tìm kiếm sản phẩm.
                </div>
            @else
                <div class="product-grid">
                    @forelse ($products as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <div class="empty-state">
                            Không tìm thấy sản phẩm phù hợp với từ khóa
                            <b>{{ $keyword }}</b>.
                        </div>
                    @endforelse
                </div>
            @endif
        </section>
    </div>
</x-coop-layout>