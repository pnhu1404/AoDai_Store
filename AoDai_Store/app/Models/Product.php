<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    use HasFactory;
    protected $table = 'sanpham';
    protected $primaryKey = 'MaSanPham';
    public $timestamps = false;
    public function chatlieu()
    {
        return $this->belongsTo(Material::class, 'MaChatLieu', 'MaChatLieu');
    }

    public function loaimau()
    {
        return $this->belongsTo(Color::class, 'MaLoaiMau', 'MaLoaiMau');
    }
    public function loaisanpham()
    {
        return $this->belongsTo(Category::class, 'MaLoaiSP', 'MaLoaiSP');
    }
    public function hinhanhsanpham()
    {
        return $this->hasMany(ProductImage::class, 'MaSanPham', 'MaSanPham');
    }

    public function sizes()
    {

        return $this->belongsToMany(Size::class, 'sanpham_size', 'MaSanPham', 'MaSize')
            ->withPivot('SoLuong');
    }
    public function nhacungcap()
    {
        return $this->belongsTo(Supplier::class, 'MaNCC', 'MaNCC');
    }

    protected $fillable = [
        'TenSanPham',
        'GiaBan',
        'MaLoaiSP',
        'MaChatLieu',
        'MaNCC',
        'MaLoaiMau',
        'MaSize',
        'SoLuong',
        'HinhAnh',
        'TrangThai',
        'CreatedDate',
        'MoTa',
    ];
}
