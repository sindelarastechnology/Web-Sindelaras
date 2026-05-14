@props(['service'])

<div data-aos="fade-up"
     class="group relative bg-white dark:bg-dark-card border border-slate-200 dark:border-dark-border
            rounded-2xl p-6 hover:border-primary-400 dark:hover:border-primary-600
            hover:shadow-xl hover:shadow-primary-500/10 hover:-translate-y-1
            transition-all duration-300 cursor-pointer overflow-hidden">

    <div class="w-14 h-14 rounded-xl bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center
                text-2xl mb-5 group-hover:bg-primary-100 dark:group-hover:bg-primary-800/50 transition-colors">
        {{ $service->icon ?? '💼' }}
    </div>

    <h3 class="font-display font-bold text-lg text-slate-900 dark:text-white mb-3 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
        {{ $service->title }}
    </h3>

    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-5">
        {{ $service->short_description }}
    </p>

    <a href="{{ route('services.show', $service->slug) }}"
       class="inline-flex items-center gap-2 text-sm font-medium text-primary-600 dark:text-primary-400
              hover:gap-3 transition-all">
        Selengkapnya
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
        </svg>
    </a>

    <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-primary-500 to-accent-500
                scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-b-2xl"></div>
</div>
