@extends('layouts.app')

@section('title', 'Detail Ticket')

@section('content')
<div class="container">
    <h1>Detail Ticket</h1>

    <div class="card">
        <div class="card-header">
            <strong>{{ $ticket->title }}</strong>
        </div>
        <div class="card-body">
            <p><strong>Deskripsi:</strong><br>{{ $ticket->description }}</p>
            <p><strong>Status:</strong> {{ ucfirst($ticket->status) }}</p>
            <p><strong>Prioritas:</strong> {{ ucfirst($ticket->priority) }}</p>
            <p><label class="form-label fw-bold">Lampiran:</label><br>
            @if ($ticket->attachment)
                <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank">Lihat Lampiran</a>
            @else
                Tidak ada lampiran.
            @endif
            </p>
            <p><strong>Assigned Agent:</strong> {{ $ticket->assignedAgent ? $ticket->assignedAgent->name : '-' }}</p>
            <p><strong>Dibuat pada:</strong> {{ $ticket->created_at->format('d M Y, H:i') }}</p>
        </div>
    </div>

    <form action="{{ route('ticket-replies.store') }}" method="POST">
        @csrf
        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
        <textarea name="message" class="form-control" rows="3" placeholder="Tulis balasan..."></textarea>
        <button type="submit" class="btn btn-primary mt-2">Kirim</button>
    </form>

    @if($ticket->status === 'open')
    <form action="{{ route('tickets.close', $ticket->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <button class="btn btn-danger mt-2">Tutup Tiket</button>
    </form>
    @else
        <div class="alert alert-success mt-2">Tiket sudah ditutup</div>
    @endif

    <hr>
    <h5>Balasan:</h5>
    @forelse($ticket->replies as $reply)
        <div class="card mb-2">
            <div class="card-body">
                <p>{{ $reply->message }}</p>
                <small class="text-muted">Dibalas oleh: {{ $reply->user->name }} - {{ $reply->created_at->diffForHumans() }}</small>
            </div>
        </div>
    @empty
        <p>Belum ada balasan.</p>
    @endforelse


    <a href="{{ route('tickets.index') }}" class="btn btn-secondary mt-3">Kembali ke daftar tickets</a>
</div>
@endsection
