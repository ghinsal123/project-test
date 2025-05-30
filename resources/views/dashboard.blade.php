@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h2 class="mb-4">Dashboard</h2>

    <!-- Search Form -->
    <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari tiket...">
            <button type="submit" class="btn btn-outline-primary">Cari</button>
        </div>
    </form>

    <!-- Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Tiket</h5>
                    <p class="card-text fs-3">{{ $totalTickets }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Tiket Open</h5>
                    <p class="card-text fs-3">{{ $openTickets }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Tiket Closed</h5>
                    <p class="card-text fs-3">{{ $closedTickets }}</p>
                </div>
            </div>
        </div>
    </div>
    @if($tickets->count())
        <div class="card mt-4">
            <div class="card-header">Daftar Tiket</div>
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Dibuat Oleh</th>
                            <th>Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->title }}</td>
                                <td>
                                    @if($ticket->status === 'open')
                                        <span class="badge bg-warning text-dark">Open</span>
                                    @elseif($ticket->status === 'closed')
                                        <span class="badge bg-success">Closed</span>
                                    @else
                                        <span class="badge bg-info text-dark">In Progress</span>
                                    @endif
                                </td>
                                <td>{{ $ticket->creator->name ?? 'N/A' }}</td>
                                <td>{{ $ticket->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p class="mt-4 text-muted">Tidak ada tiket yang ditemukan.</p>
    @endif
@endsection
