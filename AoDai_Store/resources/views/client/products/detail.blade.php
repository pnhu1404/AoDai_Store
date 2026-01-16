@extends('layouts.client')

@section('title', $product->TenSanPham)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

        <div class="grid grid-cols-1 gap-4">
            <img
                id="mainImage"
                src="{{ asset('img/products/' . $product->HinhAnh) }}"
                class="w-full h-[520px] object-cover rounded-sm shadow-md cursor-pointer"
                alt="{{ $product->TenSanPham }}"
            >
            <div class="grid grid-cols-4 gap-2">
                <img
                   src="{{ asset('img/products/' . $product->HinhAnh) }}"
                            onclick="changeImage(this.src)"
                            class="w-full h-full object-cover"
                            alt=""
                >         
                @foreach($product->hinhanhsanpham as $img)
                    <div class="w-full aspect-square overflow-hidden border hover:border-stone-800 cursor-pointer">
                        <img
                            src="{{ asset('img/details/' . $img->TenHinh) }}"
                            onclick="changeImage(this.src)"
                            class="w-full h-full object-cover"
                            alt="Ảnh chi tiết {{ $loop->iteration }}"
                        >
                    </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            <form action="{{ route('cart.add', $product->MaSanPham) }}" method="POST">
                @csrf

                <div>
                    <nav class="text-xs text-stone-400 mb-2 uppercase tracking-widest">
                        Trang chủ / {{ $product->loaisanpham->TenLoaiSP ?? 'Áo dài' }}
                    </nav>

                    <h1 class="serif text-4xl text-stone-900 leading-tight uppercase">
                        {{ $product->TenSanPham }}
                    </h1>

                    <p class="text-2xl text-red-800 font-bold mt-4">
                        {{ number_format($product->GiaBan, 0, ',', '.') }} đ
                    </p>
                </div>

                <div class="text-stone-600 text-sm leading-relaxed border-b pb-6 italic">
                    {{ $product->MoTa }}
                </div>

                <div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="font-bold text-sm uppercase text-stone-700">Chọn kích cỡ:</span>
                        <span id="stock-info" class="text-xs font-bold text-red-700 uppercase"></span>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        @foreach($allSizes as $s)
                            @php
                                $productSize = $product->sizes->where('MaSize', $s->MaSize)->first();
                                $stock = $productSize ? $productSize->pivot->SoLuong : 0;
                            @endphp

                            <label class="relative cursor-pointer">
                                <input
                                    type="radio"
                                    name="MaSize"
                                    value="{{ $s->MaSize }}"
                                    class="size-radio peer hidden"
                                    data-stock="{{ $stock }}"
                                    {{ $stock <= 0 ? 'disabled' : '' }}
                                    required
                                >

                                <span class="w-14 h-12 border flex items-center justify-center transition relative
                                    peer-checked:bg-stone-800 peer-checked:text-white peer-checked:border-stone-800
                                    {{ $stock <= 0
                                        ? 'bg-stone-50 text-stone-300 cursor-not-allowed opacity-60'
                                        : 'hover:border-stone-800 text-stone-700' }}">
                                    {{ $s->TenSize }}

                                    @if($stock <= 0)
                                        <span class="absolute inset-0 flex items-center justify-center">
                                            <span class="w-full h-[1px] bg-stone-300 rotate-45"></span>
                                        </span>
                                    @endif
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="py-4">
                    <span class="font-bold text-sm uppercase text-stone-700 block mb-3">Số lượng:</span>

                    <div class="flex items-center w-32 border border-stone-300">
                        <button type="button" onclick="changeQty(-1)"
                            class="w-10 h-10 flex items-center justify-center hover:bg-stone-100">-</button>

                        <input
                            type="number"
                            name="SoLuong"
                            id="quantity"
                            value="1"
                            min="1"
                            max="1"
                            class="w-12 h-10 text-center bg-transparent font-semibold focus:ring-0"
                        >

                        <button type="button" onclick="changeQty(1)"
                            class="w-10 h-10 flex items-center justify-center hover:bg-stone-100">+</button>
                    </div>
                </div>

                <div class="bg-stone-100 p-4 rounded-sm border-l-4 border-stone-800 my-6">
                    <p class="text-sm font-bold uppercase mb-1">📐 May theo số đo riêng?</p>
                    <p class="text-xs text-stone-500 italic">
                        Để lại ghi chú khi thanh toán hoặc nhắn tin trực tiếp để được tư vấn chi tiết.
                    </p>
                </div>

                <div class="flex gap-4">
                    <button type="submit"
                        class="flex-1 bg-stone-900 text-white py-4 font-bold uppercase tracking-widest hover:bg-black">
                        Thêm vào giỏ hàng
                    </button>

                    <button type="button"
                        class="w-14 border border-stone-300 flex items-center justify-center hover:bg-stone-50">
                        ♡
                    </button>
                </div>
            </form>

            <div class="pt-6 border-t">
                <details open class="group">
                    <summary class="flex justify-between items-center font-bold text-sm uppercase py-2 cursor-pointer">
                        Thông tin chi tiết & Bảo quản
                        <span class="group-open:rotate-45 transition">+</span>
                    </summary>

                    <div class="text-sm text-stone-500 space-y-3 leading-relaxed">
                        <p>• <b class="text-stone-700">Chất liệu:</b> {{ $product->chatlieu->TenChatLieu }}</p>
                        <p>• <b class="text-stone-700">Màu sắc:</b> {{ $product->loaimau->TenLoaiMau }}</p>
                        <p>• <b class="text-stone-700">Xuất xứ:</b> {{ $product->chatlieu->Xuatxu ?? 'Việt Nam' }}</p>

                        <div class="pt-2 border-t italic text-xs">
                            <b class="not-italic uppercase text-stone-700">Hướng dẫn bảo quản:</b><br>
                            {{ $product->chatlieu->HuongDanBaoQuan }}
                        </div>
                    </div>
                </details>
            </div>
        </div>
    </div>
</div>

<script>
    const qtyInput = document.getElementById('quantity');
    const stockInfo = document.getElementById('stock-info');
    const sizeRadios = document.querySelectorAll('.size-radio');

    function changeImage(src) {
        document.getElementById('mainImage').src = src;
    }

    sizeRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            const stock = parseInt(this.dataset.stock);
            stockInfo.innerText = `(Còn ${stock} sản phẩm)`;
            qtyInput.max = stock;

            if (parseInt(qtyInput.value) > stock) {
                qtyInput.value = 1;
            }
        });
    });

    function changeQty(step) {
        const selected = document.querySelector('input[name="MaSize"]:checked');
        if (!selected) {
            alert('Vui lòng chọn kích cỡ trước!');
            return;
        }

        const max = parseInt(selected.dataset.stock);
        let val = parseInt(qtyInput.value) + step;

        if (val < 1) val = 1;
        if (val > max) val = max;

        qtyInput.value = val;
    }
</script>
@endsection
