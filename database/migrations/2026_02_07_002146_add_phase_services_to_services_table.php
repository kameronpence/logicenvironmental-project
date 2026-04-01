<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Shift existing services sort_order by 2 to make room for Phase I and Phase II
        DB::table('services')->increment('sort_order', 2);

        // Add Phase I Investigations
        DB::table('services')->insert([
            'title' => 'Phase I Investigations',
            'icon' => 'fa-search',
            'short_description' => 'Environmental Site Assessments for property evaluation, helping insulate buyers and lenders from liability through due diligence.',
            'full_description' => "Phase I Environmental Site Assessments have become the most widely recognized transactional tool for the environmental evaluation of commercial property. Phase I investigations help insulate property buyers and lenders from liability under certain environmental laws by demonstrating the exercise of due care in evaluating the property for environmental impacts. Also, these Assessments help parties accurately determine the environmental condition of the property with regard to its value and suitability for its intended use.\n\nLOGIC's Phase I Assessments are based upon a careful site inspection, in-depth historical research, interviews, government records review, interviews, and other sources. LOGIC's Assessments exceed the standards prescribed the American Society of Testing Materials (ASTM) and the US Environmental Protection Agency's All Appropriate Inquiry (AAI) standards, established in November 2006. Also, we have completed many projects requiring strict adherence to other client-specific or lender-specific standards. In each case, LOGIC provided a final product which exceeded our client's expectations.\n\nWe recognize that each project presents unique issues, based upon the nature of the property's current and historical use, location, geology and other factors. We rely upon our broad range of experience with similar properties to add depth and insight to our work. In fact, we have performed hundreds of Phase I Assessments at virtually every type of commercial, residential and industrial site, including manufacturing facilities, convenience stores, hotels, restaurants, shopping centers, dry cleaners, agricultural land, landfills and waste handlers, state parks, apartments, warehouses, food and beverage processors, mines, places of worship, assisted living and child care facilities, junkyards, transportation and logistics centers, communications and broadcast sites, historical landmarks and many, many other types of property. In each case, our study is exhaustive and entails a wide array of information sources which take the unique character and history of the property into consideration.\n\nLOGIC also offers the capability to expand our Assessments to meet our client's particular requirements, including, where appropriate, sampling for asbestos, lead paint, radon, mold and lead in drinking water. LOGIC believes that even the most exhaustive investigation is successful only to the extent that it facilitates our clients' effective decision-making. For this reason, we present all of our Assessment findings in clear, non-technical language and provide our clients with decisive answers.",
            'sort_order' => 1,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add Phase II Investigations
        DB::table('services')->insert([
            'title' => 'Phase II Investigations',
            'icon' => 'fa-vial',
            'short_description' => 'Detailed subsurface investigations including soil and groundwater sampling to confirm presence or absence of contamination.',
            'full_description' => "LOGIC provides Phase II Environmental Site Assessments, which involve detailed subsurface investigations to confirm the presence or absence of contamination identified or suspected during Phase I Environmental Site Assessments. Our Phase II services include soil and groundwater sampling, laboratory analysis, contamination delineation, and risk characterization.",
            'sort_order' => 2,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove Phase I and Phase II services
        DB::table('services')->where('title', 'Phase I Investigations')->delete();
        DB::table('services')->where('title', 'Phase II Investigations')->delete();

        // Shift sort_order back
        DB::table('services')->decrement('sort_order', 2);
    }
};
