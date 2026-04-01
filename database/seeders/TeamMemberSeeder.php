<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name' => 'Brandy Lipps',
                'title' => 'Principal',
                'email' => 'brandylipps@logicenvironmental.com',
                'bio' => 'Brandy is a graduate of the University of Georgia\'s School of Environmental Health Science and has experience in both laboratory and field investigations. She has been with LOGIC since 2007, performing environmental assessments and specializing in vapor intrusion and Brownfields. Her dog, Lyra, is responsible for welcoming burglars to the office.',
                'photo' => 'brandy.png',
                'sort_order' => 1
            ],
            [
                'name' => 'Chris Fonzi',
                'title' => 'Principal',
                'email' => 'chrisfonzi@logicenvironmental.com',
                'bio' => 'Chris is founder and principal of LOGIC. He is a graduate of the University of Florida and the UF School of Law. He has performed environmental assessments and provided consulting services in more than 20 states during the past 31 years. He is regarded for his sage leadership, fine singing voice, and disdain of cats.',
                'photo' => 'chris-copy.png',
                'sort_order' => 2
            ],
            [
                'name' => 'Dennis E. Brunner',
                'title' => 'Senior Professional Geologist',
                'email' => 'dbrunner@logicenvironmental.com',
                'bio' => 'Dennis Brunner is LOGIC\'s Senior Professional Geologist. He is a graduate of Indiana University of Pennsylvania and a registered geologist in Georgia and Alabama. Primary duties include estimating costs and scheduling for Phase II investigations and management of underground storage tank remediation projects. Dennis is also active in supervising staff in site investigation procedures and environmental sampling techniques.',
                'photo' => 'dennis.png',
                'sort_order' => 3
            ],
            [
                'name' => 'Carlos Hidalgo',
                'title' => 'Senior Environmental Scientist',
                'email' => 'carlos@logicenvironmental.com',
                'bio' => 'Carlos began with LOGIC as an Environmental Assessor in 2007. He holds a bachelor\'s degree from the University of Florida and a Masters Degree from Florida State University. He performs environmental assessments and field technical services. Outside of LOGIC, Carlos is an artist and also an adjunct art professor at Georgia State University.',
                'photo' => 'carlos.png',
                'sort_order' => 4
            ],
            [
                'name' => 'Paul Zoglman',
                'title' => 'Senior Environmental Scientist',
                'email' => 'pzoglman@logicenvironmental.com',
                'bio' => 'Paul received a B.S. and an M.S. in Management from Purdue University. He minored in International Business, studying French, Italian, German, Spanish and Portuguese along the way. At this point, Paul can ask "Where is the library?" all across Europe. Paul\'s favorite part of conducting Phase I and Phase II Environmental Assessments at LOGIC is traveling. The scenery of an old Denny\'s in rural South Georgia, is unparalleled. When Paul is not traveling for work, he enjoys spending time with friends, playing trivia and catching up on his favorite TV shows.',
                'photo' => 'paul-copy.jpg',
                'sort_order' => 5
            ],
            [
                'name' => 'Ciara Seabolt',
                'title' => 'Director of Geologic Services',
                'email' => 'cseabolt@logicenvironmental.com',
                'bio' => 'Ciara Seabolt joined LOGIC as a Geologist in 2018. She is a graduate of the University of Georgia with a Bachelor\'s degree in Geology. Ciara manages the Geologic Services Department, including field sampling and remediation services. She loves exploring the outdoors and appreciates working where she can appreciate the 20 different seasons provided by Mother Nature.',
                'photo' => 'ciara.jpg',
                'sort_order' => 6
            ],
            [
                'name' => 'Meredith Starks',
                'title' => 'Environmental Scientist',
                'email' => 'mstarks@logicenvironmental.com',
                'bio' => 'Meredith received a BS in Environmental Science and a BA in Biology from Emory University, as well as a Master\'s degree in Environmental Health from the Rollins School of Public Health at Emory. She joined the LOGIC team in 2021 and has since worked primarily on Phase I Environmental Site Assessments. In her limited spare time, Meredith is an avid singer, kickboxer, tattoo enthusiast, and nature lover.',
                'photo' => 'meredith2.jpg',
                'sort_order' => 7
            ],
            [
                'name' => 'Killian Mohre',
                'title' => 'Environmental Scientist',
                'email' => 'kmohre@logicenvironmental.com',
                'bio' => 'Killian received a B.S. in Biochemistry and MSc in Aquatic Environmental Sciences from Florida State University. She joined LOGIC\'s Florida team in 2022 and has mainly worked on Phase I Environmental Site Assessments but has recently joined the NEPA team. She enjoys outdoor adventures, reading at the beach, going to local coffee shops, and spending time with her cat Jasper (aka Bean).',
                'photo' => 'killian-mohre-photo-copy.png',
                'sort_order' => 8
            ],
            [
                'name' => 'Liz Hecker',
                'title' => 'Environmental Scientist',
                'email' => 'ehecker@logicenvironmental.com',
                'bio' => 'Liz received a B.S. in Environmental Science with a minor in Soil Science from Montana State University. Liz joined the LOGIC team in 2022 and mainly conducts NEPA reviews and assessments for USDA construction loans. On occasion, she performs Phase I Environmental Site Assessments. In her spare time, Liz enjoys playing disc golf, camping, creating stained glass art, and eating.',
                'photo' => 'liz-hecker-photo-copy2.png',
                'sort_order' => 9
            ],
            [
                'name' => 'Christian Baity',
                'title' => 'Administrative Assistant',
                'email' => 'cbaity@logicenvironmental.com',
                'bio' => 'Christian joined LOGIC in early 2022. She manages project setup and scheduling and provides a wealth of administrative support services. Christian enjoys photography and is a devoted fashion enthusiast and model.',
                'photo' => 'christian-copy.jpg',
                'sort_order' => 10
            ],
        ];

        foreach ($members as $member) {
            TeamMember::create([
                'name' => $member['name'],
                'title' => $member['title'],
                'email' => $member['email'],
                'bio' => $member['bio'],
                'photo' => $member['photo'],
                'sort_order' => $member['sort_order'],
                'is_active' => true,
            ]);
        }
    }
}
