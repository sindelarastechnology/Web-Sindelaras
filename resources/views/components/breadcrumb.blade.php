@props(['items' => []])

<nav class="flex items-center gap-2 text-sm text-slate-400 mb-4" aria-label="Breadcrumb">
    <a href="{{ url('/') }}" class="hover:text-primary-500 transition-colors" aria-label="Beranda">🏠</a>
    @foreach($items as $item)
        <span class="text-slate-500">/</span>
        @if($item['url'] ?? false)
            <a href="{{ $item['url'] }}" class="hover:text-primary-500 transition-colors">{{ $item['label'] }}</a>
        @else
            <span class="text-slate-500 dark:text-slate-300">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
