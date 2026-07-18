<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
     //Store a new message submitted from the Home Page contact form.
    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        ContactMessage::create($request->validated());
        return back()
            ->with('contact_status', 'Thank you! Your message has been sent — we will get back to you soon.')
            ->withFragment('contact');
    }
}
