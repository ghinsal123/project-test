<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketReply;
use App\Models\Ticket;


class TicketReplyController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'message' => 'required|string',
        ]);

        TicketReply::create([
            'ticket_id' => $request->ticket_id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return back()->with('success', 'Balasan dikirim.');
    }

    public function close(Ticket $ticket)
    {
        $ticket->update(['status' => 'closed']);
        return back()->with('success', 'Tiket ditutup.');
    }
}
