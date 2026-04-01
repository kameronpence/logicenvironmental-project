@extends('layouts.admin')

@section('title', 'Services')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Services</h2>
        <p class="text-muted mb-0"><i class="fas fa-arrows-alt me-1"></i> Drag rows to reorder</p>
    </div>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Service
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th width="40"></th>
                    <th width="60">Icon</th>
                    <th>Title</th>
                    <th>Short Description</th>
                    <th>Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody id="sortable-services">
                @forelse($services as $service)
                <tr data-id="{{ $service->id }}">
                    <td class="drag-handle text-center" style="cursor: grab;">
                        <i class="fas fa-grip-vertical text-muted"></i>
                    </td>
                    <td class="text-center">
                        <i class="fas {{ $service->icon }} fa-lg text-primary"></i>
                    </td>
                    <td>
                        <strong>{{ $service->title }}</strong>
                    </td>
                    <td>
                        <small class="text-muted">{{ Str::limit($service->short_description, 60) }}</small>
                    </td>
                    <td>
                        @if($service->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this service?')">
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
                        No services found. <a href="{{ route('admin.services.create') }}">Add your first service</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($services->hasPages())
    <div class="card-footer bg-white">
        {{ $services->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.getElementById('sortable-services');
    if (tbody && tbody.children.length > 0) {
        new Sortable(tbody, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'bg-light',
            onEnd: function(evt) {
                const rows = tbody.querySelectorAll('tr[data-id]');
                const order = Array.from(rows).map(row => row.dataset.id);

                fetch('{{ route('admin.services.reorder') }}', {
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
#sortable-services tr {
    transition: background-color 0.15s;
}
</style>
@endpush
