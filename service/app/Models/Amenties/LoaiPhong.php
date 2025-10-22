<?php

namespace App\Models\Amenties;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiPhong extends Model
{
    use HasFactory;

    // Database table name uses capitalized 'LoaiPhong' in the schema
    protected $table = 'LoaiPhong';
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

    // Schema doesn't include timestamp columns
    public $timestamps = false;
}
