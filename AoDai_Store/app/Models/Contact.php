<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'lienhe'; 
    protected $primaryKey = 'MaLienHe';

    protected $fillable = [
        'MaKH',
        'HoTen',
        'Email',
        'NoiDung',
    ];

    public $timestamps = false;
}
