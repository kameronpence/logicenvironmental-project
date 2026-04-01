<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->boolean('show_in_menu')->default(false)->after('is_published');
            $table->string('menu_location')->default('about')->after('show_in_menu'); // main, about, footer
            $table->string('menu_title')->nullable()->after('menu_location'); // Custom menu title (uses page title if empty)
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['show_in_menu', 'menu_location', 'menu_title']);
        });
    }
};
