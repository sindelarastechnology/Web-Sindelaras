@extends('layouts.app')
@section('content')

<section class="gradient-primary pt-32 pb-20">
    <div class="container-custom">
        <x-breadcrumb :items="[
            ['label' => 'Layanan', 'url' => route('services.index')],
            ['label' => $service->title],
        ]" />
        <div class="max-w-3xl">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-700/50 text-primary-200 mb-4">
                {{ $service->category?->name ?? 'Layanan' }}
            </span>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-white mb-4" data-aos="fade-up">
                {{ $service->title }}
            </h1>
            <p class="text-lg text-slate-300 mb-8" data-aos="fade-up" data-aos-delay="100">
                {{ $service->short_description }}
            </p>
            <a href="{{ $service->whatsapp_url }}" target="_blank" rel="noopener noreferrer" class="btn-primary" data-aos="fade-up" data-aos-delay="150">
                💬 Konsultasi Gratis
            </a>
        </div>
    </div>
</section>

@if($service->activePackages->count() > 0)
    <section class="section-padding bg-white dark:bg-dark-base relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-pattern opacity-20 dark:opacity-10 pointer-events-none"></div>
        <div class="container-custom relative z-10">
            <x-section-header
                tag="🎯 Pilih Paket"
                title="Pilih Paket Sesuai <span class='text-gradient'>Kebutuhan Anda</span>"
                subtitle="Dapatkan solusi terbaik dengan harga yang transparan dan fitur lengkap."
            />
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-12 items-start" data-aos-stagger="100">
                @foreach($service->activePackages as $package)
                    <x-service-package-card :package="$package" :service-title="$service->title" />
                @endforeach
            </div>
        </div>
    </section>
@endif

