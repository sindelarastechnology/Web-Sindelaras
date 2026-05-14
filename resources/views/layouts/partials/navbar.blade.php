<nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = window.scrollY > 20" :class="scrolled ? 'shadow-lg' : ''"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300
            bg-white/90 dark:bg-[#0a0f1e]/90 backdrop-blur-md
            border-b border-slate-200/50 dark:border-blue-900/30">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16 lg:h-20">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                @if ($settings->logo)
                    <img src="{{ Storage::url($settings->logo) }}" alt="{{ $settings->site_name }}" loading="lazy"
                        decoding="async" class="h-10 w-auto">
                @endif
                <div class="flex flex-col leading-none">
                    <span
                        class="font-accent text-sm font-bold text-primary-600 dark:text-primary-400 tracking-wide">SINDELARAS</span>
                    <span
                        class="font-futuristic text-[10px] font-bold text-accent-500 dark:text-accent-400 tracking-[0.15em]">TECHNOLOGY</span>
                </div>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden lg:flex items-center gap-6">
                <div class="relative" x-data="{ query: '', results: [], show: false, loading: false }">
                    <form action="{{ route('blog.search') }}" method="GET" class="relative">
                        <input type="text" name="q" x-model="query" placeholder="Cari..."
                            @input.debounce.400ms="if (query.length >= 2) { loading = true; fetch('{{ route('blog.search') }}?q=' + encodeURIComponent(query) + '&ajax=1').then(r => r.json()).then(d => { results = d; show = true; loading = false; }).catch(() => { loading = false; }); } else { show = false; results = []; }"
                            @click.away="show = false" @keydown.escape="show = false"
                            class="w-36 lg:w-44 px-3 py-1.5 rounded-full bg-slate-100 dark:bg-dark-card border border-slate-200 dark:border-dark-border text-xs text-slate-600 dark:text-slate-300 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all">
                        <button type="submit" aria-label="Cari"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                    <div x-show="show && results.length > 0" x-transition
                        class="absolute top-full right-0 mt-2 w-80 bg-white dark:bg-dark-card rounded-xl shadow-xl border border-slate-200 dark:border-dark-border py-2 z-50 max-h-80 overflow-y-auto">
                        <template x-for="post in results" :key="post.id">
                            <a :href="post.url"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-200 hover:bg-primary-50 dark:hover:bg-primary-900/30 transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-dark-border flex-shrink-0 flex items-center justify-center text-xs text-slate-400"
                                    x-text="post.title.charAt(0)"></div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-medium truncate" x-text="post.title"></p>
                                    <p class="text-xs text-slate-400" x-text="post.date"></p>
                                </div>
                            </a>
                        </template>
                    </div>
                    <div x-show="show && loading"
                        class="absolute top-full right-0 mt-2 w-80 bg-white dark:bg-dark-card rounded-xl shadow-xl border border-slate-200 dark:border-dark-border py-4 z-50 text-center text-sm text-slate-400">
                        Mencari...
                    </div>
                    <div x-show="show && !loading && query.length >= 2 && results.length === 0"
                        class="absolute top-full right-0 mt-2 w-80 bg-white dark:bg-dark-card rounded-xl shadow-xl border border-slate-200 dark:border-dark-border py-4 z-50 text-center text-sm text-slate-400">
                        Tidak ditemukan hasil untuk "<span x-text="query"></span>"
                    </div>
                </div>

                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                    {{ request()->routeIs('home') ? 'aria-current="page"' : '' }}>Home</a>

                {{-- Dropdown Layanan --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false"
                        class="nav-link flex items-center gap-1 {{ request()->routeIs('services.*') ? 'active' : '' }}"
                        {{ request()->routeIs('services.*') ? 'aria-current="page"' : '' }}>
                        Layanan
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition
                        class="absolute top-full left-0 mt-2 w-56 bg-white dark:bg-dark-card rounded-xl shadow-xl border border-slate-200 dark:border-dark-border py-2 z-50">
                        @foreach ($navServices ?? [] as $service)
                            <a href="{{ route('services.show', $service->slug) }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-200 hover:bg-primary-50 dark:hover:bg-primary-900/30 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                <span class="text-lg">{{ $service->icon }}</span>
                                {{ $service->title }}
                            </a>
                        @endforeach
                        <div class="border-t border-slate-200 dark:border-dark-border mt-1 pt-1">
                            <a href="{{ route('services.index') }}"
                                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-primary-600 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/30">
                                Lihat Semua Layanan →
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('portfolio.index') }}"
                    class="nav-link {{ request()->routeIs('portfolio.*') ? 'active' : '' }}"
                    {{ request()->routeIs('portfolio.*') ? 'aria-current="page"' : '' }}>Portfolio</a>
                <a href="{{ route('blog.index') }}"
                    class="nav-link {{ request()->routeIs('blog.*') && !request()->routeIs('blog.search') ? 'active' : '' }}"
                    {{ request()->routeIs('blog.*') && !request()->routeIs('blog.search') ? 'aria-current="page"' : '' }}>Blog</a>
                <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                    {{ request()->routeIs('about') ? 'aria-current="page"' : '' }}>Tentang</a>
                <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                    {{ request()->routeIs('contact') ? 'aria-current="page"' : '' }}>Kontak</a>
            </div>

            {{-- Right Side --}}
            <div class="flex items-center gap-3">
                @include('layouts.partials.theme-toggle')

                <a href="{{ whatsappLink(site_whatsapp(), 'Halo, saya ingin konsultasi layanan Sindelaras Technology') }}"
                    target="_blank" rel="noopener noreferrer"
                    class="hidden lg:flex items-center gap-2 bg-accent-500 hover:bg-accent-600 text-white px-5 py-2.5 rounded-full font-medium text-sm transition-all hover:shadow-lg hover:shadow-accent-500/30">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                        <path
                            d="M12 0C5.373 0 0 5.373 0 12c0 2.125.557 4.122 1.532 5.854L0 24l6.334-1.507A11.95 11.95 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.891 0-3.667-.5-5.204-1.378l-.374-.22-3.762.895.949-3.663-.243-.386A9.944 9.944 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                    </svg>
                    Hubungi Kami
                </a>

                {{-- Mobile Hamburger --}}
                <button
                    @click="open = !open; if(open) { $nextTick(() => $el.nextElementSibling?.querySelector('a')?.focus()) }"
                    class="lg:hidden p-3 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-card"
                    aria-controls="mobile-menu" :aria-expanded="open" aria-label="Toggle navigation menu">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            class="lg:hidden py-4 border-t border-slate-200 dark:border-dark-border" x-data="{ serviceOpen: false }"
            role="navigation" aria-label="Mobile navigation">
            <div class="flex flex-col gap-1">
                <div class="px-4 py-2" x-data="{ query: '', results: [], show: false, loading: false }">
                    <form action="{{ route('blog.search') }}" method="GET" class="relative">
                        <input type="text" name="q" x-model="query" placeholder="Cari artikel..."
                            @input.debounce.400ms="if (query.length >= 2) { loading = true; fetch('{{ route('blog.search') }}?q=' + encodeURIComponent(query) + '&ajax=1').then(r => r.json()).then(d => { results = d; show = true; loading = false; }).catch(() => { loading = false; }); } else { show = false; results = []; }"
                            @keydown.escape="show = false"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-dark-card border border-slate-200 dark:border-dark-border text-sm text-slate-600 dark:text-slate-300 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </form>
                    <div x-show="show && results.length > 0" x-transition
                        class="mt-2 bg-white dark:bg-dark-card rounded-xl shadow-xl border border-slate-200 dark:border-dark-border py-2 z-50 max-h-60 overflow-y-auto">
                        <template x-for="post in results" :key="post.id">
                            <a :href="post.url"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-200 hover:bg-primary-50 dark:hover:bg-primary-900/30 transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-dark-border flex-shrink-0 flex items-center justify-center text-xs text-slate-400"
                                    x-text="post.title.charAt(0)"></div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-medium truncate" x-text="post.title"></p>
                                    <p class="text-xs text-slate-400" x-text="post.date"></p>
                                </div>
                            </a>
                        </template>
                    </div>
                    <div x-show="show && loading"
                        class="mt-2 bg-white dark:bg-dark-card rounded-xl shadow-xl border border-slate-200 dark:border-dark-border py-3 z-50 text-center text-sm text-slate-400">
                        Mencari...
                    </div>
                    <div x-show="show && !loading && query.length >= 2 && results.length === 0"
                        class="mt-2 bg-white dark:bg-dark-card rounded-xl shadow-xl border border-slate-200 dark:border-dark-border py-3 z-50 text-center text-sm text-slate-400">
                        Tidak ditemukan hasil untuk "<span x-text="query"></span>"
                    </div>
                </div>
                <a href="{{ route('home') }}"
                    class="mobile-nav-link {{ request()->routeIs('home') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400' : '' }}">Home</a>
                <div>
                    <button @click="serviceOpen = !serviceOpen"
                        class="mobile-nav-link w-full flex items-center justify-between">
                        <span>Layanan</span>
                        <svg class="w-4 h-4 transition-transform" :class="serviceOpen ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="serviceOpen" x-collapse
                        class="bg-slate-50 dark:bg-dark-base rounded-xl mx-4 mb-1 overflow-hidden">
                        @foreach ($navServices ?? [] as $svc)
                            <a href="{{ route('services.show', $svc->slug) }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-primary-50 dark:hover:bg-primary-900/30 hover:text-primary-600 transition-colors">
                                <span class="text-lg">{{ $svc->icon }}</span>
                                {{ $svc->title }}
                            </a>
                        @endforeach
                        <a href="{{ route('services.index') }}"
                            class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-primary-600 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/30">
                            Lihat Semua Layanan →
                        </a>
                    </div>
                </div>
                <a href="{{ route('portfolio.index') }}"
                    class="mobile-nav-link {{ request()->routeIs('portfolio.*') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400' : '' }}">Portfolio</a>
                <a href="{{ route('blog.index') }}"
                    class="mobile-nav-link {{ request()->routeIs('blog.*') && !request()->routeIs('blog.search') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400' : '' }}">Blog</a>
                <a href="{{ route('about') }}"
                    class="mobile-nav-link {{ request()->routeIs('about') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400' : '' }}">Tentang
                    Kami</a>
                <a href="{{ route('contact') }}"
                    class="mobile-nav-link {{ request()->routeIs('contact') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400' : '' }}">Kontak</a>
                <a href="{{ whatsappLink(site_whatsapp(), 'Halo, saya ingin konsultasi') }}" target="_blank"
                    rel="noopener noreferrer"
                    class="mt-3 mx-4 bg-accent-500 hover:bg-accent-600 text-white px-4 py-3 rounded-xl font-medium text-center transition-colors">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                        </svg>
                        Chat WhatsApp
                    </span>
                </a>
            </div>
        </div>
    </div>
</nav>
