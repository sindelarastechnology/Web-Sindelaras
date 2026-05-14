@extends('layouts.app')
@section('content')

<section class="gradient-primary section-padding pt-32">
    <div class="container-custom text-center">
        <x-section-header
            tag="🏢 Tentang Kami"
            title="{{ $page?->title ?? 'Mengenal <span class=\'text-gradient\'>Sindelaras Technology</span>' }}"
            subtitle="{{ $page?->subtitle ?? 'Your IT and Business Solution — Mitra digital terpercaya untuk bisnis Anda.' }}"
            :light="true"
        />
    </div>
</section>

@if($page?->content)
    <section class="section-padding bg-white dark:bg-dark-base">
        <div class="container-custom max-w-4xl">
            <div class="prose-custom">
                {!! $page->content !!}
            </div>
        </div>
    </section>
@endif

@if($teamMembers->count() > 0)
    <section class="section-padding bg-slate-50 dark:bg-[#0a0f1e]">
        <div class="container-custom">
            <x-section-header
                tag="👥 Tim Kami"
                title="Orang-orang di Balik <span class='text-gradient'>Sindelaras</span>"
                subtitle="Tim profesional yang berpengalaman dan berdedikasi untuk kesuksesan proyek Anda."
            />
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mt-12" data-aos-stagger="80">
                @foreach($teamMembers as $member)
                    <div class="card p-6 text-center group hover:shadow-xl transition-shadow" data-aos="fade-up">
                        <img src="{{ $member->photo_url }}"
                             alt="{{ $member->name }}" loading="lazy" decoding="async"
                             class="w-24 h-24 rounded-full object-cover mx-auto mb-4 ring-4 ring-primary-100 dark:ring-primary-900 group-hover:ring-primary-400 transition-all">
                        <h3 class="font-display font-bold text-slate-900 dark:text-white">{{ $member->name }}</h3>
                        <p class="text-sm text-primary-600 dark:text-primary-400 mb-3">{{ $member->position }}</p>
                        @if($member->bio)
                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-3">{{ $member->bio }}</p>
                        @endif
                        <div class="flex justify-center gap-3 mt-4">
                            @if($member->instagram)
                                <a href="https://instagram.com/{{ ltrim($member->instagram, '@') }}" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-pink-500 transition-colors text-lg">📸</a>
                            @endif
                            @if($member->linkedin)
                                <a href="{{ $member->linkedin }}" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-blue-600 transition-colors text-lg">💼</a>
                            @endif
                            @if($member->github)
                                <a href="{{ $member->github }}" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-slate-700 dark:hover:text-white transition-colors text-lg">🐙</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

@if($achievements->count() > 0)
    <section class="section-padding gradient-primary">
        <div class="container-custom">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                @foreach($achievements as $achievement)
                    <div data-aos="fade-up">
                        <div class="text-4xl mb-3">{{ $achievement->icon }}</div>
                        <div class="font-display font-bold text-4xl text-white mb-1">{{ $achievement->value }}</div>
                        <p class="text-primary-200 text-sm font-medium">{{ $achievement->label }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<section class="gradient-cta py-16 overflow-hidden relative">
    <div class="absolute inset-0 bg-grid-pattern opacity-20"></div>
    <div class="container-custom text-center relative z-10" data-aos="zoom-in">
        <h2 class="font-display text-3xl font-bold text-white mb-4">Mari Bekerja Sama dengan Kami</h2>
        <p class="text-white/80 mb-8">Tidak ada proyek yang terlalu kecil atau terlalu besar. Hubungi kami sekarang!</p>
        <a href="{{ whatsappLink(site_whatsapp(), 'Halo, saya ingin konsultasi setelah melihat profil perusahaan') }}"
           target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 bg-white text-accent-600 hover:bg-slate-100 font-semibold px-6 py-3 rounded-full transition-all hover:shadow-lg hover:scale-105">
            💬 Chat WhatsApp Sekarang
        </a>
    </div>
</section>

@endsection
