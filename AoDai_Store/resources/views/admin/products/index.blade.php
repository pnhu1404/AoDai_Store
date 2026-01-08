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
                <p class="text-xl font-bold text-gray-800">{{ $products->total() }}</p>
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
                    <th class="px-6 py-4 border-b">Thông tin vải</th>
                    <th class="px-6 py-4 border-b">Giá niêm yết</th>
                    <th class="px-6 py-4 border-b">Ngày tạo</th>
                    <th class="px-6 py-4 border-b text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-blue-50/30 transition duration-150">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-16 object-cover rounded shadow-sm mr-4" onerror="this.src='https://placehold.co/400x600?text=No+Image'">
                            <div>
                                <p class="font-bold text-gray-800">{{ $product->name }}</p>
                                <p class="text-xs text-gray-400 font-mono">ID: #{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">
                            {{ $product->material ?? 'Chưa cập nhật' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-bold text-red-600">
                        {{ number_format($product->price) }} đ
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $product->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center space-x-3 text-sm">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 transition p-2 bg-blue-50 rounded-full" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <button type="button" 
                                    onclick="confirmDelete('{{ $product->id }}', '{{ $product->name }}')" 
                                    class="text-red-600 hover:text-red-800 transition p-2 bg-red-50 rounded-full" title="Xóa">
                                <i class="fas fa-trash-alt"></i>
                            </button>

                            <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="hidden">
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

        <div class="px-6 py-4 bg-gray-50">
            {{ $products->links() }}
        </div>
    </div>
</div>

{{-- Nhúng SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Xác nhận xóa?',
            text: `Bạn chuẩn bị xóa mẫu "${name}". Hành động này không thể hoàn tác!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Xóa ngay',
            cancelButtonText: 'Hủy bỏ',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection