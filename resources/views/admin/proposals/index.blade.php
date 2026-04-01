@extends('layouts.admin')

@section('title', 'Proposals')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2>Proposal Requests</h2>
        <p class="text-muted">View and manage submitted proposal requests</p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Property</th>
                        <th>Investigation Type</th>
                        <th>Status</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proposals as $proposal)
                    <tr>
                        <td class="text-nowrap">
                            <small>{{ $proposal->created_at->format('M j, Y') }}</small><br>
                            <small class="text-muted">{{ $proposal->created_at->format('g:i A') }}</small>
                        </td>
                        <td>
                            <strong>{{ $proposal->name }}</strong><br>
                            <small class="text-muted">{{ $proposal->email }}</small>
                            @if($proposal->company)<br><small class="text-muted">{{ $proposal->company }}</small>@endif
                        </td>
                        <td>
                            <small>{{ Str::limit($proposal->property_address, 30) }}</small><br>
                            <small class="text-muted">{{ $proposal->county }} County</small>
                        </td>
                        <td>
                            {{ $proposal->investigation_type }}
                            @if($proposal->attachments && count($proposal->attachments) > 0)
                            <br><small class="text-muted"><i class="fas fa-paperclip"></i> {{ count($proposal->attachments) }} file(s)</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $proposal->status_color }}">{{ $proposal->status_label }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.proposals.show', $proposal) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.proposals.destroy', $proposal) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this proposal?')">
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
                            No proposals submitted yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $proposals->links() }}
</div>
@endsection
