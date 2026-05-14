@extends('layouts.app')
@section('content')

<section class="gradient-primary pt-32 pb-20">
    <div class="container-custom max-w-3xl">
        <x-breadcrumb :items="[
            ['label' => 'Blog', 'url' => route('blog.index')],
            ['label' => $post->title],
        ]" />
        @if($post->category)
            <a href="{{ route('blog.category', $post->category->slug) }}"
               class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-700/50 text-primary-200 mb-4 inline-block hover:bg-primary-700 transition-colors">
                {{ $post->category->name }}
            </a>
        @endif
        <h1 class="font-display text-3xl md:text-5xl font-bold text-white leading-tight mb-4" data-aos="fade-up">
            {{ $post->title }}
        </h1>
        <div class="flex flex-wrap items-center gap-4 text-slate-400 text-sm" data-aos="fade-up" data-aos-delay="100">
            <span>{{ $post->published_at?->format('d F Y') }}</span>
            <span>•</span>
            <span>{{ $post->reading_time }}</span>
            <span>•</span>
            <span>👁 {{ number_format($post->views) }} kali dibaca</span>
        </div>
    </div>
</section>

<section class="section-padding bg-white dark:bg-dark-base">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
            <article class="lg:col-span-3">
                @if($post->featured_image)
<img src="{{ Storage::url($post->featured_image) }}"
                     alt="{{ $post->featured_image_alt ?: $post->title }}" loading="lazy" decoding="async"
                     class="w-full rounded-2xl shadow-lg mb-10">
                @endif

                <div class="prose-custom">
                    {!! $post->content !!}
                </div>

                @if($post->tags->count() > 0)
                    <div class="mt-8 pt-8 border-t border-slate-200 dark:border-dark-border flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <a href="{{ route('blog.tag', $tag->slug) }}"
                               class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900/40 text-primary-700 dark:text-primary-300 hover:bg-primary-200">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <x-social-share url="{{ url()->current() }}" title="{{ $post->title }}" />
            </article>

            <div class="space-y-6" data-aos="fade-up" data-aos-delay="100">
                @if($relatedPosts->count() > 0)
                    <div class="card p-6">
                        <h4 class="font-display font-bold text-slate-900 dark:text-white mb-4">📖 Artikel Terkait</h4>
                        <div class="space-y-4">
                            @foreach($relatedPosts as $related)
                                <a href="{{ route('blog.show', $related->slug) }}"
                                   class="flex gap-3 group">
                                    @if($related->featured_image)
<img src="{{ Storage::url($related->featured_image) }}" alt="{{ $related->title }}" loading="lazy" decoding="async"
                                               class="w-16 h-16 rounded-xl object-cover flex-shrink-0">
                                    @endif
                                    <div>
                                        <p class="text-sm font-medium text-slate-800 dark:text-slate-200 line-clamp-2 group-hover:text-primary-600 transition-colors">
                                            {{ $related->title }}
                                        </p>
                                        <p class="text-xs text-slate-400 mt-1">{{ $related->published_at?->format('d M Y') }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="card p-6 bg-primary-800 border-primary-700">
                    <p class="font-display font-bold text-white mb-2">Butuh Bantuan?</p>
                    <p class="text-primary-200 text-sm mb-4">Tim kami siap membantu mewujudkan proyek digital Anda.</p>
                    <a href="{{ whatsappLink(site_whatsapp(), 'Halo, saya ingin konsultasi') }}"
                       target="_blank" rel="noopener noreferrer" class="btn-primary w-full justify-center text-sm">
                        💬 Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
