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
        // Client portals - each client/project gets a portal
        Schema::create('client_portals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('project_reference')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_accessed_at')->nullable();
            $table->timestamps();

            $table->index('email');
        });

        // Files associated with client portals
        Schema::create('client_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_portal_id')->constrained()->onDelete('cascade');
            $table->string('filename');
            $table->string('original_filename');
            $table->string('file_path');
            $table->string('disk')->default('s3');
            $table->bigInteger('file_size')->default(0);
            $table->string('mime_type')->nullable();
            $table->enum('type', ['for_client', 'from_client']); // for_client = admin uploaded for client to download, from_client = client uploaded
            $table->text('description')->nullable();
            $table->timestamp('downloaded_at')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index('type');
        });

        // Magic links for passwordless access
        Schema::create('magic_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_portal_id')->constrained()->onDelete('cascade');
            $table->string('token', 64)->unique();
            $table->string('email');
            $table->timestamp('expires_at');
            $table->timestamp('used_at')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();

            $table->index('token');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magic_links');
        Schema::dropIfExists('client_files');
        Schema::dropIfExists('client_portals');
    }
};
