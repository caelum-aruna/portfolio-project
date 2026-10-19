<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Inertia\Inertia;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->get();

        return Inertia::render('Admin/Messages/Index', [
            'messages' => $messages,
        ]);
    }

    public function toggleRead(ContactMessage $message)
    {
        $message->update([
            'is_read' => ! $message->is_read,
        ]);

        return back()->with('success', 'Status pesan diperbarui.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}
