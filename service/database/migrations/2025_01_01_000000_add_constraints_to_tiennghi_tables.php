<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('TienNghi', function (Blueprint $table) {
            // Unique tên tiện nghi
            $table->unique('TenTienNghi', 'uq_tiennghi_ten');
        });

        Schema::table('TienNghiPhong', function (Blueprint $table) {
            // Unique mỗi cặp phòng - tiện nghi
            $table->unique(['IDPhong', 'IDTienNghi'], 'uq_tnp_phong_tiennghi');
        });
    }

    public function down(): void
    {
        Schema::table('TienNghi', function (Blueprint $table) {
            $table->dropUnique('uq_tiennghi_ten');
        });

        Schema::table('TienNghiPhong', function (Blueprint $table) {
            $table->dropUnique('uq_tnp_phong_tiennghi');
        });
    }
};
