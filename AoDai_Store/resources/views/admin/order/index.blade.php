@extends('layouts.admin')

@section('title', 'Quản lý Hóa đơn')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-100 flex items-center">
            <div class="p-3 bg-blue-50 rounded-xl text-blue-600 mr-4">
                <i class="fas fa-file-invoice-dollar fa-lg"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Tổng đơn hàng</p>
                <p class="text-xl font-bold text-gray-800">{{ $orders->total() }}</p>
            </div>
        </div>
        
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-100 flex items-center">
            <div class="p-3 bg-amber-50 rounded-xl text-amber-600 mr-4">
                <i class="fas fa-clock fa-lg"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Chờ xác nhận</p>
                <p class="text-xl font-bold text-gray-800">{{ $orders->where('TrangThai', 'ChoXacNhan')->count() }}</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-100 flex items-center">
            <div class="p-3 bg-green-50 rounded-xl text-green-600 mr-4">
                <i class="fas fa-hand-holding-usd fa-lg"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Doanh thu tháng</p>
                <p class="text-xl font-bold text-gray-800">{{ number_format($monthlyRevenue, 0, ',', '.') }}đ</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-50">
        <form action="{{ route('orders.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-stone-400">
                    <i class="fas fa-search text-xs"></i>
                </span>
                <input type="text" name="search" placeholder="Mã đơn, tên, SĐT..." value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 py-2 bg-stone-50 border border-stone-200 rounded-xl text-xs focus:ring-0 focus:border-red-800 transition-all">
            </div>
            <select name="status" class="bg-stone-50 border border-stone-200 rounded-xl py-2 px-4 text-xs focus:ring-0 focus:border-red-800 transition-all">
                <option value="">-- Tất cả trạng thái --</option>
                <option value="ChoXacNhan">Chờ xác nhận</option>
                <option value="DaXacNhan">Đã xác nhận</option>
                <option value="DangGiao">Đang giao hàng</option>
                <option value="DaGiao">Đã giao hàng</option>
                <option value="DaHuy">Đã hủy</option>
            </select>
            <input type="date" name="date" class="bg-stone-50 border border-stone-200 rounded-xl py-2 px-4 text-xs focus:ring-0 focus:border-red-800 transition-all">
            <button type="submit" class="bg-stone-900 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-red-800 transition-all py-2">
                Lọc dữ liệu
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-stone-100 overflow-hidden text-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-stone-50 text-stone-500 text-[10px] uppercase tracking-[0.2em] font-bold">
                    <th class="px-6 py-5 border-b border-stone-100">Mã Đơn</th>
                    <th class="px-6 py-5 border-b border-stone-100">Khách Hàng</th>
                    <th class="px-6 py-5 border-b border-stone-100">Giá Trị</th>
                    <th class="px-6 py-5 border-b border-stone-100">Thanh Toán</th>
                    <th class="px-6 py-5 border-b border-stone-100">Ngày Đặt</th>
                    <th class="px-6 py-5 border-b border-stone-100 text-center">Trạng Thái</th>
                    <th class="px-6 py-5 border-b border-stone-100 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-50">
                @forelse($orders as $order)
                <tr class="hover:bg-stone-50/50 transition duration-150">
                    <td class="px-6 py-5">
                        <span class="font-mono font-bold text-stone-800">#HD-{{ $order->MaHoaDon }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <p class="font-bold text-stone-800">{{ $order->TenNguoiNhan }}</p>
                        <p class="text-[10px] text-stone-400 mt-0.5"><i class="fas fa-phone mr-1"></i> {{ $order->SDTNguoiNhan }}</p>
                    </td>
                    <td class="px-6 py-5">
                        <p class="font-bold text-red-800">{{ number_format($order->TongTien, 0, ',', '.') }}đ</p>
                        <p class="text-[10px] text-stone-400">Giảm: {{ number_format($order->GiamGia*1000, 0, ',', '.') }}đ</p>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-[10px] uppercase font-bold tracking-tighter text-stone-600 block">{{ $order->PhuongThucThanhToan }}</span>
                        @if($order->NgayThanhToan)
                            <span class="text-[9px] text-green-600 italic">Đã thanh toán</span>
                        @else
                            <span class="text-[9px] text-amber-600 italic">Chưa thanh toán</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-xs text-stone-500">
                        {{ date('d/m/Y H:i', strtotime($order->NgayTao)) }}
                    </td>
                    <td class="px-6 py-5 text-center">
                        @php
                            $statusClasses = [
                                'ChoXacNhan' => 'bg-amber-50 text-amber-700 border-amber-100',
                                'DaXacNhan' => 'bg-blue-50 text-blue-700 border-blue-100',
                                'DangGiao' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                'DaGiao' => 'bg-green-50 text-green-700 border-green-100',
                                'DaHuy' => 'bg-red-50 text-red-700 border-red-100',
                            ];
                            $statusText = [
                                'ChoXacNhan' => 'Chờ xác nhận',
                                'DaXacNhan' => 'Đã xác nhận',
                                'DangGiao' => 'Đang giao hàng',
                                'DaGiao' => 'Đã giao hàng',
                                'DaHuy' => 'Đã hủy',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $statusClasses[$order->TrangThai] ?? 'bg-stone-50' }}">
                            {{ $statusText[$order->TrangThai] ?? $order->TrangThai }}
                        </span>
                    </td>
                    
                    <td class="px-6 py-5">
                    <div class="flex justify-end space-x-2">

                        {{-- XEM --}}
                        <a href="{{ route('orders.show', $order->MaHoaDon) }}"
                        class="w-8 h-8 flex items-center justify-center text-stone-500 hover:bg-stone-900 hover:text-white transition-all rounded-lg border border-stone-200">
                            <i class="fas fa-eye text-xs"></i>
                        </a>

                        {{-- CHỜ XÁC NHẬN --}}
                        @if($order->TrangThai === 'ChoXacNhan')
                            {{-- XÁC NHẬN --}}
                            <form action="{{ route('orders.confirmstatus', $order->MaHoaDon) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center text-green-600 hover:bg-green-600 hover:text-white transition-all rounded-lg border border-green-200"
                                    title="Xác nhận đơn">
                                    <input type="hidden" name="status" value="DaXacNhan">
                                    <i class="fas fa-check text-xs"></i>
                                </button>
                            </form>

                            {{-- HỦY --}}
                            <form action="{{ route('orders.confirmstatus', $order->MaHoaDon) }}" method="POST"
                                onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn này?')">
                                @csrf
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition-all rounded-lg border border-red-200"
                                    title="Hủy đơn">
                                    <input type="hidden" name="status" value="DaHuy">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </form>
                        @endif

                        {{-- ĐÃ XÁC NHẬN --}}
                        @if($order->TrangThai === 'DaXacNhan')
                            <form action="{{ route('orders.confirmstatus', $order->MaHoaDon) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all rounded-lg border border-indigo-200"
                                    title="Chuyển sang đang giao">
                                    <input type="hidden" name="status" value="DangGiao">
                                    <i class="fas fa-truck text-xs"></i>
                                </button>
                            </form>
                        @endif

                    </div>
                </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-stone-400 italic font-light">
                        <i class="fas fa-box-open fa-3x mb-4 opacity-20"></i><br>
                        Không có dữ liệu hóa đơn nào được tìm thấy.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>



@endsection