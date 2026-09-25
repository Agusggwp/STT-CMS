<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%")
                  ->orWhere('email', 'like', "%{$request->q}%")
                  ->orWhere('subject', 'like', "%{$request->q}%")
                  ->orWhere('message', 'like', "%{$request->q}%");
            });
        }

        $messages = $query->latest()->paginate(15)->withQueryString();

        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function toggleRead(ContactMessage $message)
    {
        $message->update(['is_read' => !$message->is_read]);

        return redirect()->back()->with('success', 'Status pesan diperbarui.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        ActivityLog::record('delete_message', 'Menghapus pesan kontak dari ' . $message->name);

        return redirect()->route('admin.messages.index')->with('success', 'Pesan berhasil dihapus.');
    }
}
