@extends('layouts.admin')

@section('title', 'Chỉnh sửa: ' . $product->TenSanPham)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:underline flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-blue-600">
        <form action="{{ route('admin.products.update', $product->MaSanPham) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block font-semibold mb-2 text-gray-700">Tên sản phẩm</label>
                    <input type="text" name="TenSanPham" value="{{ old('TenSanPham', $product->TenSanPham) }}" 
                           class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-gray-700">Loại Áo Dài</label>
                    <select name="MaLoaiSP" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        @foreach($categories as $item)
                            <option value="{{ $item->MaLoaiSP }}" 
                                {{ $product->MaLoaiSP == $item->MaLoaiSP ? 'selected' : '' }}>
                                {{ $item->TenLoaiSP }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-gray-700">Chất liệu vải</label>
                    <select name="MaChatLieu" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        @foreach($materials as $item)
                            <option value="{{ $item->MaChatLieu }}"
                                {{ $product->MaChatLieu == $item->MaChatLieu ? 'selected' : '' }}>
                                {{ $item->TenChatLieu }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-gray-700">Giá bán (VNĐ)</label>
                    <input type="number" name="GiaBan" value="{{ old('GiaBan', $product->GiaBan) }}" 
                           class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-gray-700">Màu sắc</label>
                    <select name="MaLoaiMau" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        @foreach($colors as $item)
                            <option value="{{ $item->MaLoaiMau }}"
                                {{ $product->MaLoaiMau == $item->MaLoaiMau ? 'selected' : '' }}>
                                {{ $item->TenLoaiMau }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-gray-700">Nhà cung cấp</label>
                    <select name="MaNCC" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        @foreach($suppliers as $item)
                            <option value="{{ $item->MaNCC }}"
                                {{ $product->MaNCC == $item->MaNCC ? 'selected' : '' }}>
                                {{ $item->TenNCC }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-gray-700">Trạng thái kinh doanh</label>
                    <select name="TrangThai" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="1" {{ $product->TrangThai == 1 ? 'selected' : '' }}>Đang bán</option>
                        <option value="0" {{ $product->TrangThai == 0 ? 'selected' : '' }}>Tạm ngưng</option>
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="block font-semibold mb-2 text-gray-700">Hình ảnh sản phẩm</label>
                    <div class="flex items-start space-x-6 p-4 border rounded-lg bg-gray-50">
                        <div class="text-center">
                            <p class="text-xs text-gray-500 mb-2 font-bold uppercase">Ảnh hiện tại</p>
                            <img src="{{ asset('storage/' . $product->HinhAnh) }}" 
                                 class="w-24 h-32 object-cover rounded shadow-md border-2 border-white"
                                 onerror="this.src='https://placehold.co/400x600?text=No+Image'">
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 mb-2 font-bold uppercase">Thay đổi ảnh mới</p>
                            <input type="file" name="HinhAnh" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100">
                            <p class="text-gray-400 text-xs mt-2 italic">* Để trống nếu không muốn thay đổi hình ảnh.</p>
                        </div>
                    </div>
                </div>

                <div class="col-span-2">
                    <label class="block font-semibold mb-2 text-gray-700">Mô tả sản phẩm</label>
                    <textarea name="MoTa" rows="4" 
                              class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">{{ old('MoTa', $product->MoTa) }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-3.5 rounded-lg font-bold hover:bg-blue-700 shadow-lg transition-all uppercase tracking-widest">
                    <i class="fas fa-sync-alt mr-2"></i> Cập nhật ngay
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-8 py-3.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition font-semibold">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection