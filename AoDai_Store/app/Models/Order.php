<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    use HasFactory;
    protected $table = 'hoadon';
    protected $primaryKey = 'MaHoaDon';
    const CREATED_AT = 'NgayTao';
    const UPDATED_AT = 'NgayCapNhat';
    protected $fillable = [
        'MaTaiKhoan',
        'NgayDatHang',
        'TenNguoiNhan',
        'SDTNguoiNhan',
        'TienHang',
        'PhiVanChuyen',
        'GiamGia',
        'MaKhuyenMai',
        'TongTien',
        'TrangThai',
        'DiaChiGiaoHang',
        'Ghichu',
        'PhuongThucThanhToan'
    ];
}
