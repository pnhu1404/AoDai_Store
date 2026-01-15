@extends('layouts.admin')

@section('title', 'Danh sách Áo Dài')

@section('content')
<div class="space-y-6" id="full-container">
    {{-- Thẻ thống kê --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-100 flex items-center">
            <div class="p-3 bg-stone-50 rounded-xl text-stone-600 mr-4">
                <i class="fas fa-tshirt fa-lg"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Tổng mẫu thiết kế</p>
                <p class="text-xl font-bold text-gray-800">{{ $totalProducts }}</p>
            </div>
        </div>
        
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-100 flex items-center">
            <div class="p-3 bg-green-50 rounded-xl text-green-600 mr-4">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Đang kinh doanh</p>
                <p class="text-xl font-bold text-stone-800">{{ $products->where('TrangThai', 1)->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Bộ lọc --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-50">
        <form action="{{ route('admin.products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="relative md:col-span-2">
                <span class="absolute inset-y-0 left-3 flex items-center text-stone-400">
                    <i class="fas fa-search text-xs"></i>
                </span>
                <input type="text" name="search" placeholder="Tìm tên, mã sản phẩm, chất liệu..." value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 py-2 bg-stone-50 border border-stone-200 rounded-xl text-xs focus:ring-0 focus:border-stone-800 transition-all">
            </div>

            <select name="category" class="bg-stone-50 border border-stone-200 rounded-xl py-2 px-4 text-xs focus:ring-0 focus:border-stone-800 transition-all">
                <option value="">-- Tất cả loại --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->MaLoaiSP }}" {{ request('category') == $cat->MaLoaiSP ? 'selected' : '' }}>
                        {{ $cat->TenLoaiSP }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-stone-900 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-red-800 transition-all py-2 shadow-md">
                Lọc dữ liệu
            </button>

            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center bg-stone-100 text-stone-800 border border-stone-200 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-green-600 hover:text-white hover:border-green-600 transition-all py-2 shadow-sm">
                <i class="fas fa-plus-circle mr-2"></i> Thêm Áo Dài
            </a>
        </form>
    </div>

    {{-- Bảng sản phẩm --}}
    <div id="product-table-container" class="bg-white rounded-2xl shadow-sm border border-stone-100 overflow-hidden text-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-stone-50 text-stone-500 text-[10px] uppercase tracking-[0.2em] font-bold">
                        <th class="px-6 py-5 border-b border-stone-100">Sản Phẩm</th>
                        <th class="px-6 py-5 border-b border-stone-100 text-center">Trạng Thái</th>
                        <th class="px-6 py-5 border-b border-stone-100 text-center">Số Lượng</th>
                        <th class="px-6 py-5 border-b border-stone-100 text-center">Giá Niêm Yết</th>
                        <th class="px-6 py-5 border-b border-stone-100 text-center">Ngày Tạo</th>
                        <th class="px-6 py-5 border-b border-stone-100 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @forelse($products as $product)
                    <tr class="hover:bg-stone-50/50 transition duration-150 group">
                        <td class="px-6 py-5">
                            <div class="flex items-center">
                                <img src="{{ asset('/img/products/' . $product->HinhAnh) }}" 
                                     class="w-12 h-16 object-cover rounded-lg shadow-sm mr-4 border border-stone-100 group-hover:scale-105 transition-transform duration-300" 
                                     onerror="this.src='https://placehold.co/400x600?text=No+Image'">
                                <div>
                                    <p class="font-bold text-stone-800 group-hover:text-red-800 transition-colors uppercase tracking-tight">{{ $product->TenSanPham }}</p>
                                    <p class="text-[10px] text-stone-400 mt-1 italic line-clamp-1 max-w-[200px]">{{ $product->MoTa }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($product->TrangThai == 1)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide bg-green-50 text-green-700 border border-green-100">
                                    <span class="w-1 h-1 mr-1.5 rounded-full bg-green-600"></span> Đang bán
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide bg-stone-100 text-stone-400 border border-stone-200">
                                    <span class="w-1 h-1 mr-1.5 rounded-full bg-stone-400"></span> Tạm ngưng
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="text-xs font-mono font-bold px-2 py-1 bg-blue-50 text-blue-700 rounded-md shadow-inner">
                                {{ number_format($product->tong_so_luong ?? 0) }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center font-bold text-red-800">
                            {{ number_format($product->GiaBan, 0, ',', '.') }}đ
                        </td>
                        <td class="px-6 py-5 text-center text-[11px] text-stone-500">
                            {{ $product->CreatedDate ? date('d/m/Y', strtotime($product->CreatedDate)) : '---' }}
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex justify-end space-x-2">
                                <button onclick="toggleProductStatus('{{ $product->MaSanPham }}', {{ $product->TrangThai }})"
                                    class="flex items-center px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest {{ $product->TrangThai == 1 ? 'text-amber-600 border-amber-100 hover:bg-amber-600' : 'text-green-600 border-green-100 hover:bg-green-600' }} hover:text-white transition-all rounded-lg border">
                                    <i class="fas {{ $product->TrangThai == 1 ? 'fa-eye-slash' : 'fa-eye' }} mr-1.5"></i>
                                    {{ $product->TrangThai == 1 ? 'Ẩn' : 'Hiện' }}
                                </button>

                                <a href="{{ route('admin.products.edit', $product->MaSanPham) }}" 
                                   class="flex items-center px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest text-blue-600 hover:bg-blue-600 hover:text-white transition-all rounded-lg border border-blue-100">
                                    <i class="fas fa-edit mr-1.5"></i> Sửa
                                </a>
                                
                                <button type="button" 
                                        onclick="confirmDelete('{{ $product->MaSanPham }}', '{{ $product->TenSanPham }}')" 
                                        class="flex items-center px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest text-red-600 hover:bg-red-700 hover:text-white transition-all rounded-lg border border-red-100">
                                    <i class="fas fa-trash-alt mr-1.5"></i> Xóa
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center text-stone-400 italic font-light">
                            <i class="fas fa-box-open fa-3x mb-4 opacity-20"></i><br>
                            Không tìm thấy mẫu áo dài nào trong hệ thống.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Hàm Toggle Trạng thái Sản phẩm
    function toggleProductStatus(id, currentStatus) {
        const newStatus = currentStatus === 1 ? 0 : 1;
        const actionText = newStatus === 1 ? 'mở bán lại' : 'tạm ngưng kinh doanh';
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: '<span class="serif">Trạng thái kinh doanh</span>',
            html: `<div class="text-stone-500 text-sm">Bạn muốn ${actionText} mẫu thiết kế này?</div>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Xác nhận',
            cancelButtonText: 'Hủy',
            confirmButtonColor: '#1c1917',
            customClass: { popup: 'glass-popup', confirmButton: 'btn-delete-confirm', cancelButton: 'btn-delete-cancel' },
            buttonsStyling: false,
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/products/toggle-status/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({ icon: 'success', title: 'Đã cập nhật', timer: 1000, showConfirmButton: false, customClass: { popup: 'glass-popup' } });
                        refreshProductTable();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    }

    function refreshProductTable() {
        const container = document.getElementById('full-container');
        fetch(window.location.href)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                container.innerHTML = doc.getElementById('full-container').innerHTML;
            });
    }

    function confirmDelete(id, name) {
        Swal.fire({
            title: '<span class="serif">Xác nhận xóa bỏ</span>',
            html: `<div class="mt-3 text-stone-500 text-sm">Mẫu thiết kế <b class="text-stone-900 italic">"${name}"</b> sẽ bị xóa khỏi danh sách kinh doanh. <br><span class="text-red-600 font-bold">Lưu ý: Không thể hoàn tác hành động này!</span></div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Đồng ý xóa',
            cancelButtonText: 'Hủy bỏ',
            confirmButtonColor: '#1c1917',
            customClass: { popup: 'glass-popup', confirmButton: 'btn-delete-confirm', cancelButton: 'btn-delete-cancel' },
            buttonsStyling: false,
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/products/${id}`;
                form.innerHTML = `@csrf @method('DELETE')`;
                document.body.appendChild(form);
                form.submit();
            }
        })
    }
</script>

<style>
    .serif { font-family: 'Playfair Display', serif; }
    .glass-popup {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
        border-radius: 24px !important;
        padding: 2rem !important;
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }
    .btn-delete-confirm {
        background-color: #1c1917 !important;
        color: white !important;
        padding: 10px 25px !important;
        border-radius: 12px !important;
        font-weight: 600 !important;
        margin-left: 10px !important;
        font-size: 12px !important;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        transition: all 0.3s;
    }
    .btn-delete-confirm:hover { background-color: #991b1b !important; transform: translateY(-2px); }
    .btn-delete-cancel {
        background-color: #f3f4f6 !important;
        color: #4b5563 !important;
        padding: 10px 25px !important;
        border-radius: 12px !important;
        font-weight: 600 !important;
        font-size: 12px !important;
        text-transform: uppercase;
        transition: all 0.3s;
    }
</style>
@endsection