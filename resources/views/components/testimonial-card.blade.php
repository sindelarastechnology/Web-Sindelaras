@props(['testimonial'])

<div class="bg-white dark:bg-dark-card border border-slate-200 dark:border-dark-border rounded-2xl p-6 flex flex-col gap-4 relative overflow-hidden group">
    @if($testimonial->video_url)
        <button @click="$dispatch('open-video', { url: '{{ $testimonial->video_url }}' })"
                aria-label="Putar video testimonial"
                class="absolute inset-0 z-10 flex items-center justify-center bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
            <div class="w-16 h-16 rounded-full bg-white/90 flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
                <svg class="w-8 h-8 text-primary-700 ml-1" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
            </div>
        </button>
    @endif

    <div class="flex gap-0.5 text-amber-400 text-lg">
        @for($i = 0; $i < min(($testimonial->rating ?? 5), 5); $i++)
            ★
        @endfor
    </div>

    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed flex-1 italic line-clamp-4">
        "{{ $testimonial->content }}"
    </p>

    <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-dark-border">
        <img src="{{ $testimonial->photo_url }}"
             alt="{{ $testimonial->client_name }}" loading="lazy" decoding="async"
             class="w-11 h-11 rounded-full object-cover ring-2 ring-primary-200 dark:ring-primary-800">
        <div>
            <p class="font-semibold text-slate-900 dark:text-white text-sm">{{ $testimonial->client_name }}</p>
            @if($testimonial->client_position || $testimonial->client_company)
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    {{ implode(', ', array_filter([$testimonial->client_position, $testimonial->client_company])) }}
                </p>
            @endif
        </div>
    </div>
</div>
