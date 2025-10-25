<?php

namespace App\Models\Amenties;

use Illuminate\Database\Eloquent\Model;

class TienNghiPhong extends Model
{
    protected $table = 'TienNghiPhong';
    protected $primaryKey = 'IDTienNghiPhong';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['IDTienNghiPhong', 'IDPhong', 'IDTienNghi'];
}
