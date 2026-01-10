@extends('layouts.client')

@section('title', 'Nét đẹp truyền thống Việt')

@section('content')
    <section class="relative h-[600px] flex items-center justify-center bg-gray-200">
        <div class="absolute inset-0 z-0">
            <img src="https://static.dchic.vn/uploads/media/2025/12/BLOG%20WEB%20MO%20BAN%20SOM%20AO%20DAI-325256125.jpg" 
                 class="w-full h-full object-cover opacity-80" alt="Banner Áo Dài">
        </div>
        <div class="relative z-10 text-center text-white px-4">
            <h1 class="serif text-5xl md:text-7xl mb-4 drop-shadow-lg">Dáng Việt Kiêu Sa</h1>
            <p class="text-lg mb-8 drop-shadow-md italic">Tôn vinh vẻ đẹp vĩnh cửu của phụ nữ Việt</p>
            <a href="#new-arrival" class="bg-red-800 hover:bg-red-900 text-white px-8 py-3 rounded-full transition duration-300">
                Khám phá ngay
            </a>
        </div>
    </section>

    <section class="max-w-7xl mx-auto py-16 px-4" id="new-arrival">
        <div class="text-center mb-12">
            <h2 class="serif text-3xl font-bold text-stone-800">Sản Phẩm Mới Nhất</h2>
            <div class="h-1 w-20 bg-red-800 mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- Giả lập lặp dữ liệu --}}
            @foreach($data["product"] as $s)
            <div class="group bg-white overflow-hidden shadow-sm hover:shadow-xl transition duration-300">
                <div class="relative h-96 overflow-hidden">
                    <img src="{{ $s->hinhanh }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500" 
                         alt="Áo Dài">
                    <div class="absolute top-4 left-4 bg-red-600 text-white text-xs px-2 py-1 uppercase">Mới</div>
                </div>
                <div class="p-6 text-center">
                    <h3 class="serif text-lg font-semibold text-stone-700 uppercase">{{$s->TenSanPham}}</h3>
                    <p class="text-red-800 font-bold mt-2 italic">{{ $s->GiaBan }}</p>
                    <a href="{{ route('product.detail', $s->MaSanPham) }}" class="mt-4 border-b border-stone-800 text-sm hover:text-red-700 hover:border-red-700 transition uppercase tracking-widest pb-1">
                        Xem chi tiết
                    </a>
                    
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <section class="bg-stone-100 py-16 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="serif text-2xl md:text-4xl italic text-stone-700">"Áo dài không chỉ là trang phục, mà là hơi thở của văn hóa."</h2>
        </div>
    </section>
@endsection