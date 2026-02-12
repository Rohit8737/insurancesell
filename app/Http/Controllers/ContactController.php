<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    /**
     * Store a contact message
     */
    public function store(Request $request)
    {
        // Rate limiting: 3 submissions per IP per hour
        $key = 'contact_' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->with('error', 'Too many submissions. Please try again in an hour.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);
        
        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
        ]);
        
        RateLimiter::hit($key, 3600); // 1 hour
        
        return back()->with('success', 'Thank you! Your message has been sent successfully.');
    }
}
