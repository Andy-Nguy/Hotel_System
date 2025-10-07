<?php

namespace App\Models\Amenties;

use Illuminate\Database\Eloquent\Model;

class TienNghi extends Model
{
    protected $table = 'TienNghi';
    protected $primaryKey = 'IDTienNghi';
    public $timestamps = false;

    protected $fillable = ['TenTienNghi'];

    public function phongs()
    {
        return $this->belongsToMany(Phong::class, 'TienNghiPhong', 'IDTienNghi', 'IDPhong');
    }

    public function getRouteKeyName()
    {
        return $this->getKeyName(); // IDTienNghi
    }
}
