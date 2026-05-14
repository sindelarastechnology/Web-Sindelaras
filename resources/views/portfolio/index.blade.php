@extends('layouts.app')
@section('content')

<section class="gradient-primary section-padding pt-32">
    <div class="container-custom text-center">
        <x-section-header
            tag="🖥️ Portfolio"
            title="Karya Terbaik <span class='text-gradient'>Kami</span>"
            subtitle="Setiap proyek adalah bukti komitmen kami terhadap kualitas dan kepuasan klien."
            :light="true"
        />
    </div>
</section>

<section class="section-padding bg-slate-50 dark:bg-[#0a0f1e]">
        <div class="container-custom"
         x-data="{ activeFilter: @js($selectedCategory?->slug ?? 'all') }">
        @if($categories->count() > 0)
            <div class="flex flex-wrap justify-center gap-3 mb-10" data-aos="fade-up">
                <button @click="activeFilter = 'all'"
                        :class="activeFilter === 'all' ? 'filter-btn active' : 'filter-btn'">
                    Semua
                </button>
                @foreach($categories as $cat)
                    <button @click="activeFilter = @js($cat->slug)"
                            :class="activeFilter === @js($cat->slug) ? 'filter-btn active' : 'filter-btn'">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>
        @endif

        <p x-show="activeFilter !== 'all'" class="text-sm text-slate-500 mb-6 text-center animate-fade-in-up">
            Menampilkan portfolio kategori: <strong class="text-primary-600" x-text="activeFilter"></strong>
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" data-aos-stagger="100">
            @forelse($portfolios as $portfolio)
                <div x-show="activeFilter === 'all' || activeFilter === @js($portfolio->category?->slug ?? 'uncategorized')"
                     x-transition:enter="transition-all duration-300"
                     x-cloak>
                    <x-portfolio-card :portfolio="$portfolio" />
                </div>
            @empty
                <p class="lg:col-span-3 text-center text-slate-500 py-12">Belum ada portfolio tersedia.</p>
            @endforelse
        </div>

        <div class="mt-10">
            {!! $portfolios->links() !!}
        </div>
    </div>
</section>

<section class="gradient-cta py-16 overflow-hidden relative">
    <div class="absolute inset-0 bg-grid-pattern opacity-20"></div>
    <div class="container-custom text-center relative z-10" data-aos="zoom-in">
        <h2 class="font-display text-3xl font-bold text-white mb-4">Tertarik dengan layanan kami?</h2>
        <p class="text-white/80 mb-8">Dapatkan solusi digital terbaik untuk bisnis Anda. Konsultasi GRATIS!</p>
        <a href="{{ whatsappLink(site_whatsapp(), 'Halo, saya tertarik dengan portfolio dan ingin konsultasi') }}"
           target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 bg-white text-accent-600 hover:bg-slate-100 font-semibold px-6 py-3 rounded-full transition-all hover:shadow-lg hover:scale-105">
            💬 Chat WhatsApp Sekarang
        </a>
    </div>
</section>

@endsection
