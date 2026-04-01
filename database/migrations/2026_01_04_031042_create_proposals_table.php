<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('service');
            $table->string('project_type')->nullable();
            $table->text('property_address')->nullable();
            $table->string('timeline')->nullable();
            $table->string('budget')->nullable();
            $table->text('message');
            $table->string('status')->default('new'); // new, reviewed, contacted, completed
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Also add can_view_proposals to users table
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('can_view_proposals')->default(false)->after('can_view_activity');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposals');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('can_view_proposals');
        });
    }
};
