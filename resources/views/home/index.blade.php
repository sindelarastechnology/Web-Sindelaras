@extends('layouts.app')
@section('content')

    {{-- 1. Hero Slider --}}
    <section class="hero-section relative gradient-primary min-h-screen flex items-center pt-20 overflow-hidden">
        <div class="bg-grid-pattern absolute inset-0 opacity-30"></div>

        {{-- Floating blobs --}}
        <div class="absolute inset-0 -inset-x-0 overflow-hidden pointer-events-none" aria-hidden="true">
            <div
                class="hero-blob absolute -top-24 -left-24 w-64 h-64 bg-primary-500/10 rounded-full blur-3xl animate-blob-slow">
            </div>
            <div class="hero-blob absolute top-1/3 -right-24 w-64 h-64 bg-accent-500/10 rounded-full blur-3xl animate-blob"
                style="animation-delay: -4s;"></div>
            <div class="hero-blob absolute -bottom-20 left-1/4 w-56 h-56 bg-blue-400/10 rounded-full blur-3xl animate-blob-slow"
                style="animation-delay: -8s;"></div>
        </div>

        <div class="container-custom relative z-10">
            <div class="swiper hero-swiper">
                <div class="swiper-wrapper">
                    @forelse($sliders as $slider)
                        <div class="swiper-slide">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center min-h-[70vh]">
                                <div data-aos="fade-right" data-aos-duration="1000">
                                    @if ($slider->subtitle)
                                        <span
                                            class="font-accent text-accent-400 font-medium text-sm uppercase tracking-widest mb-4 block animate-fade-in-up">{{ $slider->subtitle }}</span>
                                    @endif
                                    <h1
                                        class="hero-title-animate font-display text-4xl md:text-6xl font-bold text-white leading-tight mb-6">
                                        {{ $slider->title ?? $settings->hero_title }}
                                    </h1>
                                    <p class="text-lg text-slate-300 mb-8 max-w-xl animate-fade-in-up delay-200">
                                        {{ $slider->description ?? $settings->hero_description }}
                                    </p>
                                    <div class="flex flex-wrap gap-4 animate-fade-in-up delay-500">
                                        @if ($slider->button_text ?? $settings->hero_cta_text)
                                            <a href="{{ $slider->button_link ?? ($settings->hero_cta_link ?? route('contact')) }}"
                                                class="btn-primary animate-pulse-ring">
                                                {{ $slider->button_text ?? $settings->hero_cta_text }}
                                            </a>
                                        @endif
                                        @if ($slider->button_text_2)
                                            <a href="{{ $slider->button_link_2 ?? route('portfolio.index') }}"
                                                class="btn-outline">
                                                {{ $slider->button_text_2 }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200"
                                    class="hidden lg:flex justify-center">
                                    @if ($slider->image)
                                        <img src="{{ Storage::url($slider->image) }}" alt="{{ $slider->title }}"
                                            loading="lazy" class="max-w-md drop-shadow-2xl animate-float">
                                    @else
                                        <div
                                            class="w-96 h-96 rounded-2xl bg-primary-800/40 flex items-center justify-center animate-float">
                                            <span class="text-8xl">🚀</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center min-h-[70vh]">
                                <div data-aos="fade-right" data-aos-duration="1000">
                                    <span
                                        class="font-accent text-accent-400 font-medium text-sm uppercase tracking-widest mb-4 block animate-fade-in-up">{{ $settings->hero_subtitle ?? 'Sindelaras Technology' }}</span>
                                    <h1
                                        class="hero-title-animate font-display text-4xl md:text-6xl font-bold text-white leading-tight mb-6">
                                        {{ $settings->hero_title ?? 'Solusi Digital untuk Bisnis Anda' }}
                                    </h1>
                                    <p class="text-lg text-slate-300 mb-8 max-w-xl animate-fade-in-up delay-200">
                                        {{ $settings->hero_description ?? 'Kami hadir dengan solusi aplikasi yang inovatif, aman, dan sesuai kebutuhan bisnis Anda.' }}
                                    </p>
                                    <div class="flex flex-wrap gap-4 animate-fade-in-up delay-500">
                                        <a href="{{ $settings->hero_cta_link ?? route('contact') }}"
                                            class="btn-primary animate-pulse-ring">
                                            {{ $settings->hero_cta_text ?? 'Konsultasi Sekarang' }}
                                        </a>
                                        <a href="{{ route('portfolio.index') }}" class="btn-outline">Lihat Portfolio</a>
                                    </div>
                                </div>
                                <div data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200"
                                    class="hidden lg:flex justify-center">
                                    @if ($settings->hero_image)
                                        <img src="{{ Storage::url($settings->hero_image) }}" alt="" loading="lazy"
                                            class="max-w-md drop-shadow-2xl animate-float">
                                    @else
                                        <div
                                            class="w-96 h-96 rounded-2xl bg-primary-800/40 flex items-center justify-center animate-float">
                                            <span class="text-8xl">🚀</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="swiper-pagination !bottom-8"></div>
            </div>
        </div>
    </section>

    {{-- 2. Stats / Achievement --}}
    @if ($achievements->count() > 0)
        <section class="py-16 bg-primary-900">
            <div class="container-custom">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    @foreach ($achievements as $achievement)
                        <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="text-4xl mb-3">{{ $achievement->icon }}</div>
                            <div class="font-display font-bold text-4xl text-white mb-1" data-counter
                                data-target="{{ preg_replace('/[^0-9]/', '', $achievement->value) }}"
                                data-suffix="{{ preg_replace('/[0-9]/', '', $achievement->value) }}">
                                {{ $achievement->value }}
                            </div>
                            <p class="text-primary-200 text-sm font-medium">{{ $achievement->label }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- 3. Layanan Kami --}}
    @if ($services->count() > 0)
        <section id="services" class="section-padding bg-slate-50 dark:bg-[#0a0f1e]">
            <div class="container-custom">
                <x-section-header tag="💼 Layanan Kami"
                    title="Solusi <span class='text-gradient'>Digital</span> untuk Bisnis Anda"
                    subtitle="Dari pembuatan website hingga aplikasi custom — kami siap membantu transformasi digital Anda." />
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-aos-stagger="100">
                    @foreach ($services as $service)
                        <x-service-card :service="$service" />
                    @endforeach
                </div>
                @if ($services->count() >= 6)
                    <div class="text-center mt-10" data-aos="fade-up">
                        <a href="{{ route('services.index') }}" class="btn-secondary">
                            Lihat Semua Layanan →
                        </a>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- AdSense Banner -- ganti slot dengan ID unit iklan dari dashboard AdSense --}}
    <x-ad-banner slot="" format="auto" />

    {{-- 4. Kenapa Memilih Kami --}}
    <section class="section-padding bg-white dark:bg-dark-base">
        <div class="container-custom">
            <x-section-header tag="✨ Kenapa Kami?"
                title="Mengapa Memilih <span class='text-gradient'>Sindelaras Technology?</span>"
                subtitle="Kami berkomitmen memberikan solusi terbaik untuk bisnis Anda." />
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
                @php
                    $reasons = [
                        [
                            'icon' => '👨‍💻',
                            'title' => 'Profesional',
                            'desc' => 'Tim berpengalaman di bidang teknologi informasi dan bisnis digital.',
                        ],
                        [
                            'icon' => '🎨',
                            'title' => 'Desain Modern',
                            'desc' => 'Tampilan website dan aplikasi yang elegan, responsif, dan user-friendly.',
                        ],
                        [
                            'icon' => '📈',
                            'title' => 'Optimasi SEO',
                            'desc' => 'Setiap website kami optimasi agar mudah ditemukan di mesin pencari.',
                        ],
                        [
                            'icon' => '🤝',
                            'title' => 'Support Terbaik',
                            'desc' => 'Kami mendampingi Anda dari konsultasi hingga setelah proyek selesai.',
                        ],
                        [
                            'icon' => '🔒',
                            'title' => 'Aman & Terpercaya',
                            'desc' => 'Keamanan data Anda adalah prioritas utama kami.',
                        ],
                        [
                            'icon' => '💰',
                            'title' => 'Harga Bersahabat',
                            'desc' => 'Solusi berkualitas dengan harga yang kompetitif dan transparan.',
                        ],
                    ];
                @endphp
                @foreach ($reasons as $index => $reason)
                    <div data-aos="fade-up" data-aos-delay="{{ $index * 80 }}"
                        class="flex gap-4 p-6 card hover:shadow-lg transition-shadow">
                        <div class="text-3xl flex-shrink-0 animate-float-slow"
                            style="animation-delay: {{ $index * 0.5 }}s">{{ $reason['icon'] }}</div>
                        <div>
                            <h4 class="font-display font-bold text-slate-900 dark:text-white mb-2">{{ $reason['title'] }}
                            </h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400">{{ $reason['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 5. Portfolio Terbaru --}}
    @if ($portfolios->count() > 0)
        <section id="portfolio" class="section-padding bg-slate-50 dark:bg-[#0a0f1e]">
            <div class="container-custom">
                <x-section-header tag="🖥️ Portfolio" title="Karya Terbaru <span class='text-gradient'>Kami</span>"
                    subtitle="Beberapa proyek yang telah kami selesaikan untuk klien kami." />
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" data-aos-stagger="100">
                    @foreach ($portfolios as $portfolio)
                        <x-portfolio-card :portfolio="$portfolio" />
                    @endforeach
                </div>
                <div class="text-center mt-10" data-aos="fade-up">
                    <a href="{{ route('portfolio.index') }}" class="btn-secondary">Lihat Semua Portfolio →</a>
                </div>
            </div>
        </section>
    @endif

    {{-- 6. Proses Kerja --}}
    <section class="section-padding bg-white dark:bg-dark-base">
        <div class="container-custom">
            <x-section-header tag="📋 Proses Kerja" title="Bagaimana <span class='text-gradient'>Kami Bekerja</span>"
                subtitle="Langkah-langkah sistematis untuk mewujudkan proyek digital Anda." />
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mt-12" data-aos-stagger="120">
                @php
                    $steps = [
                        [
                            'num' => '01',
                            'icon' => '💬',
                            'title' => 'Konsultasi',
                            'desc' => 'Diskusikan kebutuhan dan tujuan bisnis Anda.',
                        ],
                        [
                            'num' => '02',
                            'icon' => '📐',
                            'title' => 'Perancangan',
                            'desc' => 'Kami buatkan konsep, wireframe, dan mockup.',
                        ],
                        [
                            'num' => '03',
                            'icon' => '⚙️',
                            'title' => 'Development',
                            'desc' => 'Tim kami mulai membangun solusi Anda.',
                        ],
                        [
                            'num' => '04',
                            'icon' => '✅',
                            'title' => 'Testing',
                            'desc' => 'Pengujian ketat untuk memastikan kualitas.',
                        ],
                        [
                            'num' => '05',
                            'icon' => '🚀',
                            'title' => 'Launch & Support',
                            'desc' => 'Go live dan pendampingan penuh.',
                        ],
                    ];
                @endphp
                @foreach ($steps as $step)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 120 }}"
                        class="text-center p-6 card hover:shadow-lg transition-shadow group">
                        <div
                            class="w-14 h-14 rounded-full bg-primary-100 dark:bg-primary-900/40 flex items-center justify-center mx-auto mb-4 text-2xl group-hover:scale-110 transition-transform">
                            {{ $step['icon'] }}
                        </div>
                        <span class="text-xs font-bold text-primary-600 dark:text-primary-400">{{ $step['num'] }}</span>
                        <h4 class="font-display font-bold text-slate-900 dark:text-white mt-2 mb-2">{{ $step['title'] }}
                        </h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 7. Testimonial --}}
    @if ($testimonials->count() > 0)
        <section class="section-padding gradient-primary">
            <div class="container-custom">
                <x-section-header tag="💬 Testimonial" title="Apa Kata <span class='text-gradient'>Klien Kami</span>"
                    subtitle="Kepuasan klien adalah motivasi utama kami untuk terus berkembang." :light="true" />
                <div class="swiper testimonial-swiper mt-12" data-aos="fade-up">
                    <div class="swiper-wrapper">
                        @foreach ($testimonials as $testimonial)
                            <div class="swiper-slide">
                                <x-testimonial-card :testimonial="$testimonial" />
                            </div>
                        @endforeach
                    </div>
                    <div class="testimonial-pagination flex justify-center mt-8"></div>
                </div>
            </div>
        </section>
    @endif

    {{-- 8. Blog Terbaru --}}
    @if ($latestPosts->count() > 0)
        <section class="section-padding bg-slate-50 dark:bg-[#0a0f1e]">
            <div class="container-custom">
                <x-section-header tag="📝 Blog" title="Artikel & <span class='text-gradient'>Insight Terbaru</span>"
                    subtitle="Tips, panduan, dan wawasan seputar teknologi digital." />
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-aos-stagger="100">
                    @foreach ($latestPosts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>
                <div class="text-center mt-10" data-aos="fade-up">
                    <a href="{{ route('blog.index') }}" class="btn-secondary">Lihat Semua Artikel →</a>
                </div>
            </div>
        </section>
    @endif

    {{-- 9. CTA --}}
    <section class="gradient-cta py-20 overflow-hidden relative">
        <div class="absolute inset-0 bg-grid-pattern opacity-20"></div>
        <div class="container-custom text-center relative z-10" data-aos="zoom-in">
            <h2 class="font-display text-3xl md:text-5xl font-bold text-white mb-4">Siap Memulai Proyek Anda?</h2>
            <p class="text-white/80 text-lg mb-8 max-w-xl mx-auto">Hubungi kami sekarang dan dapatkan konsultasi GRATIS!
                Tim kami siap membantu.</p>
            <a href="{{ whatsappLink(site_whatsapp(), 'Halo, saya ingin konsultasi layanan Sindelaras Technology') }}"
                target="_blank" rel="noopener noreferrer" class="btn-primary text-lg px-10 py-4 animate-float">
                💬 Chat WhatsApp Sekarang
            </a>
        </div>
    </section>

@endsection
