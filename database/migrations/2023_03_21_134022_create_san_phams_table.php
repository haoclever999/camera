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
            $table->integer('da_ban')->default(0);
            $table->integer('ton');
            $table->decimal('gia_nhap', 9, 0);
            $table->decimal('gia_ban', 9, 0);

            $table->integer('bao_hanh');
            $table->integer('goc_camera');
            $table->string('chuan_nen', 191);
            $table->string('do_phan_giai', 191);
            $table->string('dam_thoai', 191);
            $table->string('tam_quan_sat', 191);
            $table->text('tinh_nang');
            $table->string('nguon_dien', 191);

            $table->integer('luot_xem')->default(0);
            $table->integer('luot_mua')->default(0);

            $table->integer('km_id')->unsigned()->default(0);
            $table->foreign('km_id')->references('id')->on('khuyen_mais')->onUpdate('cascade');
            $table->integer('dm_id')->unsigned();
            $table->foreign('dm_id')->references('id')->on('danh_mucs')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('thuong_hieu_id')->unsigned();
            $table->foreign('thuong_hieu_id')->references('id')->on('thuong_hieus')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
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
