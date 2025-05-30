<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Category;


class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::query()->with('assignedAgent', 'categories');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->priority) {
            $query->where('priority', $request->priority);
        }

        if ($request->category) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        $tickets = $query->paginate(10);
        $categories = Category::all(); // Kirim ini ke view

        return view('tickets.index', compact('tickets', 'categories'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'labels' => 'nullable|array',
            'labels.*' => 'string',
            'categories' => 'nullable|array',
            'categories.*' => 'string',
            'priority' => 'required|in:low,medium,high',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // max 2MB
        ]);

        // Proses upload file kalau ada
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('attachments', 'public');
            $validated['attachment_path'] = $path;
        }

        // Simpan data ticket ke database
        $ticket = new Ticket();
        $ticket->title = $validated['title'];
        $ticket->description = $validated['description'];
        $ticket->priority = $validated['priority'];
        $ticket->labels = isset($validated['labels']) ? json_encode($validated['labels']) : null;
        $ticket->categories = isset($validated['categories']) ? json_encode($validated['categories']) : null;
        $ticket->attachment_path = $validated['attachment_path'] ?? null;

        $ticket->user_id = auth()->id();

        // Simpan, sesuaikan field tabel ticket kamu
        $ticket->save();

        // Redirect ke halaman daftar ticket dengan pesan sukses
        return redirect()->route('tickets.index')->with('success', 'Ticket berhasil dibuat!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        // Cek hak akses
        $user = auth()->user();
        if ($user->role != 'admin' && $ticket->user_id != $user->id && $ticket->assigned_agent_id != $user->id) {
            abort(403);
        }

        $ticket->load('replies.user','categories');
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ticket = Ticket::findOrFail($id);

        $user = auth()->user();
        if ($user->role != 'admin' && $ticket->assigned_agent_id != $user->id) {
            abort(403); // hanya admin atau agent yg ditugaskan
        }

        $agents = \App\Models\User::where('role', 'agent')->get(); // buat dropdown agent
        return view('tickets.edit', compact('ticket', 'agents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:open,in_progress,closed',
            'assigned_agent_id' => 'nullable|exists:users,id',
        ]);

        $ticket = Ticket::findOrFail($id);

        $user = auth()->user();
        if ($user->role != 'admin' && $ticket->assigned_agent_id != $user->id) {
            abort(403);
        }

        $ticket->update([
            'priority' => $request->priority,
            'status' => $request->status,
            'assigned_agent_id' => $request->assigned_agent_id,
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Tiket berhasil dihapus');
    }

    public function close($id)
    {
        // Cari tiket berdasarkan ID
        $ticket = Ticket::findOrFail($id);

        // Ubah status tiket menjadi 'closed' (atau sesuai dengan field status di DB)
        $ticket->status = 'closed';
        $ticket->save();

        // Redirect balik ke halaman tiket atau halaman lain dengan pesan sukses
        return redirect()->route('tickets.show', $ticket->id)
                        ->with('success', 'Tiket berhasil ditutup.');
    }

}
