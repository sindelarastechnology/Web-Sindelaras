<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Artesaos\SEOTools\Facades\SEOMeta;

class ServiceController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Layanan Kami — ' . app('settings')->site_name);
        SEOMeta::setDescription('Kami menyediakan berbagai layanan IT profesional.');

        $services = Service::where('is_active', true)
            ->with('category', 'faqs')
            ->orderBy('sort_order')
            ->get();

        return view('services.index', compact('services'));
    }

    public function show(string $slug)
    {
        $service = Service::where('slug', $slug)
            ->where('is_active', true)
            ->with(['faqs', 'category', 'activePackages', 'testimonials' => fn ($q) => $q->where('is_active', true)])
            ->firstOrFail();

        SEOMeta::setTitle(($service->meta_title ?? $service->title) . ' — ' . app('settings')->site_name);
        SEOMeta::setDescription($service->meta_description ?? $service->short_description);

        $relatedServices = Service::where('is_active', true)
            ->where('id', '!=', $service->id)
            ->where(fn ($q) => $service->category_id ? $q->where('category_id', $service->category_id) : $q)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('services.show', compact('service', 'relatedServices'));
    }
}
