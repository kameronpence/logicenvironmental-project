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
        Schema::table('client_files', function (Blueprint $table) {
            $table->foreignId('notified_team_member_id')->nullable()->after('description')->constrained('team_members')->nullOnDelete();
            $table->timestamp('notified_at')->nullable()->after('notified_team_member_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_files', function (Blueprint $table) {
            $table->dropForeign(['notified_team_member_id']);
            $table->dropColumn(['notified_team_member_id', 'notified_at']);
        });
    }
};
