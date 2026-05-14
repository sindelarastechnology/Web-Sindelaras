@props([
    'tag'      => null,
    'title'    => '',
    'subtitle' => null,
    'center'   => true,
    'light'    => false,
])

<div @class(['text-center' => $center, 'mb-12']) data-aos="fade-up">
    @if($tag)
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-medium font-accent
            bg-primary-100 dark:bg-primary-900/40 text-primary-700 dark:text-primary-300 mb-4">
            {{ $tag }}
        </span>
    @endif

    <h2 class="font-display text-3xl md:text-4xl font-bold
        {{ $light ? 'text-white' : 'text-slate-900 dark:text-white' }} leading-tight">
        {!! $title !!}
    </h2>

    @if($subtitle)
        <p class="mt-4 text-lg {{ $light ? 'text-slate-200' : 'text-slate-600 dark:text-slate-400' }} max-w-2xl {{ $center ? 'mx-auto' : '' }}">
            {{ $subtitle }}
        </p>
    @endif
</div>
