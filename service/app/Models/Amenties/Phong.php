<?php

namespace App\Models\Amenties;

use app\Models\Amenties\TienNghi;
use Illuminate\Database\Eloquent\Model;

class Phong extends Model
{
    protected $table = 'Phong';
    protected $primaryKey = 'IDPhong';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    // Thêm các fillable nếu cần
    protected $fillable = [
        'IDPhong', 'SoPhong', 'IDLoaiPhong', 'XepHangSao', 'TrangThai', 'MoTa', 'UrlAnhPhong'
    ];

    // Quan hệ với LoaiPhong
    public function loaiPhong()
    {
        return $this->belongsTo(LoaiPhong::class, 'IDLoaiPhong', 'IDLoaiPhong');
    }

    // Nếu có quan hệ với tienNghis
     public function tienNghis()
     {
        return $this->belongsToMany(TienNghi::class, 'Phong_TienNghi', 'IDPhong', 'IDTienNghi');
    }
}
