@extends('layouts.admin')

@section('title', 'Chỉnh sửa danh mục: ' . $category->TenLoaiSP)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.categories.index') }}" class="text-indigo-600 hover:underline flex items-center transition">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách danh mục
        </a>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-indigo-600">
        <div class="mb-6 border-b pb-4">
            <h2 class="text-xl font-bold text-gray-800 uppercase tracking-wide">Cập nhật thông tin phân loại</h2>
            <p class="text-xs text-gray-500 mt-1 italic">Mã danh mục: #{{ $category->MaLoaiSP }}</p>
        </div>

        <form action="{{ route('admin.categories.update', $category->MaLoaiSP) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6">
                <div class="col-span-1">
                    <label class="block font-semibold mb-2 text-gray-700 uppercase text-xs tracking-widest">
                        Tên danh mục (TenLoaiSP)
                    </label>
                    <input type="text" name="TenLoaiSP" 
                           value="{{ old('TenLoaiSP', $category->TenLoaiSP) }}" required
                           class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none transition @error('TenLoaiSP') border-red-500 @enderror" 
                           placeholder="Nhập tên loại áo dài...">
                    
                    @error('TenLoaiSP') 
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="col-span-1">
                    <label class="block font-semibold mb-2 text-gray-700 uppercase text-xs tracking-widest">
                        Mô tả danh mục (MoTa)
                    </label>
                    <textarea name="MoTa" rows="6" 
                              class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none transition shadow-sm" 
                              placeholder="Nhập thông tin mô tả chi tiết về loại danh mục này...">{{ old('MoTa', $category->MoTa) }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex flex-col sm:flex-row gap-4 border-t pt-6">
                <button type="submit" class="flex-1 bg-indigo-600 text-white py-3.5 rounded-lg font-bold hover:bg-indigo-700 shadow-lg hover:shadow-indigo-200 transition-all flex justify-center items-center uppercase tracking-widest">
                    <i class="fas fa-sync-alt mr-2"></i> Lưu thay đổi
                </button>
                <a href="{{ route('admin.categories.index') }}" class="px-10 py-3.5 border border-gray-300 text-gray-500 rounded-lg hover:bg-gray-50 transition font-bold text-center">
                    Hủy
                </a>
            </div>
        </form>
    </div>

    <div class="mt-6 bg-indigo-50 p-4 rounded-lg flex items-center text-indigo-700 border border-indigo-100">
        <i class="fas fa-info-circle mr-3"></i>
        <p class="text-xs italic">Lưu ý: Việc thay đổi tên danh mục có thể ảnh hưởng đến đường dẫn (URL) sản phẩm trên trang khách hàng nếu bạn sử dụng slug dựa trên tên.</p>
    </div>
</div>
@endsection