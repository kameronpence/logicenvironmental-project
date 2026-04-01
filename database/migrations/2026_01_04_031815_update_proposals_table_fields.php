<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop old columns and add new ones to proposals table
        Schema::table('proposals', function (Blueprint $table) {
            // Drop old columns that don't match the form
            $table->dropColumn(['phone', 'service', 'project_type', 'timeline', 'budget', 'message']);
        });

        Schema::table('proposals', function (Blueprint $table) {
            // Add new columns to match the form
            $table->string('branch')->nullable()->after('company');
            $table->string('street_address')->after('branch');
            $table->string('city')->after('street_address');
            $table->string('state')->after('city');
            $table->string('zip_code')->after('state');
            $table->string('county')->after('property_address');
            $table->string('property_size')->after('county');
            $table->string('owner_name')->nullable()->after('property_size');
            $table->string('owner_phone')->nullable()->after('owner_name');
            $table->string('owner_email')->nullable()->after('owner_phone');
            $table->string('investigation_type')->after('owner_email');
            $table->string('report_deadline')->after('investigation_type');
            $table->string('verbal_deadline')->after('report_deadline');
            $table->integer('copies_needed')->default(1)->after('verbal_deadline');
            $table->text('report_addressees')->after('copies_needed');
            $table->integer('num_structures')->default(0)->after('report_addressees');
            $table->string('structure_age')->after('num_structures');
            $table->string('survey_available')->after('structure_age');
            $table->string('prior_reports')->after('survey_available');
            $table->string('access_problems')->after('prior_reports');
            $table->json('attachments')->nullable()->after('access_problems');
        });

        // Update existing pages to show in menu
        DB::table('pages')
            ->where('slug', 'company-history')
            ->update([
                'show_in_menu' => true,
                'menu_location' => 'about',
                'sort_order' => 2,
            ]);

        DB::table('pages')
            ->where('slug', 'locations')
            ->update([
                'show_in_menu' => true,
                'menu_location' => 'about',
                'sort_order' => 3,
            ]);
    }

    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn([
                'branch', 'street_address', 'city', 'state', 'zip_code',
                'county', 'property_size', 'owner_name', 'owner_phone', 'owner_email',
                'investigation_type', 'report_deadline', 'verbal_deadline', 'copies_needed',
                'report_addressees', 'num_structures', 'structure_age', 'survey_available',
                'prior_reports', 'access_problems', 'attachments'
            ]);
        });

        Schema::table('proposals', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('service')->after('phone');
            $table->string('project_type')->nullable()->after('service');
            $table->string('timeline')->nullable()->after('property_address');
            $table->string('budget')->nullable()->after('timeline');
            $table->text('message')->after('budget');
        });

        // Revert page menu settings
        DB::table('pages')
            ->whereIn('slug', ['company-history', 'locations'])
            ->update([
                'show_in_menu' => false,
                'menu_location' => null,
            ]);
    }
};
