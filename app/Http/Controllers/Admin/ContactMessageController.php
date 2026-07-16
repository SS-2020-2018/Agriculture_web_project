<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    /**
     * List every message submitted through the public Home Page contact
     * form. Search/filter happen client-side in JS, consistent with the
     * rest of the admin area.
     */
    public function index(): View
    {
        $messages = ContactMessage::latest()->get();

        return view('admin.contact.index', [
            'messages' => $messages,
            'unreadCount' => $messages->where('is_read', false)->count(),
        ]);
    }

    /**
     * View a single message in full, marking it read the moment an
     * admin opens it.
     */
    public function show(ContactMessage $message): View
    {
        if (! $message->is_read) {
            $message->is_read = true;
            $message->save();
        }

        return view('admin.contact.show', compact('message'));
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.contact.index')->with('status', 'message-deleted');
    }
}
