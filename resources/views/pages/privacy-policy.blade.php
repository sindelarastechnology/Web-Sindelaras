@extends('layouts.app')
@section('content')

<section class="gradient-primary section-padding pt-32">
    <div class="container-custom text-center">
        <x-section-header
            tag="🔒 Kebijakan Privasi"
            title="{{ $page?->title ?? 'Kebijakan Privasi' }}"
            subtitle="{{ $page?->subtitle ?? 'Bagaimana kami menjaga dan melindungi data Anda.' }}"
            :light="true"
        />
    </div>
</section>

@if($page?->content)
    <section class="section-padding bg-white dark:bg-dark-base">
        <div class="container-custom max-w-4xl">
            <div class="prose-custom">
                {!! $page->content !!}
            </div>
        </div>
    </section>
@endif

@endsection
