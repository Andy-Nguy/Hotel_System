<?php

namespace App\Models\Services;

use Illuminate\Database\Eloquent\Model;

class TTDichVu extends Model
{
    protected $table = 'TTDichVu';
    protected $primaryKey = 'IDTTDichVu';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'IDTTDichVu',
        'IDDichVu',
        'ThongTinDV',
    ];

    /**
     * Định nghĩa mối quan hệ n-1: TTDichVu thuộc về một DichVu
     */
    public function dichVu()
    {
        return $this->belongsTo(DichVu::class, 'IDDichVu', 'IDDichVu');
    }
}
