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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('can_manage_services')->default(false)->after('can_view_proposals');
            $table->boolean('can_manage_achievements')->default(false)->after('can_manage_services');
            $table->boolean('can_view_documents')->default(false)->after('can_manage_achievements');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['can_manage_services', 'can_manage_achievements', 'can_view_documents']);
        });
    }
};
