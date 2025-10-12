<?php

namespace App\Models\Amenties;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Room\Phong; // added

class TienNghi extends Model
{
    protected $table = 'TienNghi';
    protected $primaryKey = 'IDTienNghi';
    public $incrementing = false; // vì ID không còn tự tăng
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['IDTienNghi', 'TenTienNghi'];

    // Quan hệ nhiều-nhiều với Phong
    public function phongs()
    {
        return $this->belongsToMany(
            Phong::class,
            'TienNghiPhong',
            'IDTienNghi',
            'IDPhong'
        );
    }

    // Tự sinh mã TN00x khi tạo mới
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->IDTienNghi)) {
                $last = self::orderBy('IDTienNghi', 'desc')->first();
                if ($last && preg_match('/TN(\d+)/', $last->IDTienNghi, $m)) {
                    $next = (int)$m[1] + 1;
                } else {
                    $next = 1;
                }
                $model->IDTienNghi = 'TN' . str_pad($next, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    public function getRouteKeyName()
    {
        return $this->primaryKey;
    }
}
