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
            $table->integer('image_position_x')->default(50)->after('image_scale');
            $table->integer('image_position_y')->default(50)->after('image_position_x');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_images', function (Blueprint $table) {
            $table->dropColumn(['image_position_x', 'image_position_y']);
        });
    }
};
