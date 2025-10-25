<?php

namespace App\Models\Amenties;

use Illuminate\Database\Eloquent\Model;

class DatPhong extends Model
{
    protected $table = 'DatPhong';
    protected $primaryKey = 'IDDatPhong';
    public $incrementing = false; // IDs are provided as string
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'IDDatPhong',
        'IDKhachHang',
        'IDPhong',
        'NgayDatPhong',
        'NgayNhanPhong',
        'NgayTraPhong',
        'SoDem',
        'GiaPhong',
        'TongTien',
        'TienCoc',
        'TienConLai',
        'TrangThai',
        'TrangThaiThanhToan',
    ];

    protected $casts = [
        'NgayDatPhong' => 'date',
        'NgayNhanPhong' => 'date',
        'NgayTraPhong' => 'date',
        'SoDem' => 'integer',
        'GiaPhong' => 'decimal:2',
        'TongTien' => 'decimal:2',
        'TienCoc' => 'decimal:2',
        'TienConLai' => 'decimal:2',
        'TrangThai' => 'integer',
        'TrangThaiThanhToan' => 'integer',
    ];

    // Relation to customer
    public function khachHang()
    {
        return $this->belongsTo(\App\Models\Login\KhachHang::class, 'IDKhachHang', 'IDKhachHang');
    }

    // Relation to room
    public function phong()
    {
        return $this->belongsTo(\App\Models\Amenties\Phong::class, 'IDPhong', 'IDPhong');
    }
    
    // Relation to invoice (HoaDon) - one booking may have one invoice
    public function hoaDon()
    {
        return $this->hasOne(\App\Models\Amenties\HoaDon::class, 'IDDatPhong', 'IDDatPhong');
    }

    public function getRouteKeyName()
    {
        return 'IDDatPhong';
    }
}
