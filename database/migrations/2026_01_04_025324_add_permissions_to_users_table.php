<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('admin')->after('is_admin'); // super_admin, admin
            $table->boolean('can_manage_pages')->default(false)->after('role');
            $table->boolean('can_manage_team')->default(false)->after('can_manage_pages');
            $table->boolean('can_manage_users')->default(false)->after('can_manage_team');
            $table->boolean('can_view_activity')->default(false)->after('can_manage_users');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'can_manage_pages', 'can_manage_team', 'can_manage_users', 'can_view_activity']);
        });
    }
};
