<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Page;
use App\Models\Service;
use App\Models\SiteImage;
use App\Models\TeamMember;

class PageController extends Controller
{
    public function home()
    {
        $page = Page::where('slug', 'home')->first();
        $services = Service::active()->get();
        $achievements = Achievement::active()->get();

        // Load site images for homepage
        $siteImages = [
            'banner' => SiteImage::getByLocation('banner'),
            'services_1' => SiteImage::getByLocation('services_1'),
            'services_2' => SiteImage::getByLocation('services_2'),
            'services_3' => SiteImage::getByLocation('services_3'),
            'services_4' => SiteImage::getByLocation('services_4'),
        ];

        return view('pages.home', compact('page', 'services', 'achievements', 'siteImages'));
    }

    public function about()
    {
        $page = Page::where('slug', 'about')->firstOrFail();
        $teamMembers = TeamMember::active()->get();
        $pageImage = SiteImage::getByLocation('about');
        return view('pages.about', compact('page', 'teamMembers', 'pageImage'));
    }

    public function show(Page $page)
    {
        if (!$page->is_published) {
            abort(404);
        }

        // Load page-specific image
        $pageImage = null;
        if ($page->slug === 'company-history') {
            $pageImage = SiteImage::getByLocation('history');
        }

        // Load multiple images for locations page
        $locationImages = [];
        if ($page->slug === 'locations') {
            $locationImages = [
                'georgia' => SiteImage::getByLocation('location_georgia'),
                'florida' => SiteImage::getByLocation('location_florida'),
            ];
        }

        return view('pages.show', compact('page', 'pageImage', 'locationImages'));
    }

    public function proposal()
    {
        $services = Service::active()->get();
        return view('pages.proposal', compact('services'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function teamOption($option)
    {
        $teamMembers = TeamMember::active()->get();
        $view = 'pages.team-option-' . $option;

        if (!view()->exists($view)) {
            abort(404);
        }

        return view($view, compact('teamMembers'));
    }
}
