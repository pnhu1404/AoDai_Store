<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    public function store(Request $request)
    {
        // Xử lý đặt hàng ở đây
        $address =$request->input('so_nha').', '.
                  $request->input('phuong_xa').', '.
                  $request->input('quan_huyen').', '.
                  $request->input('tinh_thanh');
        // $request->validate([
        //     'TenNguoiNhan' => 'required|string|max:255',
        //     'SDTNguoiNhan' => 'required|string|max:15',
        //     'PhuongThucThanhToan' => 'required|string|max:100',
        //     'GhiChu' => 'nullable|string|max:1000',
        //     'MaTaiKhoan' => 'required|integer',
        //     'TongTien' => 'required|numeric',
        //     'PhiVanChuyen' => 'required|numeric',
        //     'GiamGia' => 'nullable|numeric',
        //     'MaKhuyenMai' => 'nullable|integer',
        // ]);
        // Lưu thông tin đơn hàng vào cơ sở dữ liệu (chưa triển khai)
        Order::create([
            'TenNguoiNhan' => $request->input('TenNguoiNhan'),
            'SDTNguoiNhan' => $request->input('SDTNguoiNhan'),
            'DiaChiGiaoHang' => $address,
            'PhuongThucThanhToan' => $request->input('PhuongThucThanhToan'),
            'GhiChu' => $request->input('GhiChu'),
            'MaTaiKhoan' => 1,
            'TienHang' => $request->input('TienHang')+10000,
            'TongTien' => $request->input('TongTien'),
            'PhiVanChuyen' => 10000,
            'GiamGia' =>10000,
            'MaKhuyenMai' =>10
        ]);
        $orderId = Order::latest()->first()->MaHoaDon;
    // 2. Lấy các mảng dữ liệu từ Form - Thêm giá trị mặc định là mảng rỗng để tránh lỗi null
        $maSanPhams = $request->input('MaSanPham', []); 
        $soLuongs   = $request->input('SoLuong', []);   
        $donGias    = $request->input('DonGia', []);    
        $thanhTiens = $request->input('ThanhTien', []); 
        $maSizes   = $request->input('MaSize', []);

// 3. Duyệt vòng lặp
  
    if (is_array($maSanPhams)) {
        foreach ($maSanPhams as $key => $maSP) {
            DB::table('chitiethoadon')->insert([
            'MaHoaDon'  => $orderId,
            'MaSanPham' => (int)$maSP,
            'SoLuong'   => (int)$soLuongs[$key],
            'DonGia'    => (float)$donGias[$key],
            'MaSize'    => $maSizes[$key],
            'ThanhTien'=> (float)$thanhTiens[$key],
        ]);
        }
    }
    $cartController = new CartController();
    $cartController->clearCart();
        return redirect()->route('home')->with('success', 'Đặt hàng thành công!');
    }
}
