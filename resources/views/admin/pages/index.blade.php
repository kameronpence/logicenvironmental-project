@extends('layouts.admin')

@section('title', 'Pages')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Pages</h2>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> New Page
    </a>
</div>

<div class="alert alert-info alert-dismissible fade show" role="alert">
    <i class="fas fa-info-circle me-2"></i>
    <strong>Note:</strong> The home page is not listed here because it contains custom layouts and components that require developer changes.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Updated</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                <tr>
                    <td>
                        <strong>{{ $page->title }}</strong>
                    </td>
                    <td>
                        <code>/page/{{ $page->slug }}</code>
                    </td>
                    <td>
                        @if($page->is_published)
                            <span class="badge bg-success">Published</span>
                        @else
                            <span class="badge bg-secondary">Draft</span>
                        @endif
                    </td>
                    <td>{{ $page->updated_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this page?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        No pages found. <a href="{{ route('admin.pages.create') }}">Create your first page</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pages->hasPages())
    <div class="card-footer bg-white">
        {{ $pages->links() }}
    </div>
    @endif
</div>
@endsection
