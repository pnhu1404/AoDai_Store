<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //
    protected $table = 'chitiethoadon';
      public $incrementing = false;   
    public $timestamps = false;

  
    protected $primaryKey = null;
    protected $fillable = [
        'MaHoaDon',
        'MaSanPham',
        'SoLuong',
        'DonGia',
        'ThanhTien'
    ];

}
