@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2>Dashboard</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Pages</h6>
                        <h3 class="mb-0">{{ $stats['pages'] }}</h3>
                    </div>
                    <div class="text-primary">
                        <i class="fas fa-file-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Published Pages</h6>
                        <h3 class="mb-0">{{ $stats['published_pages'] }}</h3>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Team Members</h6>
                        <h3 class="mb-0">{{ $stats['team_members'] }}</h3>
                    </div>
                    <div class="text-info">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Active Members</h6>
                        <h3 class="mb-0">{{ $stats['active_team_members'] }}</h3>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-user-check fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.pages.create') }}" class="btn btn-primary me-2">
                    <i class="fas fa-plus"></i> New Page
                </a>
                <a href="{{ route('admin.team.create') }}" class="btn btn-outline-primary">
                    <i class="fas fa-user-plus"></i> Add Team Member
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
