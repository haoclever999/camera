<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quan_huyens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten_qh');
            $table->string('type');
            $table->integer('id_tp')->unsigned();
            $table->foreign('id_tp')->references('id')->on('tinh_thanh_phos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quan_huyens');
    }
};