<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:newsletters,email',
            'name'  => 'nullable|string|max:255',
        ]);

        Newsletter::create([
            'email'      => $validated['email'],
            'name'       => $validated['name'] ?? null,
            'ip_address' => $request->ip(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Terima kasih! Anda telah berlangganan newsletter kami.']);
        }

        return redirect()->back()->with('newsletter_success', 'Terima kasih! Anda telah berlangganan newsletter kami.');
    }
}
