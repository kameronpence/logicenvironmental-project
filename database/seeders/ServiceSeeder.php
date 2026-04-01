<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Transaction Screen Assessments',
                'icon' => 'fa-file-contract',
                'short_description' => 'Streamlined environmental evaluations for lower-risk property transactions.',
                'full_description' => 'LOGIC provides transaction screen assessments as an abbreviated version of a Phase I ESA which is typically used for lower risk properties, especially vacant and/or agricultural land.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'USDA Services',
                'icon' => 'fa-tractor',
                'short_description' => 'Environmental services tailored to meet USDA requirements.',
                'full_description' => 'LOGIC provides environmental reports in accordance with the National Environmental Policy Act (NEPA) and RD 1970-A, Subpart G for loans guaranteed by the United States Department of Agriculture (USDA).',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Risk Assessment',
                'icon' => 'fa-exclamation-triangle',
                'short_description' => 'Comprehensive risk evaluations for human health and the environment.',
                'full_description' => "LOGIC's Risk Assessments are performed in compliance with the US Small Business Association's (SBA) requirements to analyze additional risks associated with a property beyond the recognized environmental conditions that are addressed by Phase I ESAs.",
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Underground Storage Tanks',
                'icon' => 'fa-oil-can',
                'short_description' => 'Complete UST services from oversight to closure and remediation.',
                'full_description' => 'LOGIC offers a comprehensive range of services with regard to underground storage tanks including tank closure oversight, assessment, and corrective action.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Release Response',
                'icon' => 'fa-hard-hat',
                'short_description' => 'Rapid response services for environmental releases and spills.',
                'full_description' => "LOGIC provides assessment and remediation services for releases subject to state-led clean-up programs such as Georgia's Hazardous Site Response Act (HSRA) and federal programs such as the Resource Conservation and Recovery Act (RCRA) Corrective Action Program.",
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Hazardous Waste Services',
                'icon' => 'fa-biohazard',
                'short_description' => 'Comprehensive hazardous waste management from characterization to disposal.',
                'full_description' => 'LOGIC provides a range of hazardous waste disposal services, including waste characterization, broker services, and emergency response services.',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'Permitting and Compliance',
                'icon' => 'fa-clipboard-check',
                'short_description' => 'Navigate complex environmental regulations and maintain compliance.',
                'full_description' => 'LOGIC provides a range of permitting and compliance services, including SWPPP development and inspection and UST permitting and compliance services.',
                'sort_order' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
