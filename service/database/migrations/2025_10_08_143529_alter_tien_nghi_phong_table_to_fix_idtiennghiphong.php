<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTienNghiPhongTableToMakeIdAutoIncrement extends Migration
{
    public function up()
    {
        Schema::table('TienNghiPhong', function (Blueprint $table) {
            // Drop existing primary key constraint
            $table->dropPrimary('IDTienNghiPhong');

            // Modify IDTienNghiPhong to be auto-incrementing
            $table->bigIncrements('IDTienNghiPhong')->first();

            // Re-add foreign keys and indexes if needed
            $table->string('IDPhong');
            $table->string('IDTienNghi');
            $table->foreign('IDPhong')->references('IDPhong')->on('Phong')->onDelete('cascade');
            $table->foreign('IDTienNghi')->references('IDTienNghi')->on('TienNghi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('TienNghiPhong', function (Blueprint $table) {
            // Revert to original schema
            $table->dropForeign(['IDPhong']);
            $table->dropForeign(['IDTienNghi']);
            $table->dropColumn('IDPhong');
            $table->dropColumn('IDTienNghi');
            $table->dropColumn('IDTienNghiPhong');
            $table->string('IDTienNghiPhong')->primary();
            $table->string('IDPhong');
            $table->string('IDTienNghi');
        });
    }
}
