<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $query = Ticket::query();

        if ($user->role === 'agent') {
            $query->where('assigned_agent_id', $user->id);
        } elseif ($user->role !== 'admin') {
            $query->where('user_id', $user->id); // Perbaikan di sini
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
            });
        }

        $tickets = $query->get();

        $totalTickets = $tickets->count();
        $openTickets = $tickets->where('status', 'open')->count();
        $closedTickets = $tickets->where('status', 'closed')->count();
        $inProgressTickets = $tickets->where('status', 'in progress')->count();

        return view('dashboard', compact('tickets', 'totalTickets', 'openTickets', 'closedTickets', 'inProgressTickets'));
    }
}
