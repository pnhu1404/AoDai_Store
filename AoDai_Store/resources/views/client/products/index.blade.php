@extends('layouts.client')

@section('title', 'Bộ Sưu Tập Áo Dài')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex flex-col md:flex-row gap-8">
        
        <aside class="w-full md:w-1/4 space-y-8">
            <div>
                <h3 class="serif text-xl font-bold mb-4 border-b pb-2">Danh mục</h3>
                <ul class="space-y-2 text-stone-600">
                    <li><a href="#" class="hover:text-red-800 transition">Áo dài truyền thống</a></li>
                    <li><a href="#" class="hover:text-red-800 transition font-bold text-red-800">Áo dài cách tân</a></li>
                    <li><a href="#" class="hover:text-red-800 transition">Áo dài cưới</a></li>
                </ul>
            </div>

            <div>
                <h3 class="serif text-xl font-bold mb-4 border-b pb-2">Chất liệu</h3>
                <div class="flex flex-wrap gap-2">
                    <button class="px-3 py-1 border rounded-full text-sm hover:bg-stone-800 hover:text-white transition">Lụa Tơ Tằm</button>
                    <button class="px-3 py-1 border rounded-full text-sm hover:bg-stone-800 hover:text-white transition">Gấm</button>
                    <button class="px-3 py-1 border rounded-full text-sm hover:bg-stone-800 hover:text-white transition">Nhung</button>
                </div>
            </div>
        </aside>

        <div class="flex-1">
            <div class="flex justify-between items-center mb-8">
                <p class="text-stone-500 text-sm">Hiển thị 12 sản phẩm</p>
                <select class="border-none bg-transparent text-sm font-bold outline-none">
                    <option>Mới nhất</option>
                    <option>Giá tăng dần</option>
                    <option>Giá giảm dần</option>
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach(range(1, 6) as $item)
                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden aspect-[3/4]">
                        <img src="https://images.unsplash.com/photo-1588410634812-466d33878772?q=80&w=600" 
                             class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/5 group-hover:bg-black/0 transition"></div>
                        <a href="{{ route('products.show', 1) }}" class="absolute bottom-4 left-4 right-4 bg-white py-2 text-center text-sm font-bold opacity-0 group-hover:opacity-100 transition-all translate-y-4 group-hover:translate-y-0">
                            XEM CHI TIẾT
                        </a>
                    </div>
                    <div class="mt-4 text-center">
                        <h3 class="serif text-lg text-stone-800">Áo Dài Mỹ Nhân Thướt Tha</h3>
                        <p class="text-red-800 font-bold mt-1 shadow-sm">1.850.000 đ</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection