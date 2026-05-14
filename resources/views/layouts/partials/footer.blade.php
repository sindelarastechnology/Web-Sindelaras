<footer class="bg-white dark:bg-[#0a0f1e] text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-dark-border transition-colors duration-300">
    {{-- Main Footer --}}
    <div class="container-custom py-12 md:py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10">
            {{-- Brand — full width di mobile/tablet, 1 kolom di desktop --}}
            <div class="sm:col-span-2 lg:col-span-1 text-center sm:text-left">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-4">
                    @if($settings->logo)
                        <img src="{{ Storage::url($settings->logo) }}" alt="{{ $settings->site_name }}" loading="lazy" decoding="async" class="h-12 w-auto">
                    @endif
                    <div class="flex flex-col leading-none text-left">
                        <span class="font-accent text-base font-bold text-primary-600 dark:text-primary-400 tracking-wide">SINDELARAS</span>
                        <span class="font-futuristic text-[11px] font-bold text-accent-500 dark:text-accent-400 tracking-[0.15em]">TECHNOLOGY</span>
                    </div>
                </a>
                <p class="text-sm leading-relaxed mb-5">
                    {{ $settings->site_tagline ?? 'Your IT and Business Solution' }}
                </p>
                <div class="flex gap-3 justify-center sm:justify-start">
                    @if($settings->instagram)
                        <a href="https://instagram.com/{{ ltrim($settings->instagram, '@') }}" target="_blank" rel="noopener noreferrer"
                           class="w-11 h-11 rounded-lg bg-slate-200 dark:bg-white/10 hover:bg-primary-600 dark:hover:bg-primary-700 flex items-center justify-center transition-colors text-lg" aria-label="Instagram">📸</a>
                    @endif
                    @if($settings->facebook)
                        <a href="{{ $settings->facebook }}" target="_blank" rel="noopener noreferrer"
                           class="w-11 h-11 rounded-lg bg-slate-200 dark:bg-white/10 hover:bg-primary-600 dark:hover:bg-primary-700 flex items-center justify-center transition-colors text-lg" aria-label="Facebook">👥</a>
                    @endif
                    @if($settings->youtube)
                        <a href="{{ $settings->youtube }}" target="_blank" rel="noopener noreferrer"
                           class="w-11 h-11 rounded-lg bg-slate-200 dark:bg-white/10 hover:bg-primary-600 dark:hover:bg-primary-700 flex items-center justify-center transition-colors text-lg" aria-label="YouTube">▶️</a>
                    @endif
                    @if($settings->tiktok)
                        <a href="{{ $settings->tiktok }}" target="_blank" rel="noopener noreferrer"
                           class="w-11 h-11 rounded-lg bg-slate-200 dark:bg-white/10 hover:bg-primary-600 dark:hover:bg-primary-700 flex items-center justify-center transition-colors text-lg" aria-label="TikTok">🎵</a>
                    @endif
                    @if($settings->linkedin)
                        <a href="{{ $settings->linkedin }}" target="_blank" rel="noopener noreferrer"
                           class="w-11 h-11 rounded-lg bg-slate-200 dark:bg-white/10 hover:bg-primary-600 dark:hover:bg-primary-700 flex items-center justify-center transition-colors text-lg" aria-label="LinkedIn">💼</a>
                    @endif
                </div>
            </div>

            {{-- Layanan + Link Cepat — side by side di tablet, sendiri di desktop --}}
            @if($navServices && $navServices->count() > 0)
            <div>
                <h5 class="font-display font-bold text-slate-800 dark:text-white mb-4">Layanan</h5>
                <ul class="space-y-2 text-sm">
                    @foreach($navServices ?? [] as $service)
                        <li>
                            <a href="{{ route('services.show', $service->slug) }}"
                               class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                {{ $service->title }}
                            </a>
                        </li>
                    @endforeach
                    <li><a href="{{ route('services.index') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors">Semua Layanan →</a></li>
                </ul>
            </div>
            @endif

            <div>
                <h5 class="font-display font-bold text-slate-800 dark:text-white mb-4">Link Cepat</h5>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Home</a></li>
                    <li><a href="{{ route('portfolio.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Portfolio</a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Blog</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Tentang Kami</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Kontak</a></li>
                    <li><a href="{{ route('privacy') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Privacy Policy</a></li>
                </ul>
            </div>

            {{-- Newsletter (sembunyikan sementara) --}}
            {{-- 
            @include('layouts.partials.footer-newsletter')
            --}}

            {{-- Kontak — full width di tablet, 1 kolom di desktop --}}
            <div class="sm:col-span-2 lg:col-span-1">
                <h5 class="font-display font-bold text-slate-800 dark:text-white mb-4">Hubungi Kami</h5>
                <ul class="space-y-3 text-sm">
                    @if($settings->whatsapp)
                        <li class="flex items-center gap-2">
                            <span>📱</span>
                            <a href="{{ whatsappLink($settings->whatsapp) }}" target="_blank" rel="noopener noreferrer" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                {{ $settings->whatsapp }}
                            </a>
                        </li>
                    @endif
                    @if($settings->email)
                        <li class="flex items-center gap-2">
                            <span>✉️</span>
                            <a href="mailto:{{ $settings->email }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors break-all">
                                {{ $settings->email }}
                            </a>
                        </li>
                    @endif
                    @if($settings->instagram)
                        <li class="flex items-center gap-2">
                            <span>📸</span>
                            <a href="https://instagram.com/{{ ltrim($settings->instagram, '@') }}" target="_blank" rel="noopener noreferrer" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                {{ $settings->instagram }}
                            </a>
                        </li>
                    @endif
                    @if($settings->website_url)
                        <li class="flex items-center gap-2">
                            <span>🌐</span>
                            <a href="{{ $settings->website_url }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                {{ $settings->website_url }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-slate-200 dark:border-white/10">
        <div class="container-custom py-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500 dark:text-slate-500">
            <p>© {{ date('Y') }} {{ $settings->site_name ?? 'Sindelaras Technology' }}. All rights reserved.</p>
            <a href="{{ route('privacy') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Privacy Policy</a>
        </div>
    </div>
</footer>

{{-- Back to Top --}}
<button id="back-to-top"
        class="fixed bottom-6 right-6 z-50 w-12 h-12 rounded-full bg-primary-600 hover:bg-primary-700 text-white
               flex items-center justify-center shadow-lg opacity-0 pointer-events-none transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
        aria-label="Kembali ke atas">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
    </svg>
</button>

{{-- WhatsApp Float --}}
@if(site_whatsapp())
    <a href="{{ whatsappLink(site_whatsapp(), 'Halo, saya ingin konsultasi') }}"
       target="_blank" rel="noopener noreferrer"
       class="fixed bottom-6 left-6 z-50 w-14 h-14 rounded-full bg-green-500 hover:bg-green-600 text-white
              flex items-center justify-center shadow-xl hover:shadow-green-500/40 transition-all hover:scale-110
              animate-float"
       aria-label="Hubungi kami via WhatsApp">
        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
    </a>
@endif
