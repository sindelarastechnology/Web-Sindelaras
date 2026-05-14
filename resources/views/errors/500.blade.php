@extends('layouts.app')
@section('content')
<section class="min-h-screen flex items-center justify-center px-4 gradient-primary pt-20">
    <div class="text-center max-w-lg" data-aos="fade-up">
        <div class="text-9xl font-display font-bold text-white/20 mb-4">500</div>
        <h1 class="font-display text-4xl font-bold text-white mb-3">Kesalahan Server</h1>
        <p class="text-slate-300 mb-8">Maaf, terjadi kesalahan pada server. Silakan coba lagi.</p>
        <a href="{{ url('/') }}" class="btn-primary">🏠 Kembali ke Beranda</a>
    </div>
</section>
@endsection
