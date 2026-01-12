@extends('layouts.admin')

@section('title', 'Danh sách Áo Dài')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-lg shadow-sm flex items-center border-l-4 border-blue-500">
            <div class="p-3 bg-blue-100 rounded-full text-blue-600 mr-4">
                <i class="fas fa-tshirt fa-lg"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 uppercase">Tổng mẫu thiết kế</p>
                <p class="text-xl font-bold text-gray-800">{{$totalProducts}}</p>
            </div>
        </div>
        </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row justify-between gap-4">
            <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-1 gap-2">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition" 
                           placeholder="Tìm tên, mã hoặc chất liệu...">
                </div>
                <button type="submit" class="bg-slate-800 text-white px-6 py-2 rounded-lg hover:bg-slate-700 transition">
                    Lọc
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.products.index') }}" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg flex items-center">
                        Xóa lọc
                    </a>
                @endif
            </form>

            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-semibold shadow-md">
                <i class="fas fa-plus-circle mr-2"></i> Thêm Áo Dài
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider font-bold">
                    <th class="px-6 py-4 border-b">Sản phẩm</th>
                    <th class="px-6 py-4 border-b">Chất liệu</th>
                    <th class="px-6 py-4 border-b">Mô tả</th>
                    <th class="px-6 py-4 border-b">Số lượng</th>
                    <th class="px-6 py-4 border-b">Giá niêm yết</th>
                    <th class="px-6 py-4 border-b">Ngày tạo</th>
                    <th class="px-6 py-4 border-b">Chức năng</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-blue-50/30 transition duration-150">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <img src="{{ asset('storage/' . $product->HinhAnh) }}" class="w-12 h-16 object-cover rounded shadow-sm mr-4" onerror="this.src='https://placehold.co/400x600?text=No+Image'">
                            <div>
                                <p class="font-bold text-gray-800">{{ $product->TenSanPham }}</p>
                                 <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">
                                        {{ $product->chatlieu->TenChatLieu ?? 'Chưa cập nhật' }}
                                    </span>
                                </td>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">
                            {{ $product->MoTa }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">
                            {{ $product->tong_so_luong ?? 0 }} sản phẩm
                        </span>
                    </td>
                    <td class="px-6 py-4 font-bold text-red-600">
                        {{ number_format($product->GiaBan) }} đ
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $product->CreatedDate ? date('d/m/Y', strtotime($product->CreatedDate)) : '---' }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center space-x-3 text-sm">
                            <a href="{{ route('admin.products.edit', $product->MaSanPham) }}" class="text-blue-600 hover:text-blue-800 transition p-2 bg-blue-50 rounded-full" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <button type="button" 
                                    onclick="confirmDelete('{{ $product->MaSanPham }}', '{{ $product->TenSanPham }}')" 
                                    class="text-red-600 hover:text-red-800 transition p-2 bg-red-50 rounded-full" title="Xóa">
                                <i class="fas fa-trash-alt"></i>
                            </button>

                            <form id="delete-form-{{ $product->MaSanPham }}" action="{{ route('admin.products.destroy', $product->MaSanPham) }}" method="POST" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-box-open fa-3x mb-3"></i>
                        <p>Không tìm thấy mẫu áo dài nào phù hợp.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: '<span style="font-family: serif; color: #1f2937;">Xác nhận xóa danh mục</span>',
            html: `<div class="mt-3 text-stone-500 text-sm">Sản phẩm <b class="text-stone-900 italic">"${name}"</b> sẽ bị xóa. <br><span class="text-red-600 font-bold">Lưu ý: Hành động này không thể hoàn tác!</span></div>`,
            icon: 'question', 
            iconColor: '#991b1b',
            showCancelButton: true,
            confirmButtonText: 'Xác nhận xóa',
            cancelButtonText: 'Hủy bỏ',
            reverseButtons: true,
            customClass: {
                popup: 'glass-popup',
                confirmButton: 'btn-delete-confirm',
                cancelButton: 'btn-delete-cancel'
            },
            buttonsStyling: false, 
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
    @if(session('success'))
        Swal.fire({
            title: '<span style="font-family: serif; color: #15803d;">Thành công</span>',
            text: "{{ session('success') }}",
            icon: 'success',
            timer: 2000,
            showConfirmButton: false,
            customClass: {
                popup: 'glass-popup'
            }
        });
    @endif
</script>

<style>
    
    .glass-popup {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
        border-radius: 24px !important;
        padding: 2rem !important;
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }

    .btn-delete-confirm {
        background-color: #991b1b !important;
        color: white !important;
        padding: 10px 25px !important;
        border-radius: 12px !important;
        font-weight: 600 !important;
        margin-left: 10px !important;
        transition: all 0.3s !important;
        font-size: 14px !important;
    }

    .btn-delete-confirm:hover {
        background-color: #7f1d1d !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(153, 27, 27, 0.3);
    }

    .btn-delete-cancel {
        background-color: #f3f4f6 !important;
        color: #4b5563 !important;
        padding: 10px 25px !important;
        border-radius: 12px !important;
        font-weight: 600 !important;
        transition: all 0.3s !important;
        font-size: 14px !important;
    }

    .btn-delete-cancel:hover {
        background-color: #e5e7eb !important;
    }
</style>
@endsection