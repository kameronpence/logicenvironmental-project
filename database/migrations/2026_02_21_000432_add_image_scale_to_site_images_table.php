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
            $table->integer('image_scale')->default(100)->after('overlay_opacity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_images', function (Blueprint $table) {
            $table->dropColumn('image_scale');
        });
    }
};
