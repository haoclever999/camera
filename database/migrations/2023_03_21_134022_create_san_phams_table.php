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
        Schema::create('san_phams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten_sp', 191);
            $table->string('slug', 191);
            $table->string('hinh_anh_chinh', 191);
            $table->text('mo_ta');
            $table->integer('so_luong');
            $table->decimal('gia_nhap', 9, 0);
            $table->decimal('gia_ban', 9, 0);
            $table->integer('giam_gia')->default(0);

            $table->integer('bao_hanh');
            $table->text('tinh_nang');

            $table->integer('luot_xem')->default(0);
            $table->integer('luot_mua')->default(0);

            $table->integer('dm_id')->unsigned();
            $table->foreign('dm_id')->references('id')->on('danh_mucs')->onDelete('cascade');
            $table->integer('thuong_hieu_id')->unsigned();
            $table->foreign('thuong_hieu_id')->references('id')->on('thuong_hieus')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_phams');
    }
};
