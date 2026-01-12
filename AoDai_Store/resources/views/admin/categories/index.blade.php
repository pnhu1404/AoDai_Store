@extends('layouts.admin')

@section('title', 'Danh sách Danh mục Áo Dài')

@section('content')
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg shadow-sm flex items-center border-l-4 border-indigo-500">
                <div class="p-3 bg-indigo-100 rounded-full text-indigo-600 mr-4">
                    <i class="fas fa-layer-group fa-lg"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 uppercase">Tổng số danh mục</p>
                    <p class="text-xl font-bold text-gray-800">{{ $categories->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex flex-col md:flex-row justify-between gap-4">
                <form action="{{ route('admin.categories.index') }}" method="GET" class="flex flex-1 gap-2">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition"
                            placeholder="Tìm tên danh mục hoặc mã...">
                    </div>
                    <button type="submit"
                        class="bg-slate-800 text-white px-6 py-2 rounded-lg hover:bg-slate-700 transition">
                        Lọc
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.categories.index') }}"
                            class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg flex items-center">
                            Xóa lọc
                        </a>
                    @endif
                </form>

                <a href="{{ route('admin.categories.create') }}"
                    class="inline-flex items-center justify-center bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-semibold shadow-md">
                    <i class="fas fa-plus-circle mr-2"></i> Thêm Danh Mục
                </a>
            </div>
        </div>
        <div id="category-table-container">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider font-bold">
                            <th class="px-6 py-4 border-b">Tên danh mục</th>
                            <th class="px-6 py-4 border-b">Mô tả</th>
                            <th class="px-6 py-4 border-b">Số lượng sản phẩm</th>
                            <th class="px-6 py-4 border-b">Ngày tạo</th>
                            <th class="px-6 py-4 border-b text-center">Chức năng</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($categories as $category)
                            <tr class="hover:bg-indigo-50/30 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center mr-3 font-bold">
                                            {{ substr($category->TenLoaiSP, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">{{ $category->TenLoaiSP }}</p>
                                            <p class="text-xs text-gray-400 font-mono">ID: #{{ $category->MaLoaiSP }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-stone-500 italic">
                                    {{ $category->MoTa }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-gray-100 text-stone-600 rounded-full text-xs font-bold">
                                        {{ $category->sanpham_count ?? 0 }} sản phẩm
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $category->CreatedDate ? date('d/m/Y', strtotime($category->CreatedDate)) : '---' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center space-x-3 text-sm">
                                        <a href="{{ route('admin.categories.edit', $category->MaLoaiSP) }}"
                                            class="text-blue-600 hover:text-blue-800 transition p-2 bg-blue-50 rounded-full"
                                            title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <button type="button"
                                            onclick="confirmDelete('{{ $category->MaLoaiSP }}', '{{ $category->TenLoaiSP }}')"
                                            class="text-red-600 hover:text-red-800 transition p-2 bg-red-50 rounded-full"
                                            title="Xóa">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fas fa-folder-open fa-3x mb-3"></i>
                                    <p>Không tìm thấy danh mục nào phù hợp.</p>
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
                    console.log('Danh sách đã được cập nhật');
                })
                .catch(error => console.error('Lỗi khi tải lại bảng:', error));
        }
        function confirmDelete(id, name) {
            Swal.fire({
                title: '<span style="font-family: serif; color: #1f2937;">Xác nhận xóa danh mục</span>',
                html: `<div class="mt-3 text-stone-500 text-sm">Danh mục <b class="text-stone-900 italic">"${name}"</b> sẽ bị xóa. <br><span class="text-red-600 font-bold">Lưu ý: Hành động này không thể hoàn tác!</span></div>`,
                icon: 'warning',
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
                    var message = result.value.message;
                    if (result.value.success) {
                        Swal.fire({
                            title: 'Thành công!',
                            text: message,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        refreshTable();

                    } else {
                        Swal.fire({
                            title: 'Thất bại!',
                            text: message,
                            icon: 'error',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                }
            });
        }
    </script>

    <style>
        .glass-popup {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-radius: 24px !important;
            padding: 2rem !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
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