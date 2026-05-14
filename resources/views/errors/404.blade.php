@extends('layouts.app')
@section('content')
<section class="min-h-screen flex items-center justify-center px-4 gradient-primary pt-20">
    <div class="text-center max-w-lg" data-aos="fade-up">
        <div class="text-9xl font-display font-bold text-white/20 mb-4">404</div>
        <h1 class="font-display text-4xl font-bold text-white mb-3">Halaman Tidak Ditemukan</h1>
        <p class="text-slate-300 mb-8">Halaman yang Anda cari tidak ada atau telah dipindahkan.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ url('/') }}" class="btn-primary">🏠 Kembali ke Beranda</a>
            <a href="{{ route('contact') }}" class="btn-outline">📬 Hubungi Kami</a>
        </div>
    </div>
</section>
@endsection
