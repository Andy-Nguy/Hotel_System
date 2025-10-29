<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('HoaDon', function (Blueprint $table) {
            $table->tinyInteger('trang_thai_thanh_toan_moi')
                  ->default(0)
                  ->after('TrangThaiThanhToan')
                  ->comment('1: Chưa thanh toán, 2: Đã thanh toán nhưng chưa hoàn tất, 3: Đã thanh toán và hoàn tất');
        });
    }

    public function down(): void
    {
        Schema::table('HoaDon', function (Blueprint $table) {
            $table->dropColumn('trang_thai_thanh_toan_moi');
        });
    }
};