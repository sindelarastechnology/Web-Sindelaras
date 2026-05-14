@props(['package', 'serviceTitle' => ''])

@php
$whatsappMsg = 'Halo, saya tertarik dengan Paket ' . $package->name . ' untuk layanan ' . ($serviceTitle ?: $package->service?->title ?? '') . '. Mohon info lebih lanjut.';
@endphp

<div data-aos="fade-up"
     class="relative bg-white dark:bg-dark-card border-2 rounded-2xl p-6 flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-1
            {{ $package->is_popular ? 'border-primary-500 shadow-lg shadow-primary-500/20 scale-[1.02] z-10' : 'border-slate-200 dark:border-dark-border hover:border-primary-300 dark:hover:border-primary-700' }}">

    @if($package->is_popular)
        <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-gradient-to-r from-primary-500 to-accent-500 text-white text-xs font-bold px-4 py-1 rounded-full shadow-lg">
            ⭐ PALING POPULER
        </div>
    @endif

    <div class="text-center mb-6 mt-2">
        <h3 class="font-display font-bold text-xl text-slate-900 dark:text-white mb-1">{{ $package->name }}</h3>
        @if($package->short_description)
            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $package->short_description }}</p>
        @endif
    </div>

    <div class="text-center mb-6">
        @if($package->has_discount)
            <span class="text-sm text-slate-400 line-through">{{ $package->original_price_formatted }}</span>
            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                -{{ $package->discount_percent }}%
            </span>
        @endif
        <div class="font-display font-bold text-3xl text-slate-900 dark:text-white mt-1">
            {{ $package->final_price }}
        </div>
        <span class="text-xs text-slate-400">{{ $package->price_unit }}</span>
    </div>

    <ul class="space-y-3 mb-8 flex-1">
        @foreach($package->features ?? [] as $feature)
            <li class="flex items-start gap-3 text-sm">
                <span class="flex-shrink-0">{{ $feature['icon'] ?? '✅' }}</span>
                <span class="text-slate-700 dark:text-slate-300">{{ $feature['feature'] ?? '' }}</span>
            </li>
        @endforeach
    </ul>

    @if($package->bonus)
        <div class="mb-4 p-3 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800">
            <p class="text-xs font-semibold text-amber-700 dark:text-amber-300 mb-1">🎁 BONUS</p>
            <ul class="space-y-1">
                @foreach($package->bonus as $bonus)
                    <li class="text-xs text-amber-600 dark:text-amber-400 flex items-center gap-1">
                        <span>+</span> {{ is_string($bonus) ? $bonus : ($bonus['bonus'] ?? '') }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="space-y-2 mb-6">
        @if($package->delivery_time)
            <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                <span>🕐</span>
                <span>Pengerjaan: <strong class="text-slate-700 dark:text-slate-300">{{ $package->delivery_time }}</strong></span>
            </div>
        @endif
        @if($package->maintenance)
            <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                <span>🔧</span>
                <span>Maintenance: <strong class="text-slate-700 dark:text-slate-300">{{ $package->maintenance }}</strong></span>
            </div>
        @endif
    </div>

    <a href="{{ whatsappLink(site_whatsapp(), $whatsappMsg) }}"
       target="_blank" rel="noopener noreferrer"
       class="inline-flex items-center justify-center gap-2 w-full font-semibold px-5 py-3 rounded-xl transition-all
              {{ $package->is_popular
                  ? 'bg-gradient-to-r from-primary-500 to-accent-500 text-white hover:shadow-lg hover:scale-[1.02]'
                  : 'bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 hover:bg-primary-100 dark:hover:bg-primary-900/50 border border-primary-200 dark:border-primary-800' }}">
        💬 {{ $package->cta_text }}
    </a>
</div>
