<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        Page::create([
            'title' => 'About Us',
            'slug' => 'about',
            'content' => '<h2>Welcome to Logic Environmental</h2>
<p>Logic Environmental is a leading environmental consulting firm dedicated to providing innovative and sustainable solutions for businesses and communities. With years of experience in environmental science and consulting, our team of experts helps clients navigate complex environmental challenges while ensuring compliance with regulations and promoting sustainability.</p>

<h3>Our Mission</h3>
<p>To deliver exceptional environmental consulting services that protect natural resources, ensure regulatory compliance, and create sustainable solutions for future generations.</p>

<h3>Our Values</h3>
<ul>
    <li><strong>Integrity:</strong> We uphold the highest ethical standards in all our work</li>
    <li><strong>Excellence:</strong> We strive for excellence in every project we undertake</li>
    <li><strong>Innovation:</strong> We embrace innovative solutions to environmental challenges</li>
    <li><strong>Sustainability:</strong> We are committed to sustainable practices and outcomes</li>
</ul>

<p>Our team of dedicated professionals brings together expertise in environmental science, engineering, regulatory compliance, and project management to deliver comprehensive solutions tailored to each client\'s unique needs.</p>',
            'meta_title' => 'About Us - Logic Environmental',
            'meta_description' => 'Learn about Logic Environmental, a leading environmental consulting firm dedicated to sustainable solutions.',
            'is_published' => true,
            'sort_order' => 1,
        ]);

        Page::create([
            'title' => 'Home',
            'slug' => 'home',
            'content' => '<p class="lead text-center">We provide comprehensive environmental consulting services to help organizations achieve their sustainability goals while maintaining regulatory compliance.</p>',
            'is_published' => true,
            'sort_order' => 0,
        ]);

        Page::create([
            'title' => 'Company History',
            'slug' => 'company-history',
            'content' => '<p>On behalf of everyone at LOGIC Environmental, Inc., thank you for your interest in our company. LOGIC was founded in 1997 with the mission of serving our clients\' environmental compliance and assessment needs with innovative thinking, personal attention, and common sense. Through the loyal support of our clients and the dedication of our professionals, LOGIC has grown consistently since our inception and has established a reputation as a leader in the environmental arena.</p>

<p>At LOGIC, we pledge to deliver the highest caliber of environmental expertise along with the practical, responsive, and cost-effective service that your business requires. We pride ourselves on producing not only technically complete assessment reports prepared in accordance with the most demanding industry standards, but on addressing the potential liabilities and practical consequences of environmental issues as they relate specifically to your interest as a property owner, prospective purchaser, lender or investor. Our clients have been pleased with the direct and non-technical presentation of our findings and our ability to cut through technical jargon to give them a clear and relevant "bottom-line" they need.</p>

<p>Our personnel are responsive and proficient in a wide variety of environmental disciplines. We have years of hands-on experience with government environmental regulation, as well as with the state and federal agencies responsible for implementing them. The depth of our expertise with commercial property transactions, the diverse experience of our personnel, and the thoroughness of our operating methods allow us to provide you with responsive and reliable assistance you need.</p>

<p>If you have any questions or would like to know more about LOGIC, please call or drop us a line. We would be glad to hear from you.</p>',
            'meta_title' => 'Company History - Logic Environmental',
            'meta_description' => 'Learn about the history and mission of LOGIC Environmental, providing environmental consulting services since 1997.',
            'is_published' => true,
            'show_in_menu' => true,
            'menu_location' => 'about',
            'sort_order' => 2,
        ]);

        Page::create([
            'title' => 'Our Locations',
            'slug' => 'locations',
            'content' => '<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <div class="card h-100 border-0 shadow-sm">
            <img src="/images/locations/georgia.png" class="card-img-top" alt="Georgia Office" style="height: 250px; object-fit: cover;">
            <div class="card-body">
                <h4 class="card-title mb-3"><i class="fas fa-building me-2 text-dark"></i>Georgia</h4>
                <p class="card-text">LOGIC\'s Georgia office is huddled in a shady grove near Downtown Duluth, convenient to the Duluth Cemetery and vast expanses of suburban parking. Like the six other, virtually identical structures in our complex, our office is unique. It is undeniably quaint, giving the appearance of a gingerbread office, but actually constructed – as it turns out – of entirely inedible materials. Our office interior is subdivided into various ecological habitat themes, including jungle, forest, savannah, desert and – for our special staff – the abyssopelagic ocean bottom theme. Security is provided by a pudgy beagle whom we wake only in times of dire need.</p>
                <hr>
                <p class="card-text mb-1">
                    <i class="fas fa-map-marker-alt me-2 text-dark"></i>3400 McClure Bridge Road<br>
                    <span class="ms-4">Suite F602</span><br>
                    <span class="ms-4">Duluth, Georgia 30069</span>
                </p>
                <p class="card-text mb-0">
                    <i class="fas fa-phone me-2 text-dark"></i>(770) 817-0212
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-3"><i class="fas fa-building me-2 text-dark"></i>Florida</h4>
                <p class="card-text">Upon entering our Florida office, you may have trouble locating an employee due to every flat surface being covered with live plants. The protocol in this situation is to call out "Marco!" and then follow the chorus of "Polos!" to the nearest employee. Much like the lazy security dog at the Georgia office, the plants protect the office by obscuring pathways instead of actively attacking intruders. If you\'re aware of a plant nursery which specializes in human-sized Venus fly traps, please contact the Florida office with details.</p>
                <hr>
                <p class="card-text mb-0">
                    <i class="fas fa-map-marker-alt me-2 text-dark"></i>3390 Kori Rd, Suite 8<br>
                    <span class="ms-4">Jacksonville, FL 32257</span>
                </p>
            </div>
        </div>
    </div>
</div>',
            'meta_title' => 'Our Locations - Logic Environmental',
            'meta_description' => 'Find Logic Environmental office locations in Georgia and Florida.',
            'is_published' => true,
            'show_in_menu' => true,
            'menu_location' => 'about',
            'sort_order' => 3,
        ]);
    }
}
