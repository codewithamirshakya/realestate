<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('contact.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $inquiry = Inquiry::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        Mail::to(config('company.email'))->send(new ContactMessageMail($inquiry));

        return back()->with('status', 'Thanks for reaching out! We will get back to you soon.');
    }
}
