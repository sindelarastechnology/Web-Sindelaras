@extends('layouts.app')
@section('content')

<section class="gradient-primary pt-32 pb-20">
    <div class="container-custom">
        <x-breadcrumb :items="[
            ['label' => 'Portfolio', 'url' => route('portfolio.index')],
            ['label' => $portfolio->title],
        ]" />
        <div class="flex flex-wrap items-center gap-3 mb-4">
            <a href="{{ route('portfolio.index') }}" class="text-slate-400 hover:text-white text-sm transition-colors">
                ← Kembali ke Portfolio
            </a>
            @if($portfolio->category)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-700/50 text-primary-200">{{ $portfolio->category->name }}</span>
            @endif
        </div>
        <h1 class="font-display text-4xl md:text-5xl font-bold text-white mb-3" data-aos="fade-up">
            {{ $portfolio->title }}
        </h1>
        @if($portfolio->client_name)
            <p class="text-slate-300" data-aos="fade-up" data-aos-delay="100">
                Klien: <strong class="text-white">{{ $portfolio->client_name }}</strong>
            </p>
        @endif
    </div>
</section>

<section class="section-padding bg-white dark:bg-dark-base">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2">
                <img src="{{ $portfolio->thumbnail_url }}"
                     alt="{{ $portfolio->title }}" loading="lazy" decoding="async"
                     class="w-full rounded-2xl shadow-lg mb-8">

                @if(count($portfolio->gallery_urls) > 0)
                    @php $galleryJson = json_encode($portfolio->gallery_urls); @endphp
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-8"
                         x-data="{ lightbox: null, images: {{ $galleryJson }} }">
                        @foreach($portfolio->gallery_urls as $i => $img)
                            <button @click="lightbox = {{ $i }}"
                                    class="block overflow-hidden rounded-xl aspect-video hover:opacity-90 hover:scale-105 transition-all duration-300 group relative"
                                    data-aos="zoom-in" data-aos-delay="{{ $i * 80 }}">
                                <img src="{{ $img }}" alt="Gallery image {{ $i + 1 }}" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </div>
                            </button>
                        @endforeach
                        <template x-teleport="body">
                            <div x-show="lightbox !== null"
                                 class="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center p-4"
                                 @keydown.escape="lightbox = null"
                                 x-transition.opacity>
                                <button @click="lightbox = null" aria-label="Tutup" class="absolute top-4 right-4 text-white/60 hover:text-white text-4xl z-10">&times;</button>
                                <button @click="lightbox = lightbox > 0 ? lightbox - 1 : images.length - 1" aria-label="Sebelumnya"
                                        class="absolute left-4 top-1/2 -translate-y-1/2 text-white/60 hover:text-white text-5xl z-10">&lsaquo;</button>
                                <img :src="images[lightbox]" alt="Gallery"
                                     class="max-w-full max-h-[85vh] rounded-xl shadow-2xl object-contain">
                                <button @click="lightbox = lightbox < images.length - 1 ? lightbox + 1 : 0" aria-label="Selanjutnya"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-white/60 hover:text-white text-5xl z-10">&rsaquo;</button>
                                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-black/60 text-white/80 text-sm px-4 py-1.5 rounded-full">
                                    <span x-text="(lightbox ?? 0) + 1"></span> / <span x-text="images.length"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                @endif

                <div class="prose-custom">
                    {!! $portfolio->description !!}
                </div>

                {{-- AdSense Banner -- ganti slot dengan ID unit iklan dari dashboard AdSense --}}
                <x-ad-banner slot="" format="auto" />
            </div>

            <div class="space-y-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card p-6">
                    <h4 class="font-display font-bold text-lg text-slate-900 dark:text-white mb-4">📋 Info Proyek</h4>
                    <ul class="space-y-3 text-sm">
                        @if($portfolio->client_name)
                            <li class="flex gap-3"><span class="text-slate-400 w-20">Klien</span><span class="font-medium text-slate-800 dark:text-slate-200">{{ $portfolio->client_name }}</span></li>
                        @endif
                        @if($portfolio->project_duration)
                            <li class="flex gap-3"><span class="text-slate-400 w-20">Durasi</span><span class="font-medium text-slate-800 dark:text-slate-200">{{ $portfolio->project_duration }}</span></li>
                        @endif
                        @if($portfolio->category)
                            <li class="flex gap-3"><span class="text-slate-400 w-20">Kategori</span><span class="font-medium text-slate-800 dark:text-slate-200">{{ $portfolio->category->name }}</span></li>
                        @endif
                        @if($portfolio->live_url)
                            <li class="flex gap-3"><span class="text-slate-400 w-20">URL</span>
                                <a href="{{ $portfolio->live_url }}" target="_blank" rel="noopener noreferrer" class="text-primary-600 dark:text-primary-400 hover:underline truncate">Kunjungi →</a>
                            </li>
                        @endif
                        @if($portfolio->project_date)
                            <li class="flex gap-3"><span class="text-slate-400 w-20">Tahun</span><span class="font-medium text-slate-800 dark:text-slate-200">{{ $portfolio->project_date->format('Y') }}</span></li>
                        @endif
                    </ul>
                </div>

                @if($portfolio->technologies)
                    <div class="card p-6">
                        <h4 class="font-display font-bold text-slate-900 dark:text-white mb-4">🛠️ Teknologi</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($portfolio->technologies as $tech)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900/40 text-primary-700 dark:text-primary-300">
                                    {{ is_string($tech) ? $tech : ($tech['tech'] ?? '') }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="card p-6 bg-primary-800 border-primary-700">
                    <p class="text-primary-200 text-sm mb-3">Tertarik dengan proyek serupa?</p>
                    <a href="{{ whatsappLink(site_whatsapp(), 'Halo, saya tertarik dengan proyek ' . $portfolio->title) }}"
                       target="_blank" rel="noopener noreferrer" class="btn-primary w-full justify-center">
                        💬 Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
