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
        Schema::create('xa_phuongs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten_xa');
            $table->string('type');
            $table->integer('id_qh')->unsigned();
            $table->foreign('id_qh')->references('id')->on('quan_huyens');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xa_phuongs');
    }
};