<section class="section-padding bg-white dark:bg-dark-base">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2">
                @if($service->banner_image)
                    <img src="{{ Storage::url($service->banner_image) }}"
                         alt="{{ $service->title }}" loading="lazy" decoding="async"
                         class="w-full rounded-2xl mb-8 shadow-lg">
                @endif

                <div class="prose-custom">
                    {!! $service->description !!}
                </div>

                {{-- AdSense Banner -- ganti slot dengan ID unit iklan dari dashboard AdSense --}}
                <x-ad-banner slot="" format="auto" />

                @if($service->process_steps)
                    <div class="mt-12">
                        <h3 class="font-display text-2xl font-bold text-slate-900 dark:text-white mb-6">📋 Proses Pengerjaan</h3>
                        <div class="space-y-4">
                            @foreach($service->process_steps as $i => $step)
                                <div class="flex items-start gap-4" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                                    <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900/40 flex items-center justify-center flex-shrink-0 font-bold text-sm text-primary-700 dark:text-primary-300">
                                        {{ $i + 1 }}
                                    </div>
                                    <div class="flex-1 pt-1.5">
                                        <p class="text-slate-700 dark:text-slate-300">
                                            {{ is_string($step) ? $step : ($step['step'] ?? '') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($service->faqs->count() > 0)
                    <div class="mt-12">
                        <h3 class="font-display text-2xl font-bold text-slate-900 dark:text-white mb-6">❓ Pertanyaan Umum</h3>
                        <div class="space-y-3" x-data="{ open: null }">
                            @foreach($service->faqs as $i => $faq)
                                <div class="card overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $i * 50 }}">
                                    <button @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                                            :aria-expanded="open === {{ $i }}"
                                            :aria-controls="'faq-panel-{{ $i }}'"
                                            class="w-full flex items-center justify-between p-5 text-left font-semibold text-slate-900 dark:text-white">
                                        {{ $faq->question }}
                                        <svg class="w-5 h-5 flex-shrink-0 transition-transform"
                                             :class="open === {{ $i }} ? 'rotate-180' : ''"
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div id="faq-panel-{{ $i }}" x-show="open === {{ $i }}" x-collapse>
                                        <p class="px-5 pb-5 text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                                            {{ $faq->answer }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="space-y-6" data-aos="fade-up" data-aos-delay="150">
                @if($service->features)
                    <div class="card p-6">
                        <h4 class="font-display font-bold text-lg text-slate-900 dark:text-white mb-4">✅ Yang Anda Dapatkan</h4>
                        <ul class="space-y-2">
                            @foreach($service->features as $feature)
                                <li class="flex items-start gap-3 text-sm text-slate-700 dark:text-slate-300">
                                    <span class="text-green-500 mt-0.5 flex-shrink-0">✓</span>
                                    {{ is_string($feature) ? $feature : ($feature['feature'] ?? '') }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($service->show_price && $service->price_range)
                    <div class="card p-6 border-primary-300 dark:border-primary-700">
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-1">Estimasi Harga</p>
                        <p class="font-display font-bold text-2xl text-primary-600 dark:text-primary-400">
                            {{ $service->price_range }}
                        </p>
                        @if($service->price_unit)
                            <p class="text-xs text-slate-400 mt-1">{{ $service->price_unit }}</p>
                        @endif
                    </div>
                @endif

                <div class="card p-6 bg-primary-800 border-primary-700">
                    <h4 class="font-display font-bold text-white text-lg mb-2">Mulai Sekarang</h4>
                    <p class="text-primary-200 text-sm mb-4">Konsultasi gratis, tanpa biaya!</p>
                    <a href="{{ $service->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                       class="btn-primary w-full justify-center">
                        💬 Chat WhatsApp
                    </a>
                </div>

                @if($service->testimonials->count() > 0)
                    <div class="card p-6">
                        <h4 class="font-display font-bold text-slate-900 dark:text-white mb-4">💬 Testimonial</h4>
                        <div class="space-y-4">
                            @foreach($service->testimonials->take(2) as $testimonial)
                                <div class="flex items-start gap-3">
                                    <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->client_name }}"
                                         loading="lazy" decoding="async"
                                         class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                                    <div>
                                        <p class="text-xs text-slate-600 dark:text-slate-400 italic leading-relaxed">
                                            "{{ \Illuminate\Support\Str::limit($testimonial->content, 100) }}"
                                        </p>
                                        <p class="text-xs font-semibold text-slate-900 dark:text-white mt-1">
                                            {{ $testimonial->client_name }}
                                            @if($testimonial->rating)
                                                <span class="text-amber-400">{{ str_repeat('★', $testimonial->rating) }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($relatedServices->count() > 0)
                    <div class="card p-6">
                        <h4 class="font-display font-bold text-slate-900 dark:text-white mb-4">Layanan Terkait</h4>
                        <ul class="space-y-3">
                            @foreach($relatedServices as $related)
                                <li>
                                    <a href="{{ route('services.show', $related->slug) }}"
                                       class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                        <span class="text-lg">{{ $related->icon ?? '💼' }}</span>
                                        {{ $related->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@if($service->activePackages->count() > 0)
    <section class="gradient-cta py-16 overflow-hidden relative">
        <div class="absolute inset-0 bg-grid-pattern opacity-20"></div>
        <div class="container-custom text-center relative z-10" data-aos="zoom-in">
            <h2 class="font-display text-3xl font-bold text-white mb-4">Tertarik dengan Paket {{ $service->activePackages->first()->name }}?</h2>
            <p class="text-white/80 mb-8">Konsultasikan kebutuhan Anda dengan tim kami. Gratis!</p>
            <a href="{{ whatsappLink(site_whatsapp(), 'Halo, saya ingin konsultasi mengenai paket ' . $service->activePackages->first()->name . ' untuk layanan ' . $service->title) }}"
               target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-2 bg-white text-accent-600 hover:bg-slate-100 font-semibold px-6 py-3 rounded-full transition-all hover:shadow-lg hover:scale-105">
                💬 Chat WhatsApp Sekarang
            </a>
        </div>
    </section>
@endif

@endsection
