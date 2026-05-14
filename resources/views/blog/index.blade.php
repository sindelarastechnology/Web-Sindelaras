@extends('layouts.app')
@section('content')

<section class="gradient-primary section-padding pt-32">
    <div class="container-custom text-center">
        <x-section-header
            tag="📝 Blog & Artikel"
            title="Insight Teknologi & <span class='text-gradient'>Bisnis Digital</span>"
            subtitle="Tips, panduan, dan wawasan seputar dunia IT untuk membantu bisnis Anda berkembang."
            :light="true"
        />
    </div>
</section>

<section class="section-padding bg-slate-50 dark:bg-[#0a0f1e]">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
            <div class="lg:col-span-3">
                @if(isset($category))
                    <p class="text-sm text-slate-500 mb-6">Menampilkan artikel dalam kategori: <strong class="text-primary-600">{{ $category->name }}</strong></p>
                @endif
                @if(isset($tag))
                    <p class="text-sm text-slate-500 mb-6">Menampilkan artikel dengan tag: <strong class="text-primary-600">{{ $tag->name }}</strong></p>
                @endif
                @if(isset($query))
                    <p class="text-sm text-slate-500 mb-6">Hasil pencarian untuk: <strong class="text-primary-600">"{{ $query }}"</strong></p>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6" data-aos-stagger="100">
                    @forelse($posts as $post)
                        <x-post-card :post="$post" />
                    @empty
                        <p class="md:col-span-2 text-center text-slate-500 py-12">Belum ada artikel.</p>
                    @endforelse
                </div>

                <div class="mt-10">
                    {!! $posts->links() !!}
                </div>
            </div>

            <div class="space-y-6" data-aos="fade-up" data-aos-delay="150">
                @if($categories->count() > 0)
                    <div class="card p-6">
                        <h4 class="font-display font-bold text-slate-900 dark:text-white mb-4">📂 Kategori</h4>
                        <ul class="space-y-2">
                            @foreach($categories as $cat)
                                <li>
                                    <a href="{{ route('blog.category', $cat->slug) }}"
                                       class="flex items-center justify-between text-sm text-slate-600 dark:text-slate-300 hover:text-primary-600 transition-colors py-1">
                                        {{ $cat->name }}
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-100 dark:bg-dark-border text-slate-500">{{ $cat->posts_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($tags->count() > 0)
                    <div class="card p-6">
                        <h4 class="font-display font-bold text-slate-900 dark:text-white mb-4">🏷️ Tags</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <a href="{{ route('blog.tag', $tag->slug) }}"
                                   class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900/40 text-primary-700 dark:text-primary-300 hover:bg-primary-200 transition-colors">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="gradient-cta py-16 overflow-hidden relative">
    <div class="absolute inset-0 bg-grid-pattern opacity-20"></div>
    <div class="container-custom text-center relative z-10" data-aos="zoom-in">
        <h2 class="font-display text-3xl font-bold text-white mb-4">Butuh bantuan untuk proyek digital Anda?</h2>
        <p class="text-white/80 mb-8">Tim ahli kami siap membantu mewujudkan ide Anda menjadi kenyataan.</p>
        <a href="{{ whatsappLink(site_whatsapp(), 'Halo, saya ingin konsultasi setelah membaca blog') }}"
           target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 bg-white text-accent-600 hover:bg-slate-100 font-semibold px-6 py-3 rounded-full transition-all hover:shadow-lg hover:scale-105">
            💬 Chat WhatsApp Sekarang
        </a>
    </div>
</section>

@endsection
