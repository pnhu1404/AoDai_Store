@extends('layouts.admin')

@section('title', 'Danh sách Danh mục Áo Dài')

@section('content')
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-100 flex items-center">
                <div class="p-3 bg-stone-50 rounded-xl text-stone-600 mr-4">
                    <i class="fas fa-layer-group fa-lg"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Tổng số danh mục</p>
                    <p class="text-xl font-bold text-gray-800">{{ $categories->count() }}</p>
                </div>
            </div>
            
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-100 flex items-center opacity-50">
                <div class="p-3 bg-stone-50 rounded-xl text-stone-400 mr-4">
                    <i class="fas fa-info-circle fa-lg"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Trạng thái</p>
                    <p class="text-xl font-bold text-gray-400 italic text-sm">Đang cập nhật</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-50">
            <form action="{{ route('admin.categories.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="relative md:col-span-3">
                    <span class="absolute inset-y-0 left-3 flex items-center text-stone-400">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text" name="search" placeholder="Tìm tên danh mục, mã danh mục..." value="{{ request('search') }}"
                        class="w-full pl-10 pr-4 py-2 bg-stone-50 border border-stone-200 rounded-xl text-xs focus:ring-0 focus:border-stone-800 transition-all">
                </div>

                <button type="submit" class="bg-stone-900 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-red-800 transition-all py-2 shadow-md">
                    Lọc dữ liệu
                </button>

                <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center justify-center bg-stone-100 text-stone-800 border border-stone-200 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-green-600 hover:text-white hover:border-green-600 transition-all py-2 shadow-sm">
                    <i class="fas fa-plus-circle mr-2"></i> Thêm Danh Mục
                </a>
            </form>
        </div>

        <div id="category-table-container">
            <div class="bg-white rounded-2xl shadow-sm border border-stone-100 overflow-hidden text-sm">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-stone-50/50 text-stone-500 text-[10px] uppercase tracking-[0.2em] font-bold border-b border-stone-100">
                            <th class="px-6 py-5">Tên danh mục</th>
                            <th class="px-6 py-5">Mô tả chi tiết</th>
                            <th class="px-6 py-5 text-center">Sản phẩm</th>
                            <th class="px-6 py-5 text-center">Ngày tạo</th>
                            <th class="px-6 py-5 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-50">
                        @forelse($categories as $category)
                            <tr class="hover:bg-stone-50/30 transition duration-150 group">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <p class="font-bold text-stone-800 group-hover:text-red-800 transition-colors uppercase tracking-tight text-sm">
                                            {{ $category->TenLoaiSP }}
                                        </p>
                                        <p class="text-[10px] text-stone-400 font-mono mt-0.5">#{{ $category->MaLoaiSP }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-stone-500 italic text-xs max-w-xs truncate">
                                    {{ $category->MoTa ?? 'Không có mô tả' }}
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="px-3 py-1 bg-stone-50 text-stone-600 rounded-full text-[10px] font-bold uppercase tracking-wider border border-stone-100">
                                        {{ $category->sanpham_count ?? 0 }} sản phẩm
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center text-[10px] text-stone-500 font-medium">
                                    {{ $category->CreatedDate ? date('d/m/Y', strtotime($category->CreatedDate)) : '---' }}
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('admin.categories.edit', $category->MaLoaiSP) }}"
                                            class="flex items-center px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest text-blue-600 hover:bg-blue-600 hover:text-white transition-all rounded-lg border border-blue-100">
                                            <i class="fas fa-edit mr-1.5"></i> Sửa
                                        </a>

                                        <button type="button"
                                            onclick="confirmDelete('{{ $category->MaLoaiSP }}', '{{ $category->TenLoaiSP }}')"
                                            class="flex items-center px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest text-red-600 hover:bg-red-700 hover:text-white transition-all rounded-lg border border-red-100">
                                            <i class="fas fa-trash-alt mr-1.5"></i> Xóa
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center text-stone-400 italic">
                                    <i class="fas fa-folder-open fa-2x mb-3 opacity-20 block text-center"></i>
                                    Không tìm thấy danh mục nào phù hợp.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function refreshTable() {
            const container = document.getElementById('category-table-container');
            const currentUrl = window.location.href;
            fetch(currentUrl)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.getElementById('category-table-container').innerHTML;
                    container.innerHTML = newContent;
                })
                .catch(error => console.error('Lỗi khi tải lại bảng:', error));
        }

        function confirmDelete(id, name) {
            Swal.fire({
                title: '<span class="serif">Xác nhận gỡ bỏ</span>',
                html: `<div class="mt-3 text-stone-500 text-sm">Danh mục <b class="text-stone-900 italic">"${name}"</b> sẽ bị xóa khỏi hệ thống. <br><span class="text-red-600 font-bold">Lưu ý: Hành động này không thể hoàn tác!</span></div>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý xóa',
                cancelButtonText: 'Hủy bỏ',
                confirmButtonColor: '#1c1917',
                cancelButtonColor: '#f3f4f6',
                reverseButtons: true,
                customClass: {
                    popup: 'glass-popup',
                    confirmButton: 'btn-delete-confirm',
                    cancelButton: 'btn-delete-cancel'
                },
                buttonsStyling: false,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const url = `/admin/categories/delete/${id}`;
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    return fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => { throw new Error(err.message || 'Lỗi không xác định') });
                        }
                        return response.json();
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Lỗi: ${error.message}`);
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    if (result.value.success) {
                        Swal.fire({
                            title: 'Thành công!',
                            text: result.value.message,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false,
                            customClass: { popup: 'glass-popup' }
                        });
                        refreshTable();
                    } else {
                        Swal.fire({
                            title: 'Thất bại!',
                            text: result.value.message,
                            icon: 'error',
                            customClass: { popup: 'glass-popup' }
                        });
                    }
                }
            });
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
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
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
        .btn-delete-confirm:hover {
            background-color: #991b1b !important;
            transform: translateY(-2px);
        }
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