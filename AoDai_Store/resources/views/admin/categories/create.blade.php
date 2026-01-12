@extends('layouts.admin')

@section('title', 'Thêm Danh Mục Mới')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Nút quay lại danh sách --}}
    <div class="mb-4">
        <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:underline flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
    </div>

    {{-- Thẻ nội dung chính --}}
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Tên danh mục --}}
                <div class="col-span-2">
                    <label class="block font-semibold mb-2 text-gray-700">Tên danh mục (Tên Loại)</label>
                    <input type="text" name="TenLoaiSP" value="{{ old('TenLoaiSP') }}" required
                           class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none @error('TenLoaiSP') border-red-500 @enderror" 
                           placeholder="Ví dụ: Áo Dài Cưới, Áo Dài Cách Tân...">
                    
                    @error('TenLoaiSP') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="col-span-2">
                    <label class="block font-semibold mb-2 text-gray-700">Mô tả danh mục</label>
                    <textarea name="MoTa" rows="6" 
                              class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none" 
                              placeholder="Nhập thông tin mô tả về loại sản phẩm này...">{{ old('MoTa') }}</textarea>
                </div>
            </div>

            <div class="mt-8 border-t pt-6">
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 shadow-lg transition-all flex justify-center items-center uppercase tracking-widest">
                    <i class="fas fa-save mr-2"></i> Lưu danh mục
                </button>
            </div>
        </form>
    </div>
</div>
@endsection