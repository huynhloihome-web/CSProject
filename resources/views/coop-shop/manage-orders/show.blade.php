<x-coop-layout>

{{-- THÔNG BÁO --}}
@if(session('success'))
    <div style="
        background:#d4edda;
        color:#155724;
        padding:10px;
        border-radius:8px;
        margin-bottom:15px;
    ">
        {{ session('success') }}
    </div>
@endif

<div class="featured-products">

    <div class="section-heading">
        <h1>Chi tiết đơn hàng (Admin)</h1>
    </div>

    <div class="product-card">
        <div class="product-card__body">

            {{-- MÃ ĐƠN --}}
            <h3 class="product-card__title">
                Mã đơn: #{{ $order->ma_don_hang }}
            </h3>

            {{-- TỔNG TIỀN --}}
            <p>
                <strong>💰 Tổng tiền:</strong>
                {{ number_format($order->tong_tien) }} đ
            </p>

            {{-- TRẠNG THÁI --}}
            <p>
                <strong>📌 Trạng thái:</strong>

                @if($order->status == 'shipping')
                    <span style="color:#6c757d;">🚚 Đang giao</span>
                @elseif($order->status == 'received')
                    <span style="color:#28a745;">✅ Đã giao</span>
                @elseif($order->status == 'returning')
                    <span style="color:#dc3545;">🔄 Yêu cầu trả hàng</span>
                @elseif($order->status == 'refunded')
                    <span style="color:#0d6efd;">💸 Đã hoàn tiền</span>
                @endif
            </p>

            <hr>

            {{-- SẢN PHẨM --}}
            <h4>🛒 Danh sách sản phẩm</h4>

            @foreach($items as $item)
                <div style="margin-bottom:10px; padding:10px; border-bottom:1px dashed #ddd;">

                    <strong>{{ $item->ten_sp }}</strong><br>

                    SL: {{ $item->so_luong }} <br>

                    Giá: {{ number_format($item->gia_ban) }} đ <br>

                    <span style="color:orange; font-weight:600;">
                        Thành tiền: {{ number_format($item->gia_ban * $item->so_luong) }} đ
                    </span>

                </div>
            @endforeach

            <hr>

            {{-- YÊU CẦU TRẢ HÀNG --}}
            <h4>🔄 Yêu cầu trả hàng</h4>

            @if($return)
                <p><strong>Lý do:</strong> {{ $return->reason }}</p>

                {{-- ẢNH MINH CHỨNG --}}
                @if($return->evidences)
                    <div style="display:flex; gap:10px; flex-wrap:wrap;">
                        @foreach(json_decode($return->evidences) as $img)
                            <img src="{{ asset('storage/'.$img) }}" 
                                style="width:100px; border-radius:6px;">
                        @endforeach
                    </div>
                @endif

            @else
                <p>Không có yêu cầu trả hàng</p>
            @endif

            <hr>

            {{-- ACTION ADMIN --}}
            @if($order->status == 'returning')

                {{-- DUYỆT + TỪ CHỐI --}}
                <div style="display:flex; gap:10px; margin-top:15px;">

                    {{-- DUYỆT --}}
                    <form method="POST" action="{{ route('admin.orders.approve', $order->ma_don_hang) }}">
                        @csrf
                        <button
                            onclick="return confirm('Duyệt hoàn tiền?')"
                            style="
                                background:#28a745;
                                color:white;
                                padding:8px 14px;
                                border-radius:8px;
                                border:none;
                                font-weight:500;
                                cursor:pointer;
                            "
                        >
                            ✅ Duyệt hoàn tiền
                        </button>
                    </form>

                    {{-- TỪ CHỐI --}}
                    <form method="POST" action="{{ route('admin.orders.reject', $order->ma_don_hang) }}">
                        @csrf
                        <button
                            onclick="return confirm('Từ chối yêu cầu?')"
                            style="
                                background:#dc3545;
                                color:white;
                                padding:8px 14px;
                                border-radius:8px;
                                border:none;
                                font-weight:500;
                                cursor:pointer;
                            "
                        >
                            ❌ Từ chối
                        </button>
                    </form>

                </div>

                {{-- YÊU CẦU BỔ SUNG --}}
                <div style="margin-top:20px;">

                    <h4>📩 Yêu cầu khách hàng bổ sung</h4>

                    <form method="POST" action="{{ route('admin.orders.needInfo', $order->ma_don_hang) }}">
                        @csrf

                        <textarea name="note" required
                            placeholder="Nhập nội dung yêu cầu bổ sung..."
                            style="
                                width:100%;
                                padding:10px;
                                border-radius:8px;
                                border:1px solid #ccc;
                                margin-bottom:10px;
                            "
                        ></textarea>

                        <button
                            style="
                                background:#fd7e14;
                                color:white;
                                padding:8px 14px;
                                border-radius:8px;
                                border:none;
                                font-weight:500;
                                cursor:pointer;
                            "
                        >
                            Gửi yêu cầu
                        </button>

                    </form>

                </div>

            @endif

        </div>
    </div>

</div>

</x-coop-layout>