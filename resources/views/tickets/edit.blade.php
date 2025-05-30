@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Ticket</h1>

    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Prioritas</label>
            <select name="priority" class="form-control" required>
                <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Assigned Agent</label>
            <select name="assigned_agent_id" class="form-control">
                <option value="">-- Pilih Agent --</option>
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" {{ $ticket->assigned_agent_id == $agent->id ? 'selected' : '' }}>
                        {{ $agent->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update Ticket</button>
        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
