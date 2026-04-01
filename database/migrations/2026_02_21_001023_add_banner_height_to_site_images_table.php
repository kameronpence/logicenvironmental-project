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
        Schema::table('site_images', function (Blueprint $table) {
            $table->integer('banner_height')->default(300)->after('image_position_y');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_images', function (Blueprint $table) {
            $table->dropColumn('banner_height');
        });
    }
};
