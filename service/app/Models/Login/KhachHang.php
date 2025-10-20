<?php

namespace App\Models\Login;

use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    protected $table = 'KhachHang';
    protected $primaryKey = 'IDKhachHang';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'HoTen',
        'NgaySinh',
        'SoDienThoai',
        'Email',
        'NgayDangKy',
        'TichDiem',
    ];
}
