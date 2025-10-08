<?php

namespace App\Models\Amenties;

use Illuminate\Database\Eloquent\Model;

class Phong extends Model
{
    protected $table = 'Phong';
    protected $primaryKey = 'IDPhong';
    public $incrementing = false; // ⚠️ vì ID là CHAR, không tự tăng
    protected $keyType = 'string'; // ⚠️ ID dạng P001, không phải số
    public $timestamps = false;

    protected $fillable = [
        'IDPhong',
        'IDLoaiPhong',
        'SoPhong',
        'MoTa',
        'UuTienChinh',
        'XepHangSao',
        'TrangThai',
        'UrlAnhPhong'
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
        return 'IDPhong';
    }
}
