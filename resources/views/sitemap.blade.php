<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>

    @foreach([
        ['url' => route('about'), 'freq' => 'monthly', 'priority' => '0.8'],
        ['url' => route('contact'), 'freq' => 'monthly', 'priority' => '0.8'],
        ['url' => route('privacy'), 'freq' => 'monthly', 'priority' => '0.5'],
        ['url' => route('services.index'), 'freq' => 'weekly', 'priority' => '0.9'],
        ['url' => route('portfolio.index'), 'freq' => 'weekly', 'priority' => '0.9'],
        ['url' => route('blog.index'), 'freq' => 'daily', 'priority' => '0.8'],
    ] as $page)
    <url>
        <loc>{{ $page['url'] }}</loc>
        <changefreq>{{ $page['freq'] }}</changefreq>
        <priority>{{ $page['priority'] }}</priority>
    </url>
    @endforeach

    @foreach($services as $service)
    <url>
        <loc>{{ route('services.show', $service->slug) }}</loc>
        <lastmod>{{ optional($service->updated_at)?->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    @foreach($portfolios as $portfolio)
    <url>
        <loc>{{ route('portfolio.show', $portfolio->slug) }}</loc>
        <lastmod>{{ optional($portfolio->updated_at)?->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    @foreach($posts as $post)
    <url>
        <loc>{{ route('blog.show', $post->slug) }}</loc>
        <lastmod>{{ optional($post->updated_at)?->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach
</urlset>
