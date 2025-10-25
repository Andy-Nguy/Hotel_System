<?php

namespace App\Models\Amenties;

use Illuminate\Database\Eloquent\Model;

class CTHDDV extends Model
{
    protected $table = 'CTHDDV';
    protected $primaryKey = 'IDCTHDDV';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'IDCTHDDV',
        'IDHoaDon',
        'IDDichVu',
        'TienDichVu',
        'ThoiGianThucHien',
    ];

    protected $casts = [
        'TienDichVu' => 'decimal:2',
        'ThoiGianThucHien' => 'datetime',
    ];

    // Relation: CTHDDV belongs to HoaDon
    public function hoaDon()
    {
        return $this->belongsTo(HoaDon::class, 'IDHoaDon', 'IDHoaDon');
    }

    // Relation: CTHDDV belongs to a DichVu
    public function dichVu()
    {
        return $this->belongsTo(DichVu::class, 'IDDichVu', 'IDDichVu');
    }
}
