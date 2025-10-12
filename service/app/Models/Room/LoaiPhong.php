<?php

namespace App\Models\Room;

use Illuminate\Database\Eloquent\Model;

class LoaiPhong extends Model
{
    protected $table = 'LoaiPhong';
    protected $primaryKey = 'IDLoaiPhong';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'IDLoaiPhong', 'TenLoaiPhong', 'MoTa', 'SoNguoiToiDa', 'GiaCoBanMotDem', 'UrlAnhLoaiPhong', 'UuTienChinh'
    ];
}
