@props(['post'])

<article data-aos="fade-up"
         class="group bg-white dark:bg-dark-card border border-slate-200 dark:border-dark-border rounded-2xl overflow-hidden hover:shadow-xl hover:shadow-primary-500/10 hover:-translate-y-1 transition-all duration-300">

    <a href="{{ route('blog.show', $post->slug) }}" class="block overflow-hidden aspect-[16/9] bg-slate-200 dark:bg-dark-border">
        @if($post->featured_image)
            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->featured_image_alt ?: $post->title }}" loading="lazy" decoding="async"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full bg-gradient-to-br from-primary-800 to-primary-600 flex items-center justify-center">
                <span class="text-white/30 text-5xl">📝</span>
            </div>
        @endif
    </a>

    <div class="p-5">
        <div class="flex items-center justify-between mb-3">
            @if($post->category)
                <span class="text-xs font-medium px-3 py-1 rounded-full bg-primary-100 dark:bg-primary-900/40 text-primary-700 dark:text-primary-300">
                    {{ $post->category->name }}
                </span>
            @endif
            <span class="text-xs text-slate-500 dark:text-slate-400">
                {{ $post->published_at?->format('d M Y') }}
            </span>
        </div>

        <h3 class="font-display font-bold text-slate-900 dark:text-white text-lg leading-snug mb-2 line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
        </h3>

        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed line-clamp-3 mb-4">
            {{ $post->excerpt }}
        </p>

        <div class="flex items-center justify-between">
            <span class="text-xs text-slate-500 dark:text-slate-400">{{ $post->reading_time }}</span>
            <a href="{{ route('blog.show', $post->slug) }}"
               class="text-sm font-medium text-primary-600 dark:text-primary-400 hover:underline">
                Baca →
            </a>
        </div>
    </div>
</article>
