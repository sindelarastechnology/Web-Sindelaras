@extends('layouts.app')
@section('content')
<section class="min-h-screen flex items-center justify-center px-4 gradient-primary pt-20">
    <div class="text-center max-w-lg" data-aos="fade-up">
        <div class="text-9xl font-display font-bold text-white/20 mb-4">503</div>
        <h1 class="font-display text-4xl font-bold text-white mb-3">Sedang Dalam Perbaikan</h1>
        <p class="text-slate-300 mb-8">{{ optional($settings ?? app('settings'))->maintenance_message ?? 'Kami sedang melakukan pemeliharaan. Silakan kembali lagi nanti.' }}</p>
        <a href="{{ url('/') }}" class="btn-primary">🔄 Coba Lagi</a>
    </div>
</section>
@endsection
