@props([
    'categories' => [],
    'activeCategoryId' => 0,
    'sort' => ''
])

<aside class="category-sidebar">
    <div class="category-sidebar__header">
        DANH MỤC
    </div>

    <ul class="category-list">
        <li class="category-item {{ $activeCategoryId == 0 ? 'is-active' : '' }}">
            <a href="{{ $sort != '' ? route('coop-shop.home', ['sort' => $sort]) : route('coop-shop.home') }}">
                <span>Tất cả sản phẩm</span>
                <i class="bi bi-chevron-right"></i>
            </a>
        </li>

        @foreach ($categories as $category)
            <li class="category-item {{ $activeCategoryId == $category->id ? 'is-active' : '' }}">
                <a href="{{ $sort != '' ? route('coop-shop.category', ['id' => $category->id, 'sort' => $sort]) : route('coop-shop.category', ['id' => $category->id]) }}">
                    <span>{{ $category->ten }}</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        @endforeach
    </ul>
</aside>