@extends('layouts.app')

@section('title', 'Daftar Tickets')

@section('content')
<h1>Tickets</h1>
<a href="{{ route('tickets.create') }}" class="btn btn-primary mb-3">Buat Ticket Baru</a>

<form method="GET" action="{{ route('tickets.index') }}" class="mb-3 d-flex align-items-center">
    <label for="status" class="me-2">Filter Status:</label>
    <select name="status" id="status" class="form-select w-auto me-2" onchange="this.form.submit()">
        <option value="">Semua</option>
        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
    </select>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Assigned Agent</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tickets as $ticket)
        <tr>
            <td>{{ $ticket->title }}</td>
            <td>{{ ucfirst($ticket->priority) }}</td>
            <td>{{ ucfirst($ticket->status) }}</td>
            <td>{{ $ticket->assignedAgent ? $ticket->assignedAgent->name : '-' }}</td>
            <td>
                @if(auth()->user()->role == 'admin' || (auth()->user()->role == 'agent' && $ticket->assigned_agent_id == auth()->id()))
                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-info btn-sm">Detail</a>
                <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning btn-sm">Edit</a>                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $tickets->links() }}
@endsection
