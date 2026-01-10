@extends('layouts.client')

@section('title', $product->TenSanPham)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        
        <div class="grid grid-cols-1 gap-4">
            <img src="{{ $product->HinhAnh }}" class="w-full rounded-sm shadow-md" alt="{{ $product->TenSanPham }}">
            <div class="grid grid-cols-4 gap-2">
                <img src="{{ $product->HinhAnh }}" class="cursor-pointer opacity-70 hover:opacity-100 border">
            </div>
        </div>

        <div class="space-y-6">
            <form action="{{ route('cart.add', $product->MaSanPham) }}" method="POST">
                @csrf
                <div>
                    <nav class="text-xs text-stone-400 mb-2 uppercase tracking-widest">
                        Trang chủ / {{ $product->loaisanpham->TenLoaiSP ?? 'Áo dài' }}
                    </nav>
                    <h1 class="serif text-4xl text-stone-900 leading-tight uppercase">{{ $product->TenSanPham }}</h1>
                    <p class="text-2xl text-red-800 font-bold mt-4">{{ number_format($product->GiaBan, 0, ',', '.') }} đ</p>
                </div>

                <div class="text-stone-600 text-sm leading-relaxed border-b pb-6 italic">
                    {{ $product->MoTa }}
                </div>

              <div>
                <div class="flex justify-between items-center mb-3">
                    <span class="font-bold text-sm uppercase text-stone-700">Chọn kích cỡ:</span>
                    <span id="stock-info" class="text-xs font-bold text-red-700 uppercase tracking-tighter"></span>
                </div>
                <div class="flex flex-wrap gap-3">
                    @foreach($allSizes as $s)
                        @php
                            // Kiểm tra xem sản phẩm hiện tại có size này không và số lượng là bao nhiêu
                            $productSize = $product->sizes->where('MaSize', $s->MaSize)->first();
                            $stock = $productSize ? $productSize->pivot->SoLuong : 0;
                        @endphp
                        <label class="relative cursor-pointer">
                            <input type="radio" name="MaSize" value="{{ $s->MaSize }}" 
                                class="size-radio peer hidden" 
                                data-stock="{{ $stock }}"
                                {{ $stock <= 0 ? 'disabled' : '' }} required>
                            
                            <span class="w-14 h-12 border flex items-center justify-center transition relative
                                peer-checked:bg-stone-800 peer-checked:text-white peer-checked:border-stone-800
                                {{ $stock <= 0 ? 'bg-stone-50 text-stone-300 cursor-not-allowed overflow-hidden opacity-60' : 'hover:border-stone-800 text-stone-700' }}">
                                
                                {{ $s->TenSize }}

                                @if($stock <= 0)
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-full h-[1px] bg-stone-300 rotate-45"></div>
                                    </div>
                                @endif
                            </span>
                        </label>
                    @endforeach
                </div>
</div>

                <div class="py-4">
                    <span class="font-bold text-sm uppercase text-stone-700 block mb-3">Số lượng:</span>
                    <div class="flex items-center w-32 border border-stone-300">
                        <button type="button" onclick="changeQty(-1)" class="w-10 h-10 flex items-center justify-center hover:bg-stone-100 transition">-</button>
                        <input type="number" name="SoLuong" id="quantity" value="1" min="1" max="1" 
                            class="w-12 h-10 border-none text-center focus:ring-0 text-stone-800 font-semibold bg-transparent" >
                        <button type="button" onclick="changeQty(1)" class="w-10 h-10 flex items-center justify-center hover:bg-stone-100 transition">+</button>
                    </div>
                </div>

                <div class="bg-stone-100 p-4 rounded-sm border-l-4 border-stone-800 my-6">
                    <p class="text-sm font-bold mb-1 uppercase tracking-tight">📐 May theo số đo riêng?</p>
                    <p class="text-xs text-stone-500 italic">Để lại ghi chú khi thanh toán hoặc nhắn tin trực tiếp để chúng tôi tư vấn chi tiết nhất.</p>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-stone-900 text-white py-4 font-bold hover:bg-black transition tracking-widest uppercase shadow-md">
                        Thêm vào giỏ hàng
                    </button>
                    <button type="button" class="w-14 border border-stone-300 flex items-center justify-center hover:bg-stone-50 transition">
                        <span class="text-xl">♡</span>
                    </button>
                </div>
            </form>

            <div class="pt-6 border-t space-y-3">
                <details class="group cursor-pointer" open>
                    <summary class="flex justify-between items-center font-bold text-sm uppercase py-2 text-stone-800">
                        Thông tin chi tiết & Bảo quản 
                        <span class="group-open:rotate-45 transition-transform">+</span>
                    </summary>
                    <div class="text-sm text-stone-500 py-2 space-y-3 leading-relaxed">
                        <p>• <span class="font-semibold text-stone-700 uppercase">Chất liệu:</span> {{ $product->chatlieu->TenChatLieu }}</p>
                        <p>• <span class="font-semibold text-stone-700 uppercase">Màu sắc:</span> {{ $product->loaimau->TenLoaiMau }}</p>
                        <p>• <span class="font-semibold text-stone-700 uppercase">Xuất xứ:</span> {{ $product->chatlieu->Xuatxu ?? 'Việt Nam' }}</p>
                        <div class="pt-2 italic border-t mt-2 text-xs">
                            <p class="mb-1 font-semibold text-stone-700 not-italic uppercase">Hướng dẫn bảo quản:</p>
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

    // Cập nhật giới hạn số lượng khi chọn size
    sizeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const stock = parseInt(this.dataset.stock);
            stockInfo.innerText = `(Còn ${stock} sản phẩm)`;
            qtyInput.max = stock;
            
            // Đưa số lượng về 1 nếu số lượng hiện tại vượt quá tồn kho mới
            if (parseInt(qtyInput.value) > stock) {
                qtyInput.value = stock > 0 ? 1 : 0;
            }
        });
    });

    function changeQty(amt) {
        // Kiểm tra xem đã chọn size chưa
        const selectedSize = document.querySelector('input[name="MaSize"]:checked');
        if (!selectedSize) {
            alert('Vui lòng chọn kích cỡ trước!');
            return;
        }

        const maxStock = parseInt(selectedSize.dataset.stock);
        let newVal = parseInt(qtyInput.value) + amt;

        if (newVal < 1) newVal = 1;
        if (newVal > maxStock) {
            alert('Bạn đã chọn tối đa số lượng có sẵn!');
            newVal = maxStock;
        }
        
        qtyInput.value = newVal;
    }
</script>
@endsection