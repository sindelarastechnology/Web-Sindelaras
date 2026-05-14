@props(['portfolio'])

<div data-aos="fade-up"
     class="group relative overflow-hidden rounded-2xl bg-slate-200 dark:bg-dark-card aspect-[4/3] hover:shadow-2xl hover:shadow-primary-500/20 transition-shadow duration-300">

    @if($portfolio->thumbnail)
        <img src="{{ Storage::url($portfolio->thumbnail) }}"
             alt="{{ $portfolio->title }}" loading="lazy" decoding="async"
             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
    @else
        <div class="w-full h-full bg-gradient-to-br from-primary-900 to-primary-700 flex items-center justify-center">
            <span class="text-white/40 text-6xl">🖥️</span>
        </div>
    @endif

    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent
                opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <div class="absolute bottom-0 left-0 right-0 p-5">
            @if($portfolio->category)
                <span class="text-xs font-medium text-accent-400 mb-2 block">{{ $portfolio->category->name }}</span>
            @endif
            <h3 class="font-display font-bold text-white text-lg mb-3">{{ $portfolio->title }}</h3>
            <a href="{{ route('portfolio.show', $portfolio->slug) }}"
               class="inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm
                      text-white text-sm px-4 py-2 rounded-full transition-colors">
                Lihat Detail →
            </a>
        </div>
    </div>
</div>
