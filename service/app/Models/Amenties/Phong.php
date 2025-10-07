<?php

namespace App\Models\Amenties;

use Illuminate\Database\Eloquent\Model;

class Phong extends Model
{
    protected $table = 'Phong';
    protected $primaryKey = 'IDPhong';
    public $timestamps = false;

    protected $fillable = [
        'IDLoaiPhong', 'SoPhong', 'MoTa', 'UuTienChinh',
        'XepHangSao', 'TrangThai', 'UrlAnhPhong'
    ];

    public function loaiPhong()
    {
        return $this->belongsTo(LoaiPhong::class, 'IDLoaiPhong', 'IDLoaiPhong');
    }

    public function tienNghis()
    {
        return $this->belongsToMany(TienNghi::class, 'TienNghiPhong', 'IDPhong', 'IDTienNghi');
    }

    public function getRouteKeyName()
    {
        return $this->getKeyName(); // IDPhong
    }
}
