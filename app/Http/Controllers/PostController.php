<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Blog — ' . app('settings')->site_name);
        SEOMeta::setDescription('Artikel & tips seputar teknologi digital dan bisnis.');

        $posts      = Post::published()->with('category', 'tags')->latest('published_at')->paginate(9);
        $categories = Category::where('type', 'post')->where('is_active', true)
            ->withCount(['posts' => fn ($q) => $q->published()])->get();
        $tags       = Tag::withCount('posts')->get();

        return view('blog.index', compact('posts', 'categories', 'tags'));
    }

    public function show(string $slug)
    {
        $post = Post::published()->where('slug', $slug)->with('category', 'tags', 'author')->firstOrFail();

        $post->increment('views');

        SEOMeta::setTitle(($post->meta_title ?? $post->title) . ' — ' . app('settings')->site_name);
        SEOMeta::setDescription($post->meta_description ?? $post->excerpt);

        $relatedPosts = Post::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    public function byCategory(string $slug)
    {
        $category = Category::where('slug', $slug)->where('type', 'post')->firstOrFail();
        SEOMeta::setTitle('Kategori: ' . $category->name . ' — ' . app('settings')->site_name);

        $posts      = Post::published()->where('category_id', $category->id)->with('category', 'tags')->latest('published_at')->paginate(9);
        $categories = Category::where('type', 'post')->where('is_active', true)->get();
        $tags       = Tag::withCount('posts')->get();

        return view('blog.index', compact('posts', 'categories', 'tags', 'category'));
    }

    public function byTag(string $slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        SEOMeta::setTitle('Tag: ' . $tag->name . ' — ' . app('settings')->site_name);

        $posts = $tag->posts()->published()->with('category', 'tags')->latest('published_at')->paginate(9);
        $categories = Category::where('type', 'post')->where('is_active', true)->get();
        $tags = Tag::withCount('posts')->get();

        return view('blog.index', compact('posts', 'categories', 'tags', 'tag'));
    }

    public function search(Request $request)
    {
        $request->validate(['q' => 'required|string|min:2']);
        $query = $request->input('q');

        $postQuery = Post::published()
            ->where(function ($q) use ($query) {
                $escaped = str_replace(['%', '_'], ['\\%', '\\_'], $query);
                $q->where('title', 'like', "%{$escaped}%")
                  ->orWhere('content', 'like', "%{$escaped}%")
                  ->orWhere('excerpt', 'like', "%{$escaped}%");
            })
            ->with('category', 'tags')
            ->latest('published_at');

        if ($request->has('ajax') || $request->ajax() || $request->wantsJson()) {
            $results = $postQuery->take(5)->get(['id', 'title', 'slug', 'published_at'])->map(fn ($p) => [
                'id'    => $p->id,
                'title' => $p->title,
                'url'   => route('blog.show', $p->slug),
                'date'  => $p->published_at?->format('d M Y'),
            ]);
            return response()->json($results);
        }

        SEOMeta::setTitle('Pencarian: ' . $query . ' — ' . app('settings')->site_name);

        $posts = $postQuery->paginate(9);

        $categories = Category::where('type', 'post')->where('is_active', true)
            ->withCount(['posts' => fn ($q) => $q->published()])->get();
        $tags = Tag::withCount('posts')->get();

        return view('blog.index', compact('posts', 'categories', 'tags', 'query'));
    }
}
