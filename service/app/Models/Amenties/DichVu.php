<?php

namespace App\Models\Amenties;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DichVu extends Model
{
    use HasFactory;

    protected $table = 'DichVu';
    protected $primaryKey = 'IDDichVu';
    public $incrementing = false;
    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = [
        'IDDichVu',
        'TenDichVu',
        'TienDichVu',
        'HinhDichVu',
    ];

    protected $casts = [
        'TienDichVu' => 'decimal:2',
    ];

    // Relation: one DichVu hasMany TTDichVu
    public function thongTin()
    {
        return $this->hasMany(TTDichVu::class, 'IDDichVu', 'IDDichVu');
    }

    // Backwards-compatible alias used by some controllers: chiTiet()
    public function chiTiet()
    {
        return $this->thongTin();
    }
}
