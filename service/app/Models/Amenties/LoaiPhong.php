<?php

namespace App\Models\Amenties;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiPhong extends Model
{
    use HasFactory;

    protected $table = 'loaiphong';
    protected $primaryKey = 'IDLoaiPhong';
    public $incrementing = false; // vì ID là CHAR, không phải AUTO_INCREMENT
    protected $keyType = 'string';

    protected $fillable = [
        'IDLoaiPhong',
        'TenLoaiPhong',
        'MoTa',
        'UrlAnhLoaiPhong',
        'UuTienChinh'
    ];
}
