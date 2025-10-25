<?php

namespace App\Models\Amenties;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TTDichVu extends Model
{
    use HasFactory;

    protected $table = 'TTDichVu';
    protected $primaryKey = 'IDTTDichVu';
    public $incrementing = false;
    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = [
        'IDTTDichVu',
        'IDDichVu',
        'ThongTinDV',
    ];

    // Relation: belongsTo DichVu
    public function dichVu()
    {
        return $this->belongsTo(DichVu::class, 'IDDichVu', 'IDDichVu');
    }
}
