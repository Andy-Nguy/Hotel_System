<?php

namespace App\Models\Amenties;

use Illuminate\Database\Eloquent\Model;

class Phong extends Model
{
    protected $table = 'Phong';
    protected $primaryKey = 'IDPhong';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'IDPhong',
        'IDLoaiPhong',
        'TenPhong',
        'SoPhong',
        'MoTa',
        'XepHangSao',
        'TrangThai',
        'UrlAnhPhong',
        'SoNguoiToiDa',
        'GiaCoBanMotDem'
    ];

    public function loaiPhong()
    {
        return $this->belongsTo(LoaiPhong::class, 'IDLoaiPhong', 'IDLoaiPhong');
    }

    public function tienNghis()
    {
        return $this->belongsToMany(TienNghi::class, 'TienNghiPhong', 'IDPhong', 'IDTienNghi');
    }

    // Các đặt phòng liên quan tới phòng này
    public function datPhongs()
    {
        return $this->hasMany(\App\Models\Amenties\DatPhong::class, 'IDPhong', 'IDPhong');
    }

    public function getRouteKeyName()
    {
        return 'IDPhong';
    }
}
