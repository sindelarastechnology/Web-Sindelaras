<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\PageContent;
use App\Models\TeamMember;
use Artesaos\SEOTools\Facades\SEOMeta;

class PageController extends Controller
{
    public function about()
    {
        $page        = PageContent::get('about');
        $teamMembers = TeamMember::where('is_active', true)->orderBy('sort_order')->get();
        $achievements = Achievement::where('is_active', true)->orderBy('sort_order')->get();

        SEOMeta::setTitle($page?->meta_title ?? 'Tentang Kami — ' . app('settings')->site_name);
        SEOMeta::setDescription($page?->meta_description ?? app('settings')->site_description);

        return view('about.index', compact('page', 'teamMembers', 'achievements'));
    }

    public function privacy()
    {
        $page = PageContent::get('privacy');

        SEOMeta::setTitle($page?->meta_title ?? 'Kebijakan Privasi — ' . app('settings')->site_name);

        return view('pages.privacy-policy', compact('page'));
    }
}
