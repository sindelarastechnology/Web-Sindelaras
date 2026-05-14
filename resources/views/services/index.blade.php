@extends('layouts.app')
@section('content')

<section class="gradient-primary section-padding pt-32">
    <div class="container-custom text-center">
        <x-section-header
            tag="💼 Layanan Kami"
            title="Solusi Digital untuk <span class='text-gradient'>Bisnis Anda</span>"
            subtitle="Kami menyediakan berbagai layanan IT profesional, dari pembuatan website hingga aplikasi custom."
            :light="true"
        />
    </div>
</section>

<section class="section-padding bg-slate-50 dark:bg-[#0a0f1e]">
    <div class="container-custom">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-aos-stagger="100">
            @forelse($services as $service)
                <x-service-card :service="$service" />
            @empty
                <p class="lg:col-span-3 text-center text-slate-500">Belum ada layanan tersedia.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="gradient-cta py-16 overflow-hidden relative">
    <div class="absolute inset-0 bg-grid-pattern opacity-20"></div>
    <div class="container-custom text-center relative z-10" data-aos="zoom-in">
        <h2 class="font-display text-3xl font-bold text-white mb-4">Tidak menemukan yang kamu cari?</h2>
        <p class="text-white/80 mb-8">Hubungi kami dan kami akan bantu carikan solusi terbaik untuk bisnis Anda.</p>
        <a href="{{ whatsappLink(site_whatsapp(), 'Halo, saya ingin konsultasi layanan') }}"
           target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 bg-white text-accent-600 hover:bg-slate-100 font-semibold px-6 py-3 rounded-full transition-all hover:shadow-lg hover:scale-105">
            💬 Chat WhatsApp Sekarang
        </a>
    </div>
</section>

@endsection
