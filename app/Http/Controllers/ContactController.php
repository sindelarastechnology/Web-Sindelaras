<?php

namespace App\Http\Controllers;

use App\Mail\ContactConfirmationMail;
use App\Mail\NewContactMail;
use App\Models\Contact;
use App\Models\Service;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Hubungi Kami — ' . app('settings')->site_name);
        $services = Service::active()->orderBy('sort_order')->get(['id', 'title']);
        return view('contact.index', compact('services'));
    }

    public function store(Request $request)
    {
        if ($request->filled('website')) {
            return redirect()->back()->with('success', 'Terima kasih!');
        }

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'nullable|string|max:20',
            'company'    => 'nullable|string|max:255',
            'service_id' => 'nullable|exists:services,id',
            'subject'    => 'required|string|max:255',
            'message'    => 'required|string|min:10',
            'budget'     => 'nullable|string|max:255',
            'timeline'   => 'nullable|string|max:255',
        ]);

        $contact = Contact::create([
            ...$validated,
            'status'     => 'new',
            'source'     => 'contact_form',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referrer'   => $request->headers->get('referer'),
        ]);

        $settings = app('settings');

        try {
            if ($settings->email) {
                Mail::to($settings->email)->send(new NewContactMail($contact));
            }
            Mail::to($contact->email)->send(new ContactConfirmationMail($contact));
        } catch (\Exception $e) {
            \Log::error('Mail error: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.');
    }
}
