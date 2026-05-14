<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Service;

class SitemapController extends Controller
{
    public function index()
    {
        $posts      = Post::published()->latest('published_at')->get(['slug', 'updated_at']);
        $services   = Service::where('is_active', true)->get(['slug', 'updated_at']);
        $portfolios = Portfolio::where('is_active', true)->get(['slug', 'updated_at']);

        return response()->view('sitemap', compact('posts', 'services', 'portfolios'))
            ->header('Content-Type', 'text/xml');
    }
}
