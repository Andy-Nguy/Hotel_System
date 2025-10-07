<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class TaiKhoanNguoiDung extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    protected $table = 'taikhoannguoidung';
    protected $primaryKey = 'IDNguoiDung';
    public $timestamps = false; // Nếu bảng không có created_at, updated_at

    protected $fillable = [
        'IDKhachHang',
        'Email',
        'MatKhau',
        'VaiTro',
        'EmailVerifiedAt'
    ];

    protected $hidden = [
        'MatKhau',
        'RememberToken',
    ];

    protected $casts = [
        'EmailVerifiedAt' => 'datetime',
    ];

    // Laravel yêu cầu tên cột mật khẩu là 'password'
    public function getAuthPassword()
    {
        return $this->MatKhau;
    }
}
