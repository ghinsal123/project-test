@extends('layouts.app')

@section('title', 'Daftar Tickets')

@section('content')
<h1>Tickets</h1>
<a href="{{ route('tickets.create') }}" class="btn btn-primary mb-3">Buat Ticket Baru</a>

<form method="GET" action="{{ route('tickets.index') }}" class="mb-3 row gx-2">
    <div class="col-auto">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">Status: Semua</option>
            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
        </select>
    </div>
    <div class="col-auto">
        <select name="priority" class="form-select" onchange="this.form.submit()">
            <option value="">Prioritas: Semua</option>
            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
        </select>
    </div>
    <div class="col-auto">
        <select name="category" class="form-select">
            <option value="">Kategori : Semua </option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
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
                    <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    
                    <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus tiket ini?');" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $tickets->links() }}
@endsection
