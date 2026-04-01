@extends('layouts.admin')

@section('title', 'Team Members')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Team Members</h2>
        <p class="text-muted mb-0"><i class="fas fa-arrows-alt me-1"></i> Drag rows to reorder</p>
    </div>
    <a href="{{ route('admin.team.create') }}" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> Add Member
    </a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white">
        <h6 class="mb-0"><i class="fas fa-heading me-2"></i>Section Title</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.team.update-section-title') }}" method="POST" class="row g-3 align-items-end">
            @csrf
            @method('PUT')
            <div class="col-md-8">
                <label for="team_section_title" class="form-label">Title displayed above team members on the About page</label>
                <input type="text" class="form-control @error('team_section_title') is-invalid @enderror"
                       id="team_section_title" name="team_section_title"
                       value="{{ old('team_section_title', $teamSectionTitle) }}" required>
                @error('team_section_title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-save me-1"></i> Update Title
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th width="40"></th>
                    <th width="60">Photo</th>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody id="sortable-team">
                @forelse($members as $member)
                <tr data-id="{{ $member->id }}">
                    <td class="drag-handle text-center" style="cursor: grab;">
                        <i class="fas fa-grip-vertical text-muted"></i>
                    </td>
                    <td>
                        @if($member->photo)
                            <img src="{{ $member->photo_url }}" alt="{{ $member->name }}"
                                 class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $member->name }}</strong>
                        @if($member->email)
                            <br><small class="text-muted">{{ $member->email }}</small>
                        @endif
                    </td>
                    <td>{{ $member->title ?? '-' }}</td>
                    <td>
                        @if($member->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.team.edit', $member) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.team.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this team member?')">
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
                    <td colspan="6" class="text-center py-4 text-muted">
                        No team members found. <a href="{{ route('admin.team.create') }}">Add your first team member</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($members->hasPages())
    <div class="card-footer bg-white">
        {{ $members->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.getElementById('sortable-team');
    if (tbody && tbody.children.length > 0) {
        new Sortable(tbody, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'bg-light',
            onEnd: function(evt) {
                const rows = tbody.querySelectorAll('tr[data-id]');
                const order = Array.from(rows).map(row => row.dataset.id);

                fetch('{{ route('admin.team.reorder') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Optionally show a success message
                    }
                })
                .catch(error => {
                    console.error('Error saving order:', error);
                });
            }
        });
    }
});
</script>
@endpush

@push('styles')
<style>
.drag-handle:active {
    cursor: grabbing !important;
}
#sortable-team tr {
    transition: background-color 0.15s;
}
</style>
@endpush
