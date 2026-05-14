<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Service;
use App\Models\Slider;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $settings = app('settings');

        SEOMeta::setTitle($settings->meta_title ?? $settings->site_name);
        SEOMeta::setDescription($settings->meta_description ?? $settings->site_description);
        OpenGraph::setTitle($settings->meta_title ?? $settings->site_name);
        OpenGraph::setDescription($settings->meta_description);
        if ($settings->og_image) {
            OpenGraph::addImage(Storage::url($settings->og_image));
        }

        $data = [
            'sliders'      => Slider::where('is_active', true)->orderBy('sort_order')->get(),
            'achievements' => Achievement::where('is_active', true)->orderBy('sort_order')->get(),
            'services'     => Service::where('is_active', true)->where('is_featured', true)->orderBy('sort_order')->take(6)->get(),
            'portfolios'   => Portfolio::where('is_active', true)->where('is_featured', true)->orderBy('sort_order')->take(6)->get(),
            'testimonials' => Testimonial::where('is_active', true)->orderBy('sort_order')->get(),
            'latestPosts'  => Post::published()->with('category')->latest('published_at')->take(3)->get(),
            'teamMembers'  => TeamMember::where('is_active', true)->orderBy('sort_order')->get(),
        ];

        return view('home.index', $data);
    }
}
