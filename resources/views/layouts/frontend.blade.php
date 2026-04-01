<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', 'Logic Environmental - Environmental Consulting Services')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #742E6F;
            --primary-dark: #5a2357;
            --text-dark: #444444;
        }
        html {
            overflow-y: scroll;
        }
        body {
            font-family: 'Raleway', sans-serif;
            color: var(--text-dark);
        }
        /* Prevent modal from shifting page */
        body.modal-open {
            padding-right: 0 !important;
            overflow: hidden !important;
        }
        body.modal-open .navbar {
            padding-right: 0 !important;
        }
        .modal {
            padding-right: 0 !important;
        }
        .modal-open .modal {
            overflow-y: auto;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .navbar-brand img {
            width: auto;
            height: 50px;
        }
        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 100px 0;
        }
        .team-card img {
            height: 250px;
            object-fit: cover;
        }
        footer {
            background: #212529;
            color: #adb5bd;
        }
        footer a {
            color: #adb5bd;
        }
        footer a:hover {
            color: white;
        }
        .btn-primary, .btn-success {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }
        .btn-primary:hover, .btn-success:hover {
            background-color: var(--primary-dark) !important;
            border-color: var(--primary-dark) !important;
        }
        .btn-outline-primary, .btn-outline-success {
            color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }
        .btn-outline-primary:hover, .btn-outline-success:hover {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }
        .text-success, .text-primary {
            color: var(--primary-color) !important;
        }
        .bg-success {
            background-color: var(--primary-color) !important;
        }
        a {
            color: var(--primary-color);
        }
        a:hover {
            color: var(--primary-dark);
        }
        .nav-link.active {
            color: var(--primary-color) !important;
        }
        .text-dark {
            color: var(--text-dark) !important;
        }
        .bg-dark {
            background-color: var(--text-dark) !important;
        }
        .btn-dark {
            background-color: var(--text-dark) !important;
            border-color: var(--text-dark) !important;
        }
        .btn-dark:hover {
            background-color: #1a1a1a !important;
            border-color: #1a1a1a !important;
        }
        .btn-outline-dark {
            color: var(--text-dark) !important;
            border-color: var(--text-dark) !important;
        }
        .btn-outline-dark:hover {
            background-color: var(--text-dark) !important;
            border-color: var(--text-dark) !important;
            color: white !important;
        }
        h1, h2, h3, h4, h5, h6 {
            color: var(--text-dark);
        }
        .card-title {
            color: var(--text-dark);
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top" style="border-bottom: 1px solid #e9ecef;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logos/logo-updated_copy.png') }}" alt="{{ config('app.name') }}" height="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('home') ? 'active fw-bold' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>

                    {{-- Dynamic main menu pages --}}
                    @foreach($menuPages['main'] ?? [] as $page)
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->is('page/'.$page->slug) ? 'active fw-bold' : '' }}" href="{{ route('page.show', $page->slug) }}">{{ $page->menu_display_title }}</a>
                    </li>
                    @endforeach

                    <li class="nav-item dropdown">
                        <a class="nav-link text-dark dropdown-toggle {{ request()->routeIs('about') || request()->is('page/*') ? 'active fw-bold' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                            About
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('about') }}">Our Team</a></li>
                            {{-- Dynamic about dropdown pages --}}
                            @foreach($menuPages['about'] ?? [] as $page)
                            <li><a class="dropdown-item" href="{{ route('page.show', $page->slug) }}">{{ $page->menu_display_title }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('proposal') ? 'active fw-bold' : '' }}" href="{{ route('proposal') }}">Request Proposal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('client-portal.*') ? 'active fw-bold' : '' }}" href="{{ route('client-portal.request') }}">Client Portal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('contact') ? 'active fw-bold' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                    @auth
                        @if(auth()->user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('admin.dashboard') }}">Admin</a>
                        </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="pt-5 pb-4">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="text-white mb-3">Logic Environmental</h5>
                    <p class="mb-0">Environmental Assessments and Common Sense Solutions</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="text-white mb-3">Quick Links</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="{{ route('home') }}">Home</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}">About Us</a></li>
                        <li class="mb-2"><a href="{{ route('proposal') }}">Request Proposal</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="text-white mb-3">Georgia Office</h5>
                    <p class="mb-0">
                        3400 McClure Bridge Road<br>
                        Suite F602<br>
                        Duluth, GA 30096
                    </p>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="text-center">
                &copy; {{ date('Y') }} Logic Environmental. All rights reserved.
                <span class="mx-2">|</span>
                <a href="{{ route('login') }}" target="_blank">Admin Login</a>
            </div>
        </div>
    </footer>

    @include('partials.upload-progress-modal')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
