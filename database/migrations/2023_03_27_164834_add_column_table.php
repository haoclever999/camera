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
        Schema::table('thuong_hieus', function (Blueprint $table) {
            $table->string('logo', 191)->after('ten_thuong_hieu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thuong_hieus', function (Blueprint $table) {
            //
        });
    }
};
