@props(['slot' => null, 'format' => 'auto', 'class' => ''])

@php
    $adsenseId = settings('google_adsense_id');
    $adClient = $adsenseId ? (str_starts_with($adsenseId, 'ca-') ? $adsenseId : 'ca-' . $adsenseId) : null;
@endphp

@if($adClient && $slot)
    <div class="ad-container my-6 md:my-8 {{ $class }}" data-aos="fade-up">
        <div class="text-center">
            <p class="text-[10px] uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-2">— Iklan —</p>
            <div class="ad-slot mx-auto overflow-hidden rounded-xl bg-slate-50 dark:bg-dark-card border border-slate-200 dark:border-dark-border min-h-[90px] md:min-h-[120px] flex items-center justify-center">
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="{{ $adClient }}"
                     data-ad-slot="{{ $slot }}"
                     data-ad-format="{{ $format }}"
                     data-full-width-responsive="true"></ins>
                <script>
                     try { (adsbygoogle = window.adsbygoogle || []).push({}); } catch(e) {}
                </script>
            </div>
        </div>
    </div>
@endif
