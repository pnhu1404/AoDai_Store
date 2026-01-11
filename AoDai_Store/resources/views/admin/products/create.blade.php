@extends('layouts.admin')

@section('title', 'Thêm Áo Dài Mới')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:underline">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block font-semibold mb-2">Tên sản phẩm</label>
                    <input type="text" name="TenSanPham" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-green-500 outline-none @error('name') border-red-500 @enderror" placeholder="Ví dụ: Áo dài lụa tơ tằm thêu hoa">
                    @error('TenSanPham') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-2">Giá bán (VNĐ)</label>
                    <input type="number" name="GiaBan" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-green-500" placeholder="0">
                </div>

                <div>
                    <label class="block font-semibold mb-2">Chất liệu</label>
                    <input type="text" name="ChatLieu" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-green-500" placeholder="Lụa, Gấm, Nhung...">
                </div>

                <div class="col-span-2">
                    <label class="block font-semibold mb-2">Hình ảnh đại diện</label>
                    <input type="file" name="HinhAnh" class="w-full border border-dashed p-4 rounded-lg bg-gray-50">
                </div>

                <div class="col-span-2">
                    <label class="block font-semibold mb-2">Mô tả sản phẩm</label>
                    <textarea name="MoTa" rows="4" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-green-500"></textarea>
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 transition">
                    <i class="fas fa-save mr-2"></i> LƯU SẢN PHẨM
                </button>
            </div>
        </form>
    </div>
</div>
@endsection