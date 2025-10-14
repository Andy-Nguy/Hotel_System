<?php

namespace App\Models\Services;

use Illuminate\Database\Eloquent\Model;

class DichVu extends Model
{
    protected $table = 'DichVu';
    protected $primaryKey = 'IDDichVu';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'IDDichVu',
        'TenDichVu', // Đã được cập nhật thành VARCHAR trong CSDL
        'TienDichVu',
        'HinhDichVu',
    ];

    /**
     * Định nghĩa mối quan hệ 1-n: Một DichVu có nhiều TTDichVu (Thông tin chi tiết)
     */
    public function chiTiet()
    {
        return $this->hasMany(TTDichVu::class, 'IDDichVu', 'IDDichVu');
    }

    /**
     * Định nghĩa mối quan hệ 1-n: Một DichVu có nhiều CTHDDV (Log sử dụng)
     */
    public function logsSuDung()
    {
        return $this->hasMany(CTHDDV::class, 'IDDichVu', 'IDDichVu');
    }
}
