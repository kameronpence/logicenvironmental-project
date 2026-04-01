<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        html {
            overflow-y: scroll;
        }
        .sidebar {
            min-height: 100vh;
            background: #212529;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.8);
            padding: 0.75rem 1rem;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,.1);
        }
        .sidebar .nav-link i {
            width: 24px;
        }
        .content-wrapper {
            min-height: 100vh;
            background: #f8f9fa;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="p-3 text-white">
                    <h5 class="mb-0">{{ config('app.name') }}</h5>
                    <small class="text-muted">Admin Panel</small>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>

                    @if(auth()->user()->canViewProposals())
                    <a class="nav-link {{ request()->routeIs('admin.proposals.*') ? 'active' : '' }}" href="{{ route('admin.proposals.index') }}">
                        <i class="fas fa-file-invoice"></i> Proposals
                    </a>
                    @endif

                    @if(auth()->user()->canViewDocuments())
                    <a class="nav-link {{ request()->routeIs('admin.client-portals.*') ? 'active' : '' }}" href="{{ route('admin.client-portals.index') }}">
                        <i class="fas fa-cloud"></i> Client Portals
                    </a>
                    @endif

                    <hr class="text-secondary mx-3 my-2">

                    @if(auth()->user()->canManagePages())
                    <a class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">
                        <i class="fas fa-file-alt"></i> Pages
                    </a>
                    @endif

                    @if(auth()->user()->canManageServices())
                    <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}">
                        <i class="fas fa-concierge-bell"></i> Services
                    </a>
                    @endif

                    @if(auth()->user()->canManageServices())
                    <a class="nav-link {{ request()->routeIs('admin.achievements.*') ? 'active' : '' }}" href="{{ route('admin.achievements.index') }}">
                        <i class="fas fa-award"></i> Achievements
                    </a>
                    @endif

                    @if(auth()->user()->canManagePages())
                    <a class="nav-link {{ request()->routeIs('admin.images.*') ? 'active' : '' }}" href="{{ route('admin.images.index') }}">
                        <i class="fas fa-images"></i> Homepage Images
                    </a>
                    @endif

                    @if(auth()->user()->canManageTeam())
                    <a class="nav-link {{ request()->routeIs('admin.team.*') ? 'active' : '' }}" href="{{ route('admin.team.index') }}">
                        <i class="fas fa-users"></i> Team Members
                    </a>
                    @endif

                    <hr class="text-secondary mx-3 my-2">

                    @if(auth()->user()->canManageUsers())
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-user-shield"></i> Admin Users
                    </a>
                    @endif

                    @if(auth()->user()->canViewActivity())
                    <a class="nav-link {{ request()->routeIs('admin.activity.*') ? 'active' : '' }}" href="{{ route('admin.activity.index') }}">
                        <i class="fas fa-history"></i> Activity Log
                    </a>
                    @endif

                    @if(auth()->user()->canManageSettings())
                    <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-cog"></i> Site Settings
                    </a>
                    @endif

                    <hr class="text-secondary mx-3">
                    <a class="nav-link" href="{{ route('home') }}" target="_blank">
                        <i class="fas fa-external-link-alt"></i> View Site
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="px-3 mt-2">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm w-100">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 content-wrapper">
                <nav class="navbar navbar-light bg-white shadow-sm mb-4">
                    <div class="container-fluid">
                        <span class="navbar-text">
                            Welcome, {{ auth()->user()->name }}
                            @if(auth()->user()->isSuperAdmin())
                                <span class="badge bg-danger ms-2">Super Admin</span>
                            @endif
                        </span>
                    </div>
                </nav>

                <div class="container-fluid px-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @include('partials.upload-progress-modal')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
