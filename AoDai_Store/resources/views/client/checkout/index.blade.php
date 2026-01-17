@extends('layouts.client')

@section('title', 'Thanh toán đơn hàng')

@section('content')

<div class="bg-stone-50 py-16">
    <section class="max-w-6xl mx-auto px-4 min-h-screen">
        <div class="mb-12">
            <h2 class="serif text-3xl font-bold text-stone-800 tracking-tight">Thanh toán</h2>
            <p class="text-stone-500 text-sm mt-2 font-light">Hoàn tất các bước cuối cùng để sở hữu bộ Áo Dài ưng ý.</p>
        </div>

        <form id="checkout-form" action="{{ route('order.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-8">
                        <div class="flex items-center gap-3 mb-8 pb-4 border-b border-stone-100">
                            <span class="w-8 h-8 bg-red-800 text-white rounded-full flex items-center justify-center text-xs">1</span>
                            <h3 class="font-bold text-stone-800 uppercase text-sm tracking-wider">Thông tin giao hàng</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-stone-600 mb-2 ml-1">Họ và tên *</label>
                                <input type="text" name="TenNguoiNhan" value="{{ old('TenNguoiNhan', $info->HoTen ?? '') }}" required 
                                    class="w-full bg-stone-50 border border-stone-200 rounded-xl px-4 py-3 focus:bg-white focus:border-red-800 transition-all outline-none text-stone-700">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-stone-600 mb-2 ml-1">Số điện thoại *</label>
                                <input type="tel" name="SDTNguoiNhan" value="{{ old('SDTNguoiNhan', $info->SoDienThoai ?? '') }}" required 
                                    class="w-full bg-stone-50 border border-stone-200 rounded-xl px-4 py-3 focus:bg-white focus:border-red-800 transition-all outline-none text-stone-700">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-stone-600 mb-2 ml-1">Ghi chú (tùy chọn)</label>
                                <textarea name="GhiChu" rows="3" 
                                    placeholder="Ví dụ: Giao giờ hành chính, gọi trước khi đến..."
                                    class="w-full bg-stone-50 border border-stone-200 rounded-xl px-4 py-3 focus:bg-white focus:border-red-800 transition-all outline-none text-stone-700 resize-none"></textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-stone-600 mb-2 ml-1">Số nhà, tên đường *</label>
                                <input type="text" name="so_nha" value="{{ old('so_nha', $addressData['soNha']) }}" required 
                                    placeholder="Ví dụ: 123 Lê Lợi"
                                    class="w-full bg-stone-50 border border-stone-200 rounded-xl px-4 py-3 focus:bg-white focus:border-red-800 transition-all outline-none text-stone-700">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-stone-600 mb-2 ml-1">Phường / Xã *</label>
                                <input type="text" name="phuong_xa" value="{{ old('phuong_xa', $addressData['phuongXa']) }}" required 
                                    class="w-full bg-stone-50 border border-stone-200 rounded-xl px-4 py-3 focus:bg-white focus:border-red-800 transition-all outline-none text-stone-700">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-stone-600 mb-2 ml-1">Quận / Huyện *</label>
                                <input type="text" name="quan_huyen" value="{{ old('quan_huyen', $addressData['quanHuyen']) }}" required 
                                    class="w-full bg-stone-50 border border-stone-200 rounded-xl px-4 py-3 focus:bg-white focus:border-red-800 transition-all outline-none text-stone-700">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-stone-600 mb-2 ml-1">Tỉnh / Thành phố *</label>
                                <select name="tinh_thanh" required 
                                        class="w-full bg-stone-50 border border-stone-200 rounded-xl px-4 py-3 focus:bg-white focus:border-red-800 outline-none text-stone-700">
                                    <option value="">Chọn Tỉnh/Thành phố</option>
                                    @php $tinhs = ['Hà Nội', 'Hồ Chí Minh', 'Đà Nẵng', 'Cần Thơ', 'Hải Phòng']; @endphp
                                    @foreach($tinhs as $tinh)
                                        <option value="{{ $tinh }}" {{ (old('tinh_thanh', $addressData['tinhThanh']) == $tinh) ? 'selected' : '' }}>
                                            {{ $tinh }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-8">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-stone-100">
                            <span class="w-8 h-8 bg-red-800 text-white rounded-full flex items-center justify-center text-xs">2</span>
                            <h3 class="font-bold text-stone-800 uppercase text-sm tracking-wider">Hình thức thanh toán</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="flex items-center gap-4 p-4 border border-stone-200 rounded-xl cursor-pointer hover:border-red-800 transition-all has-[:checked]:bg-red-50/50 has-[:checked]:border-red-800">
                                <input type="radio" name="PhuongThucThanhToan" value="cod" checked class="text-red-800 focus:ring-0">
                                <span class="text-sm font-medium text-stone-700">Thanh toán khi nhận hàng</span>
                            </label>
                            <label class="flex items-center gap-4 p-4 border border-stone-200 rounded-xl cursor-pointer hover:border-red-800 transition-all has-[:checked]:bg-red-50/50 has-[:checked]:border-red-800">
                                <input type="radio" name="PhuongThucThanhToan" value="vnpay" class="text-red-800 focus:ring-0">
                                <span class="text-sm font-medium text-stone-700">Chuyển khoản VNPAY</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white rounded-2xl shadow-md border border-stone-100 p-6 sticky top-8">
                        <h3 class="font-bold text-stone-800 uppercase text-xs tracking-widest mb-6">Đơn hàng của bạn</h3>
                        
                       <div class="space-y-4 mb-6 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($cartItems as $item)
                            <div class="flex gap-4 items-center">
                                <div class="w-12 h-16 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ $item->sanpham->HinhAnh }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[11px] font-bold text-stone-800 truncate">{{ $item->sanpham->TenSanPham }}</p>
                                    
                                    <input type="hidden" name="MaSanPham[]" value="{{ $item->MaSanPham }}">
                                    
                                    <p class="text-[10px] text-stone-400">Size: {{ $item->size->TenSize }}</p>
                                    <input type="hidden" name="MaSize[]" value="{{ $item->MaSize }}">
                                    
                                    <p class="text-[10px] text-stone-400">Quantity: {{ $item->SoLuong }}</p>
                                    <input type="hidden" name="SoLuong[]" value="{{ $item->SoLuong }}">
                                </div>
                                
                                <span class="text-xs font-bold text-stone-700">{{ number_format($item->sanpham->GiaBan * $item->SoLuong, 0, ',', '.') }}đ</span>
                                
                                <input type="hidden" name="DonGia[]" value="{{ $item->sanpham->GiaBan }}">
                                <input type="hidden" name="ThanhTien[]" value="{{ $item->sanpham->GiaBan * $item->SoLuong }}">
                            </div>
                            @endforeach
                        </div>

                        <div class="py-6 border-t border-stone-100">
                            <div class="flex items-center justify-between mb-4">
                                <label class="text-xs font-bold text-stone-700 uppercase tracking-wider">Khuyến mãi</label>
                                <button type="button" onclick="toggleVoucherModal()" class="text-[10px] text-red-800 font-bold hover:underline italic">Chọn mã giảm giá ></button>
                            </div>
                            
                            <div class="flex gap-2 mb-4">
                                <input type="text" id="coupon_input" placeholder="Nhập mã ưu đãi" 
                                    class="flex-1 bg-stone-50 border border-stone-200 rounded-lg px-3 py-2 text-xs focus:border-red-800 outline-none transition-all uppercase font-bold tracking-widest">
                                <button type="button" id="apply_coupon" class="bg-stone-800 text-white px-4 py-2 rounded-lg text-[10px] font-bold uppercase hover:bg-black transition-all">Áp dụng</button>
                            </div>

                            <div id="selected_voucher" class="hidden flex items-center justify-between bg-red-50 border border-red-200 rounded-lg p-3">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-ticket text-red-800 text-sm"></i>
                                    <span id="voucher_name" class="text-[11px] font-bold text-red-900"></span>
                                </div>
                                <button type="button" onclick="removeVoucher()" class="text-stone-400 hover:text-red-800 text-sm">&times;</button>
                            </div>
                        </div>

                        <div class="space-y-3 pt-4 border-t border-stone-100">
                            <div class="flex justify-between text-xs text-stone-500">
                                <span>Tạm tính</span>
                                <span>{{ number_format($totalPrice, 0, ',', '.') }}đ</span>
                                <input type="hidden" name="Tongtien" id="total_payment" value="{{ $totalPrice }}">
                            </div>
                            <div id="discount_row" class="hidden flex justify-between text-xs text-red-600 font-bold">
                                <span>Giảm giá</span>
                                <span>-<span id="discount_amount">0</span>đ</span>
                            </div>
                            <div class="flex justify-between items-center pt-4 mt-2 border-t border-stone-200">
                                <span class="text-sm font-bold text-stone-800 uppercase tracking-tighter">Tổng thanh toán</span>
                                <span id="final_total" class="text-xl font-bold text-red-800" data-base="{{ $totalPrice }}">{{ number_format($totalPrice, 0, ',', '.') }}đ</span>
                                
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-red-800 hover:bg-red-900 text-white rounded-xl py-4 mt-8 font-bold text-sm uppercase tracking-widest shadow-lg shadow-red-900/20 transition-all transform hover:-translate-y-1">
                            Xác nhận đặt hàng
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>

<div id="voucherModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white w-full max-w-md rounded-2xl overflow-hidden shadow-2xl animate-fade-up">
        <div class="p-6 border-b border-stone-100 flex justify-between items-center bg-stone-50">
            <h3 class="font-bold text-stone-800 uppercase text-sm tracking-widest">Kho Voucher</h3>
            <button onclick="toggleVoucherModal()" class="text-stone-400 hover:text-stone-800 text-2xl">&times;</button>
        </div>
        <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto custom-scrollbar">
            
            @foreach ($promotions as $p )
            <div class="flex border border-stone-200 rounded-xl overflow-hidden group hover:border-red-800 transition-all cursor-pointer" onclick="selectVoucher('GIAM50', 50000, 'Giảm 50k - Khai xuân rực rỡ')">
                <div class="w-24 bg-red-800 flex flex-col items-center justify-center text-white p-2">
                    <span class="text-xs uppercase font-bold tracking-tighter">Giảm</span>
                    @if ($p->LoaiGiam==1)
                    <span class="text-xl font-bold">{{ $p->GiaTriGiam }}%</span>
                    @else
                    <span class="text-xl font-bold">{{ number_format($p->GiaTriGiam,0,',','.') }}đ</span>
                    @endif

                    
                </div>
                <div class="p-4 flex-1">
                    <h4 class="text-xs font-bold text-stone-800 uppercase">{{ $p->TenKhuyenMai }}</h4>
                    <p class="text-[10px] text-stone-400 mt-1">Đơn tối thiểu {{ number_format($p->Dieukienkhuyenmai,0,',','.') }}đ</p>
                    <p class="text-[9px] text-red-800 font-bold mt-2 italic">HSD: {{ $p->NgayKetThuc }}</p>
                </div>
            </div>
            @endforeach
           

        </div>
    </div>
</div>

<script>
    function toggleVoucherModal() {
        document.getElementById('voucherModal').classList.toggle('hidden');
    }

    function selectVoucher(code, amount, description) {
        // Cập nhật giao diện
        document.getElementById('coupon_input').value = code;
        document.getElementById('selected_voucher').classList.remove('hidden');
        document.getElementById('voucher_name').innerText = description;
        
        // Tính toán lại tiền
        let basePrice = parseInt(document.getElementById('final_total').getAttribute('data-base'));
        let discountRow = document.getElementById('discount_row');
        let discountAmount = document.getElementById('discount_amount');
        let finalTotal = document.getElementById('final_total');

        discountRow.classList.remove('hidden');
        discountAmount.innerText = amount.toLocaleString('vi-VN');
        finalTotal.innerText = (basePrice - amount).toLocaleString('vi-VN') + 'đ';

        toggleVoucherModal(); // Đóng modal
    }

    function removeVoucher() {
        document.getElementById('coupon_input').value = '';
        document.getElementById('selected_voucher').classList.add('hidden');
        document.getElementById('discount_row').classList.add('hidden');
        
        let basePrice = parseInt(document.getElementById('final_total').getAttribute('data-base'));
        document.getElementById('final_total').innerText = basePrice.toLocaleString('vi-VN') + 'đ';
    }
</script>

<style>
    @keyframes fade-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up { animation: fade-up 0.4s ease-out forwards; }
    .custom-scrollbar::-webkit-scrollbar { width: 3px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e7e5e4; border-radius: 10px; }
</style>

@endsection