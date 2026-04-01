@extends('layouts.admin')

@section('title', 'Activity Log')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2>Activity Log</h2>
        <p class="text-muted">Track all changes made to pages and team members</p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date/Time</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Type</th>
                        <th>Item</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="text-nowrap">
                            <small>{{ $log->created_at->format('M j, Y') }}</small><br>
                            <small class="text-muted">{{ $log->created_at->format('g:i A') }}</small>
                        </td>
                        <td>
                            @if($log->user)
                                {{ $log->user->name }}
                            @else
                                <span class="text-muted">System</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $log->action_color }}">{{ $log->action_label }}</span>
                        </td>
                        <td>{{ $log->model_type }}</td>
                        <td>{{ $log->model_name }}</td>
                        <td>
                            @if($log->changes)
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#changesModal{{ $log->id }}">
                                    <i class="fas fa-eye"></i> View
                                </button>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            No activity logged yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $logs->links() }}
</div>

@foreach($logs as $log)
    @if($log->changes)
    <div class="modal fade" id="changesModal{{ $log->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Changes Made</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>New Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($log->changes as $field => $value)
                            <tr>
                                <td><strong>{{ ucwords(str_replace('_', ' ', $field)) }}</strong></td>
                                <td>
                                    @if(is_string($value) && strlen($value) > 100)
                                        {{ \Illuminate\Support\Str::limit($value, 100) }}
                                    @else
                                        {{ is_bool($value) ? ($value ? 'Yes' : 'No') : $value }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
@endsection
