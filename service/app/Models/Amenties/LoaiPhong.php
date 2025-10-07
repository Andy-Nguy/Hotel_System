<?php

namespace App\Models\Amenties;

use Illuminate\Database\Eloquent\Model;

class LoaiPhong extends Model
{
    protected $table = 'LoaiPhong';
    protected $primaryKey = 'IDLoaiPhong';
    public $timestamps = false;

    protected $fillable = [
        'TenLoaiPhong', 'MoTa', 'SoNguoiToiDa', 'GiaCoBanMotDem',
        'UrlAnhLoaiPhong', 'UuTienChinh'
    ];

    public function phongs()
    {
        return $this->hasMany(Phong::class, 'IDLoaiPhong', 'IDLoaiPhong');
    }

    public function getRouteKeyName()
    {
        return $this->getKeyName(); // IDLoaiPhong
    }
}
