<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: document.documentElement.classList.contains('dark') }" :class="{ 'dark': darkMode }" class="scroll-smooth">
<head>
    <script>
    (function(){try{var t=localStorage.getItem('theme');if(t==='dark'||(t===null&&window.matchMedia('(prefers-color-scheme:dark)').matches))document.documentElement.classList.add('dark')}catch(e){}})();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if($settings->google_search_console)
        <meta name="google-site-verification" content="{{ $settings->google_search_console }}" />
    @endif

    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! \Artesaos\SEOTools\Facades\TwitterCard::generate() !!}

    {{-- Google Consent Mode v2 --}}
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('consent', 'default', {
        'ad_storage': 'denied',
        'ad_user_data': 'denied',
        'ad_personalization': 'denied',
        'analytics_storage': 'denied',
        'functionality_storage': 'granted',
        'security_storage': 'granted',
        'personalization_storage': 'denied',
        'wait_for_update': 500
    });
    gtag('set', 'ads_data_redaction', true);
    gtag('set', 'url_passthrough', true);

    {{-- If user previously accepted, restore consent --}}
    (function(){
        try {
            var consent = localStorage.getItem('cookie_consent');
            if (consent === 'accepted') {
                gtag('consent', 'update', {
                    'ad_storage': 'granted',
                    'ad_user_data': 'granted',
                    'ad_personalization': 'granted',
                    'analytics_storage': 'granted'
                });
            }
        } catch(e) {}
    })();
    </script>

    @if($settings->google_analytics_id)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->google_analytics_id }}"></script>
        <script>gtag('js',new Date());gtag('config','{{ $settings->google_analytics_id }}');</script>
    @endif

    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "name": {!! json_encode($settings->site_name ?? 'Sindelaras Technology') !!},
        "url": {!! json_encode(url('/')) !!},
        "logo": {!! json_encode($settings->logo ? Storage::url($settings->logo) : '') !!},
        "contactPoint": [
            {
                "@@type": "ContactPoint",
                "telephone": {!! json_encode($settings->whatsapp ?? '') !!},
                "contactType": "customer service",
                "availableLanguage": ["id"]
            }
        ],
        "sameAs": {!! json_encode(array_filter([
            $settings->instagram ? 'https://instagram.com/' . ltrim($settings->instagram, '@') : null,
            $settings->facebook,
            $settings->youtube,
            $settings->tiktok,
            $settings->linkedin,
        ])) !!}
    }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600&family=Orbitron:wght@600;700;800;900&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600&family=Orbitron:wght@600;700;800;900&display=swap" rel="stylesheet"></noscript>

    @if($settings->favicon)
        <link rel="icon" href="{{ Storage::url($settings->favicon) }}" type="image/x-icon">
    @endif

    {!! $settings->custom_head_scripts ?? '' !!}

    @stack('head')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body bg-slate-50 dark:bg-[#0a0f1e] text-slate-800 dark:text-slate-100 antialiased transition-colors duration-300">

    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:px-4 focus:py-2 focus:bg-primary-600 focus:text-white focus:rounded-lg focus:shadow-lg">
        Langsung ke konten utama
    </a>

    @include('layouts.partials.navbar')

    <main id="main-content">
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    {!! $settings->custom_footer_scripts ?? '' !!}

    @stack('scripts')

    <div id="cookie-consent" x-data="{ 
            show: !localStorage.getItem('cookie_consent'),
            accept() {
                localStorage.setItem('cookie_consent', 'accepted');
                gtag('consent', 'update', {
                    'ad_storage': 'granted',
                    'ad_user_data': 'granted',
                    'ad_personalization': 'granted',
                    'analytics_storage': 'granted'
                });
                loadAdSense();
                this.show = false;
            },
            reject() {
                localStorage.setItem('cookie_consent', 'rejected');
                gtag('consent', 'update', {
                    'ad_storage': 'denied',
                    'ad_user_data': 'denied',
                    'ad_personalization': 'denied',
                    'analytics_storage': 'denied'
                });
                this.show = false;
            }
         }"
         x-show="show"
         x-transition:enter="transition-all duration-500 ease-out"
         x-transition:enter-start="translate-y-full opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition-all duration-300 ease-in"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-full opacity-0"
         class="fixed bottom-0 left-0 right-0 z-40 bg-white dark:bg-dark-card border-t border-slate-200 dark:border-dark-border p-4 shadow-lg">
        <div class="container mx-auto max-w-6xl flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-slate-600 dark:text-slate-400">
                Kami menggunakan cookie untuk menampilkan iklan yang relevan dan meningkatkan pengalaman Anda. 
                Dengan mengklik "Terima", Anda menyetujui penggunaan semua cookie. 
                <a href="{{ route('privacy') }}" class="text-primary-600 hover:underline font-medium">Pelajari lebih lanjut</a>
            </p>
            <div class="flex gap-3 flex-shrink-0">
                <button @click="reject()"
                        class="px-5 py-2 rounded-full text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-border transition-all"
                        aria-label="Tolak cookie">Tolak</button>
                <button @click="accept()"
                        class="bg-accent-500 hover:bg-accent-600 text-white px-5 py-2 rounded-full text-sm font-semibold transition-all hover:shadow-lg hover:shadow-accent-500/30"
                        aria-label="Terima semua cookie">Terima</button>
            </div>
        </div>
    </div>

    @if($settings->google_adsense_id)
    <script>
    function loadAdSense() {
        if (document.querySelector('script[src*="pagead2.googlesyndication.com"]')) return;
        var consent = localStorage.getItem('cookie_consent');
        if (consent !== 'accepted') return;
        var s = document.createElement('script');
        s.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-{{ $settings->google_adsense_id }}';
        s.async = true;
        s.crossOrigin = 'anonymous';
        s.setAttribute('data-ad-client', 'ca-{{ $settings->google_adsense_id }}');
        document.head.appendChild(s);
        window.adsbygoogle = window.adsbygoogle || [];
    }
    loadAdSense();
    </script>
    @endif
</body>
</html>
