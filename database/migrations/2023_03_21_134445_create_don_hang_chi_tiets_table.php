<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('don_hang_chi_tiets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('don_hang_id')->unsigned();
            $table->foreign('don_hang_id')->references('id')->on('don_hangs')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('sp_id')->unsigned();
            $table->foreign('sp_id')->references('id')->on('san_phams')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('so_luong_ban');
            $table->decimal('gia', 9, 0);
            $table->decimal('thanh_tien', 9, 0);
            $table->text('ghi_chu')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('don_hang_chi_tiets');
    }
};
