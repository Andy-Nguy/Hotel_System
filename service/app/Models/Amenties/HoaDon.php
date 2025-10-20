<?php

namespace App\Models\Amenties;

use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    protected $table = 'HoaDon';
    protected $primaryKey = 'IDHoaDon';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'IDHoaDon',
        'IDDatPhong',
        'NgayLap',
        'TongTien',
        'TienCoc',
        'TienThanhToan',
        'TrangThaiThanhToan',
        'GhiChu',
    ];

    protected $casts = [
        'NgayLap' => 'datetime',
        'TongTien' => 'decimal:2',
        'TienCoc' => 'decimal:2',
        'TienThanhToan' => 'decimal:2',
        'TrangThaiThanhToan' => 'integer',
    ];

    // Relation: invoice belongs to a booking
    public function datPhong()
    {
        return $this->belongsTo(DatPhong::class, 'IDDatPhong', 'IDDatPhong');
    }

    // Relation: invoice has many CTHDDV (services used)
    public function cthddvs()
    {
        return $this->hasMany(CTHDDV::class, 'IDHoaDon', 'IDHoaDon');
    }
}
