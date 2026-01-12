@extends('layouts.admin')

@section('title', 'Quản lý Khuyến mãi')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-100 flex items-center">
            <div class="p-3 bg-red-50 rounded-xl text-red-600 mr-4">
                <i class="fas fa-ticket-alt fa-lg"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Tổng chương trình</p>
                <p class="text-xl font-bold text-gray-800">{{ $promotions->total() }}</p>
            </div>
        </div>
        
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-100 flex items-center">
            <div class="p-3 bg-green-50 rounded-xl text-green-600 mr-4">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Đang chạy</p>
                <p class="text-xl font-bold text-gray-800">{{ $promotions->where('TrangThai', 1)->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-stone-50 flex flex-col md:flex-row justify-between items-center gap-4">
        <h3 class="serif text-xl font-bold text-stone-800 ml-2 italic">Danh sách mã ưu đãi</h3>
        <a href="{{ route('promotions.create') }}" class="inline-flex items-center bg-stone-900 text-white px-6 py-3 rounded-xl hover:bg-red-900 transition-all duration-300 font-semibold shadow-lg text-xs uppercase tracking-widest">
            <i class="fas fa-plus-circle mr-2"></i> Thêm khuyến mãi
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-stone-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-stone-50/50 text-stone-500 text-[10px] uppercase tracking-[0.2em] font-bold border-b border-stone-100">
                        <th class="px-6 py-5">Chi tiết Khuyến mãi</th>
                        <th class="px-6 py-5 text-center">Mã Code</th>
                        <th class="px-6 py-5 text-center">Mức ưu đãi</th>
                        <th class="px-6 py-5 text-center">Số lượng</th>
                        <th class="px-6 py-5 text-center">Thời hạn</th>
                        <th class="px-6 py-5 text-center">Trạng thái</th>
                        <th class="px-6 py-5 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @forelse($promotions as $promotion)
                    <tr class="hover:bg-stone-50/30 transition duration-150 group">
                        <td class="px-6 py-5">
                            <p class="font-bold text-stone-800 text-sm group-hover:text-red-800 transition-colors uppercase tracking-tight">{{ $promotion->TenKhuyenMai }}</p>
                            <p class="text-[10px] text-stone-400 mt-1">
                                <i class="fas fa-shopping-cart mr-1"></i> Đơn tối thiểu: 
                                <span class="text-stone-600 font-bold">{{ number_format($promotion->Dieukienkhuyenmai, 0, ',', '.') }}đ</span>
                            </p>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="px-3 py-1.5 bg-stone-800 text-white rounded-lg text-[10px] font-mono font-bold tracking-[0.1em] uppercase">
                                {{ $promotion->MaCode }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($promotion->LoaiGiam == 1) <div class="flex flex-col items-center">
                                    <span class="text-red-700 font-bold text-base">{{ $promotion->GiaTriGiam }}%</span>
                                    @if($promotion->GiamToiDa)
                                        <span class="text-[9px] text-stone-400 whitespace-nowrap">Tối đa: {{ number_format($promotion->GiamToiDa, 0, ',', '.') }}đ</span>
                                    @endif
                                </div>
                            @else <span class="text-stone-800 font-bold text-sm">-{{ number_format($promotion->GiaTriGiam, 0, ',', '.') }}đ</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="text-xs font-semibold px-2 py-1 bg-blue-50 text-blue-700 rounded-md">
                                {{ $promotion->SoLuong }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center text-[10px] text-stone-500 font-medium">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-green-600 font-bold">{{ date('d/m/Y', strtotime($promotion->NgayBatDau)) }}</span>
                                <span class="text-stone-300">đến</span>
                                <span class="text-red-600 font-bold">{{ date('d/m/Y', strtotime($promotion->NgayKetThuc)) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($promotion->TrangThai == 1)
                                <span class="inline-flex items-center px-3 py-1 bg-green-50 text-green-700 rounded-full text-[9px] font-bold uppercase tracking-wider border border-green-100">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></span> Đang chạy
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 bg-stone-100 text-stone-400 rounded-full text-[9px] font-bold uppercase tracking-wider border border-stone-200">
                                    <span class="w-1.5 h-1.5 bg-stone-400 rounded-full mr-2"></span> Tạm khóa
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('promotions.edit', $promotion->MaKhuyenMai) }}" class="text-stone-400 hover:text-blue-600 transition-all transform hover:scale-110">
                                    <i class="fas fa-pencil-alt text-xs"></i>
                                </a>
                                
                                <button type="button" 
                                        onclick="confirmDelete('{{ $promotion->MaKhuyenMai }}', '{{ $promotion->TenKhuyenMai }}')" 
                                        class="text-stone-400 hover:text-red-700 transition-all transform hover:scale-110">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>

                                <form id="delete-{{ $promotion->MaKhuyenMai }}" action="{{ route('promotions.destroy', $promotion->MaKhuyenMai) }}" method="POST" class="hidden">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-20 text-center text-stone-400 italic">Dữ liệu hiện đang trống.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8">
        {{ $promotions->links() }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: '<span class="serif">Xác nhận gỡ bỏ</span>',
            html: `Mã ưu đãi <b>${name}</b> sẽ bị xóa khỏi hệ thống?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy',
            confirmButtonColor: '#1c1917',
            cancelButtonColor: '#f5f5f4',
            customClass: {
                confirmButton: 'text-white px-6 py-2 rounded-xl font-bold',
                cancelButton: 'text-stone-600 px-6 py-2 rounded-xl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-' + id).submit();
            }
        })
    }
</script>
@endsection