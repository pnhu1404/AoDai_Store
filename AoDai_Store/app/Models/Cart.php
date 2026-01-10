<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    use HasFactory;
    protected $table = 'giohang';
    public $timestamps = false;
    protected $primaryKey = 'ID';
    protected $fillable = [
        'id',
        'MaSanPham',
        'MaTaiKhoan',
        'MaSize',
        'SessionID',
        'SoLuong'
    ];
    public function sanpham()
    {
        // Đảm bảo 'MaSanPham' (hoặc id) là tên cột thực tế trong DB của bạn
        return $this->belongsTo(Product::class, 'MaSanPham', 'MaSanPham'); 
    }
}
