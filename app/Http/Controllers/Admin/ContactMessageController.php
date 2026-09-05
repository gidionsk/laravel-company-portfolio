<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $messages = ContactMessage::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message): View
    {
        if ($message->status === 'new') {
            $message->update(['status' => 'read']);
        }
        return view('admin.messages.show', compact('message'));
    }

    public function update(Request $request, ContactMessage $message): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', 'in:new,read,archived']]);
        $message->update($data);
        return back()->with('success', 'Status pesan diperbarui.');
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Pesan dihapus.');
    }
}
