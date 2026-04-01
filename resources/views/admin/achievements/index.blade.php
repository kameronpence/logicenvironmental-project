@extends('layouts.admin')

@section('title', 'Achievements')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Achievements</h1>
    @if($canCreate)
    <a href="{{ route('admin.achievements.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add Achievement
    </a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-award me-2"></i>Homepage Achievements
            </span>
            <span class="badge bg-{{ $remainingSlots > 0 ? 'info' : 'warning' }}">
                {{ 6 - $remainingSlots }}/6 slots used
            </span>
        </div>
    </div>
    <div class="card-body">
        @if($achievements->isEmpty())
            <p class="text-muted mb-0">No achievements yet. Add up to 6 achievements to display on the homepage.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;"></th>
                            <th>Icon</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Status</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sortable-achievements">
                        @foreach($achievements as $achievement)
                        <tr data-id="{{ $achievement->id }}">
                            <td class="sortable-handle" style="cursor: grab;">
                                <i class="fas fa-grip-vertical text-muted"></i>
                            </td>
                            <td>
                                <i class="fas {{ $achievement->icon }} fa-lg text-primary"></i>
                            </td>
                            <td>{{ $achievement->title }}</td>
                            <td>{{ $achievement->subtitle ?? '-' }}</td>
                            <td>
                                @if($achievement->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.achievements.edit', $achievement) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.achievements.destroy', $achievement) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this achievement?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<div class="card mt-4">
    <div class="card-header bg-light">
        <i class="fas fa-info-circle me-2"></i>Common Font Awesome Icons
    </div>
    <div class="card-body">
        <p class="text-muted small mb-3">Use these icon class names (e.g., <code>fa-calendar-check</code>):</p>
        <div class="row">
            <div class="col-md-3 mb-2"><i class="fas fa-calendar-check me-2"></i><code>fa-calendar-check</code></div>
            <div class="col-md-3 mb-2"><i class="fas fa-file-alt me-2"></i><code>fa-file-alt</code></div>
            <div class="col-md-3 mb-2"><i class="fas fa-map-marked-alt me-2"></i><code>fa-map-marked-alt</code></div>
            <div class="col-md-3 mb-2"><i class="fas fa-award me-2"></i><code>fa-award</code></div>
            <div class="col-md-3 mb-2"><i class="fas fa-users me-2"></i><code>fa-users</code></div>
            <div class="col-md-3 mb-2"><i class="fas fa-building me-2"></i><code>fa-building</code></div>
            <div class="col-md-3 mb-2"><i class="fas fa-certificate me-2"></i><code>fa-certificate</code></div>
            <div class="col-md-3 mb-2"><i class="fas fa-check-circle me-2"></i><code>fa-check-circle</code></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const el = document.getElementById('sortable-achievements');
    if (el) {
        Sortable.create(el, {
            handle: '.sortable-handle',
            animation: 150,
            onEnd: function() {
                const order = Array.from(el.querySelectorAll('tr')).map(row => row.dataset.id);
                fetch('{{ route('admin.achievements.reorder') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order })
                });
            }
        });
    }
});
</script>
@endpush
