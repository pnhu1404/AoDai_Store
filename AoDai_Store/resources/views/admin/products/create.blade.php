@extends('layouts.admin')

@section('title', 'Thêm Áo Dài Mới')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:underline flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block font-semibold mb-2 text-gray-700">Tên sản phẩm</label>
                    <input type="text" name="TenSanPham" value="{{ old('TenSanPham') }}" required
                           class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none @error('TenSanPham') border-red-500 @enderror" 
                           placeholder="Nhập tên áo dài...">
                    @error('TenSanPham') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-gray-700">Loại Áo Dài</label>
                    <select name="MaLoaiSP" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none" required>
                        <option value="">-- Chọn loại --</option>
                        @foreach($categories as $item)
                            <option value="{{ $item->MaLoaiSP }}" {{ old('MaLoaiSP') == $item->MaLoaiSP ? 'selected' : '' }}>
                                {{ $item->TenLoaiSP }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-gray-700">Chất liệu</label>
                    <select name="MaChatLieu" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none" required>
                        <option value="">-- Chọn chất liệu --</option>
                        @foreach($materials as $item)
                            <option value="{{ $item->MaChatLieu }}" {{ old('MaChatLieu') == $item->MaChatLieu ? 'selected' : '' }}>
                                {{ $item->TenChatLieu }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-gray-700">Giá bán</label>
                    <input type="number" name="GiaBan" value="{{ old('GiaBan') }}" required
                           class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500" placeholder="">
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-gray-700">Màu sắc</label>
                    <select name="MaLoaiMau" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        @foreach($colors as $item)
                            <option value="{{ $item->MaLoaiMau }}">{{ $item->TenLoaiMau }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-gray-700">Nhà cung cấp</label>
                    <select name="MaNCC" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        @foreach($suppliers as $item)
                            <option value="{{ $item->MaNCC }}">{{ $item->TenNCC }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="block font-semibold mb-2 text-gray-700">Hình ảnh</label>
                    <input type="file" name="HinhAnh" class="w-full border rounded-lg p-2 bg-gray-50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="col-span-2">
                    <label class="block font-semibold mb-2 text-gray-700">Mô tả sản phẩm</label>
                    <textarea name="MoTa" rows="4" 
                              class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none" 
                              placeholder="Nhập thông tin chi tiết về áo dài...">{{ old('MoTa') }}</textarea>
                </div>
            </div>

            <div class="mt-8 border-t pt-6">
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 shadow-lg transition-all flex justify-center items-center uppercase tracking-widest">
                    <i class="fas fa-save mr-2"></i> Lưu sản phẩm
                </button>
            </div>
        </form>
    </div>
</div>
@endsection