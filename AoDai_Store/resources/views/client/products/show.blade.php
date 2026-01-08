@extends('layouts.client')

@section('title', 'Áo Dài Mỹ Nhân')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        
        <div class="grid grid-cols-1 gap-4">
            <img src="https://images.unsplash.com/photo-1588410634812-466d33878772?q=80&w=1000" class="w-full rounded-sm shadow-md">
            <div class="grid grid-cols-3 gap-2">
                <img src="https://images.unsplash.com/photo-1588410634812-466d33878772?q=80&w=300" class="cursor-pointer opacity-70 hover:opacity-100">
                <img src="https://images.unsplash.com/photo-1588410634812-466d33878772?q=80&w=300" class="cursor-pointer opacity-70 hover:opacity-100">
                <img src="https://images.unsplash.com/photo-1588410634812-466d33878772?q=80&w=300" class="cursor-pointer opacity-70 hover:opacity-100">
            </div>
        </div>

        <div class="space-y-6">
            <div>
                <nav class="text-xs text-stone-400 mb-2 uppercase tracking-widest">Trang chủ / Áo dài cách tân</nav>
                <h1 class="serif text-4xl text-stone-900 leading-tight">Áo Dài Mỹ Nhân - Gấm Thượng Hạng</h1>
                <p class="text-2xl text-red-800 font-bold mt-4">1.850.000 đ</p>
            </div>

            <div class="text-stone-600 text-sm leading-relaxed border-b pb-6 italic">
                Sản phẩm được dệt may từ lụa gấm thủ công, họa tiết chìm tinh tế mang đậm hơi thở cung đình Huế.
            </div>

            <div>
                <div class="flex justify-between items-center mb-3">
                    <span class="font-bold text-sm uppercase">Chọn kích cỡ:</span>
                    <a href="#" class="text-xs text-blue-600 underline">Bảng quy đổi size</a>
                </div>
                <div class="flex gap-3">
                    @foreach(['S', 'M', 'L', 'XL'] as $size)
                    <button class="w-12 h-12 border flex items-center justify-center hover:border-stone-800 transition active:bg-stone-800 active:text-white">
                        {{ $size }}
                    </button>
                    @endforeach
                </div>
            </div>

            <div class="bg-stone-100 p-4 rounded-sm border-l-4 border-stone-800">
                <p class="text-sm font-bold mb-1">📐 Bạn muốn may theo số đo riêng?</p>
                <p class="text-xs text-stone-500">Hãy để lại ghi chú ở giỏ hàng hoặc nhắn tin trực tiếp cho chúng tôi qua Zalo.</p>
            </div>

            <div class="flex gap-4">
                <button class="flex-1 bg-stone-900 text-white py-4 font-bold hover:bg-black transition tracking-widest">
                    THÊM VÀO GIỎ HÀNG
                </button>
                <button class="w-14 border border-stone-300 flex items-center justify-center hover:bg-stone-50">
                    ❤
                </button>
            </div>

            <div class="pt-6 border-t space-y-3">
                <details class="group cursor-pointer">
                    <summary class="flex justify-between items-center font-bold text-sm uppercase py-2">Chất liệu & Cách bảo quản <span class="group-open:rotate-180">+</span></summary>
                    <div class="text-sm text-stone-500 py-2 space-y-2">
                        <p>• 100% Gấm tơ tằm thiên nhiên.</p>
                        <p>• Khuyến khích giặt tay hoặc giặt khô để giữ form dáng.</p>
                    </div>
                </details>
            </div>
        </div>
    </div>
</div>
@endsection