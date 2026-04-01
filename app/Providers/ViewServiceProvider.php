<?php

namespace App\Providers;

use App\Models\Page;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(['layouts.frontend'], function ($view) {
            $menuPages = [
                'main' => Page::inMenu()->menuLocation('main')->orderBy('sort_order')->get(),
                'about' => Page::inMenu()->menuLocation('about')->orderBy('sort_order')->get(),
                'footer' => Page::inMenu()->menuLocation('footer')->orderBy('sort_order')->get(),
            ];
            $view->with('menuPages', $menuPages);
        });
    }
}
