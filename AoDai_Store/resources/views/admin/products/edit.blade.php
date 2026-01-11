@extends('layouts.admin')

@section('title', 'Chỉnh sửa: ' . $product->TenSanPham)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-blue-600">
        <form action="{{ route('admin.products.update', $product->MaSanPham) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block font-semibold mb-2 text-gray-700">Tên sản phẩm</label>
                    <input type="text" name="TenSanPham" value="{{ $product->TenSanPham }}" class="w-full border rounded-lg p-2 bg-gray-50">
                </div>

                <div class="col-span-2">
                    <label class="block font-semibold mb-2 text-gray-700">Chất liệu</label>
                    <select name="MaChatLieu" class="w-full border rounded-lg p-2">
                        @foreach($materials as $item)
                            <option value="{{ $item->MaChatLieu }}"
                                {{ $product->MaChatLieu == $item->MaChatLieu ? 'selected' : '' }}>
                                {{ $item->TenChatLieu }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-gray-700">Giá hiện tại</label>
                    <input type="number" name="GiaBan" value="{{ $product->GiaBan }}" class="w-full border rounded-lg p-2">
                </div>

                <div class="col-span-2">
                    <label class="block font-semibold mb-2 text-gray-700">Hình ảnh hiện tại</label>
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $product->HinhAnh) }}" class="w-24 h-32 object-cover rounded shadow">
                        <div class="flex-1">
                            <input type="file" name="HinhAnh" class="text-sm">
                            <p class="text-gray-400 text-xs mt-1">Chọn ảnh mới nếu muốn thay đổi</p>
                        </div>
                    </div>
                </div>
                </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700">
                    CẬP NHẬT
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-6 py-3 border rounded-lg hover:bg-gray-100">Hủy</a>
            </div>
        </form>
    </div>
</div>
@endsection