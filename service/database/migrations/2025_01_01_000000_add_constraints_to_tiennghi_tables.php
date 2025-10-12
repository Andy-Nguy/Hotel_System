<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

        // Loại bỏ hoàn toàn các lệnh ALTER liên quan đến INT/AUTO_INCREMENT cho IDTienNghiPhong
        // Vì cột này là CHAR và sinh giá trị bằng trigger, KHÔNG phải INT/AUTO_INCREMENT
        // Chỉ giữ unique constraint
    }

    public function down(): void
    {
        Schema::table('TienNghi', function (Blueprint $table) {
            $table->dropUnique('uq_tiennghi_ten');
        });

        Schema::table('TienNghiPhong', function (Blueprint $table) {
            $table->dropUnique('uq_tnp_phong_tiennghi');
        });
        // Nếu muốn revert, có thể bỏ auto increment (tuỳ ý)
        // DB::statement('ALTER TABLE TienNghiPhong MODIFY COLUMN IDTienNghiPhong INT');
    }
};
