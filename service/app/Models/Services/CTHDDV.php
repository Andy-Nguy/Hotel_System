<?php

namespace App\Models\Services;

use Illuminate\Database\Eloquent\Model;

class CTHDDV extends Model
{
    protected $table = 'CTHDDV';
    protected $primaryKey = 'IDCTHDDV';
    public $timestamps = false; // Bảng này không dùng created_at/updated_at

    protected $fillable = [
        // IDHoaDon sẽ là NULL khi log sử dụng và được cập nhật khi checkout
        'IDHoaDon',
        'IDDichVu',
        'Tiendichvu',
        'ThoiGianThucHien',
    ];

    protected $casts = [
        'IDCTHDDV' => 'integer',
        'ThoiGianThucHien' => 'datetime', // Giữ kiểu datetime/date theo DB
    ];

    /**
     * Định nghĩa mối quan hệ n-1: CTHDDV thuộc về một DichVu
     */
    public function dichVu()
    {
        return $this->belongsTo(DichVu::class, 'IDDichVu', 'IDDichVu');
    }

    // NOTE: Cần có thêm mối quan hệ với HoaDon nếu đã có model HoaDon
    // public function hoaDon() { return $this->belongsTo(HoaDon::class, 'IDHoaDon', 'IDHoaDon'); }
}
