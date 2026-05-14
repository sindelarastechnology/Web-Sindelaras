<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Portfolio;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        SEOMeta::setTitle('Portfolio — ' . app('settings')->site_name);
        SEOMeta::setDescription('Lihat karya dan proyek yang telah kami selesaikan untuk berbagai klien.');

        $query = Portfolio::active()->with('category');

        $selectedCategory = null;
        if ($request->filled('kategori')) {
            $selectedCategory = Category::where('slug', $request->kategori)
                ->where('type', 'portfolio')
                ->first();
            if ($selectedCategory) {
                $query->where('category_id', $selectedCategory->id);
                SEOMeta::setTitle($selectedCategory->name . ' — Portfolio — ' . app('settings')->site_name);
            }
        }

        $portfolios = $query->orderBy('sort_order')->paginate(12);
        $categories = Category::where('type', 'portfolio')->where('is_active', true)->get();

        return view('portfolio.index', compact('portfolios', 'categories', 'selectedCategory'));
    }

    public function show(string $slug)
    {
        $portfolio = Portfolio::active()
            ->where('slug', $slug)
            ->with(['category', 'tags', 'testimonials' => fn ($q) => $q->where('is_active', true)])
            ->firstOrFail();

        $portfolio->increment('views');

        SEOMeta::setTitle(($portfolio->meta_title ?? $portfolio->title) . ' — ' . app('settings')->site_name);
        SEOMeta::setDescription($portfolio->meta_description ?? $portfolio->short_description);

        return view('portfolio.show', compact('portfolio'));
    }
}
