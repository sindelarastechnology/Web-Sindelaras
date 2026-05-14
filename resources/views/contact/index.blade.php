@extends('layouts.app')
@section('content')

<section id="contact" class="gradient-primary section-padding pt-32">
    <div class="container-custom text-center">
        <x-section-header
            tag="📬 Hubungi Kami"
            title="Siap Memulai <span class='text-gradient'>Proyek Anda?</span>"
            subtitle="Hubungi kami sekarang untuk konsultasi gratis. Kami siap membantu bisnis Anda berkembang."
            :light="true"
        />
    </div>
</section>

<section class="section-padding bg-slate-50 dark:bg-[#0a0f1e]">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">
            <div class="lg:col-span-3" data-aos="fade-up">
                <div class="card p-8">
                    <h3 class="font-display font-bold text-2xl text-slate-900 dark:text-white mb-6">Kirim Pesan</h3>

                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 text-sm">
                            ✅ {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-5" id="contactForm"
                          x-data="{ loading: false }"
                          @submit.prevent="loading = true; $el.submit()">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Lengkap *</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       class="form-input @error('name') border-red-500 @enderror"
                                       placeholder="Nama Anda">
                                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Email *</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       class="form-input @error('email') border-red-500 @enderror"
                                       placeholder="email@anda.com">
                                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">No. WhatsApp</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                       class="form-input" placeholder="08xxxxxxxxxx">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Perusahaan</label>
                                <input type="text" name="company" value="{{ old('company') }}"
                                       class="form-input" placeholder="Nama perusahaan (opsional)">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Layanan yang Diminati</label>
                            <select name="service_id" class="form-input">
                                <option value="">— Pilih Layanan (opsional) —</option>
                                @foreach($services as $svc)
                                    <option value="{{ $svc->id }}" {{ old('service_id') == $svc->id ? 'selected' : '' }}>{{ $svc->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Subjek *</label>
                            <input type="text" name="subject" value="{{ old('subject') }}" required
                                   class="form-input" placeholder="Subjek pesan Anda">
                            @error('subject')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Pesan *</label>
                            <textarea name="message" rows="5" required
                                      class="form-input resize-none @error('message') border-red-500 @enderror"
                                      placeholder="Ceritakan kebutuhan proyek Anda...">{{ old('message') }}</textarea>
                            @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Estimasi Budget</label>
                                <select name="budget" class="form-input">
                                    <option value="">— Pilih Budget (opsional) —</option>
                                    <option value="< 5 Juta" {{ old('budget') == '< 5 Juta' ? 'selected' : '' }}>&lt; Rp 5 Juta</option>
                                    <option value="5-15 Juta" {{ old('budget') == '5-15 Juta' ? 'selected' : '' }}>Rp 5 - 15 Juta</option>
                                    <option value="15-50 Juta" {{ old('budget') == '15-50 Juta' ? 'selected' : '' }}>Rp 15 - 50 Juta</option>
                                    <option value="50-100 Juta" {{ old('budget') == '50-100 Juta' ? 'selected' : '' }}>Rp 50 - 100 Juta</option>
                                    <option value="> 100 Juta" {{ old('budget') == '> 100 Juta' ? 'selected' : '' }}>&gt; Rp 100 Juta</option>
                                    <option value="Tidak Tahu" {{ old('budget') == 'Tidak Tahu' ? 'selected' : '' }}>Tidak Tahu / Diskusi</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Target Timeline</label>
                                <select name="timeline" class="form-input">
                                    <option value="">— Pilih Timeline (opsional) —</option>
                                    <option value="Secepatnya" {{ old('timeline') == 'Secepatnya' ? 'selected' : '' }}>Secepatnya</option>
                                    <option value="1-2 Minggu" {{ old('timeline') == '1-2 Minggu' ? 'selected' : '' }}>1 - 2 Minggu</option>
                                    <option value="1 Bulan" {{ old('timeline') == '1 Bulan' ? 'selected' : '' }}>1 Bulan</option>
                                    <option value="2-3 Bulan" {{ old('timeline') == '2-3 Bulan' ? 'selected' : '' }}>2 - 3 Bulan</option>
                                    <option value="3+ Bulan" {{ old('timeline') == '3+ Bulan' ? 'selected' : '' }}>&gt; 3 Bulan</option>
                                    <option value="Masih Survey" {{ old('timeline') == 'Masih Survey' ? 'selected' : '' }}>Masih Survey</option>
                                </select>
                            </div>
                        </div>

                        <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
                        <button type="submit"
                                class="btn-primary w-full justify-center hover:scale-[1.02] transition-transform"
                                :disabled="loading"
                                :class="{ 'opacity-70 cursor-not-allowed': loading }">
                            <template x-if="!loading">
                                <span>🚀 Kirim Pesan Sekarang</span>
                            </template>
                            <template x-if="loading">
                                <span class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Mengirim...
                                </span>
                            </template>
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card p-6">
                    <h4 class="font-display font-bold text-lg text-slate-900 dark:text-white mb-5">📞 Informasi Kontak</h4>
                    <div class="space-y-4">
                        @if($settings->whatsapp)
                            <a href="{{ whatsappLink($settings->whatsapp) }}" target="_blank" rel="noopener noreferrer"
                               class="flex items-center gap-4 group">
                                <div class="w-11 h-11 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-xl flex-shrink-0">📱</div>
                                <div>
                                    <p class="text-xs text-slate-400 mb-0.5">WhatsApp</p>
                                    <p class="font-medium text-slate-800 dark:text-slate-200 group-hover:text-green-600 transition-colors">{{ $settings->whatsapp }}</p>
                                </div>
                            </a>
                        @endif
                        @if($settings->email)
                            <a href="mailto:{{ $settings->email }}" class="flex items-center gap-4 group">
                                <div class="w-11 h-11 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-xl flex-shrink-0">✉️</div>
                                <div>
                                    <p class="text-xs text-slate-400 mb-0.5">Email</p>
                                    <p class="font-medium text-slate-800 dark:text-slate-200 group-hover:text-primary-600 transition-colors">{{ $settings->email }}</p>
                                </div>
                            </a>
                        @endif
                        @if($settings->instagram)
                            <a href="https://instagram.com/{{ ltrim($settings->instagram, '@') }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-4 group">
                                <div class="w-11 h-11 rounded-xl bg-pink-100 dark:bg-pink-900/30 flex items-center justify-center text-xl flex-shrink-0">📸</div>
                                <div>
                                    <p class="text-xs text-slate-400 mb-0.5">Instagram</p>
                                    <p class="font-medium text-slate-800 dark:text-slate-200 group-hover:text-pink-600 transition-colors">{{ $settings->instagram }}</p>
                                </div>
                            </a>
                        @endif
                        @if($settings->address)
                            <div class="flex items-start gap-4">
                                <div class="w-11 h-11 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-xl flex-shrink-0">📍</div>
                                <div>
                                    <p class="text-xs text-slate-400 mb-0.5">Alamat</p>
                                    <p class="text-sm text-slate-700 dark:text-slate-300">{{ $settings->address }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card overflow-hidden">
                    <div class="relative w-full aspect-video">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3533.6564138348244!2d112.4238905744989!3d-8.072039980676971!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78914620d6da6b%3A0x6383daaa664d116b!2sSindelaras%20Technology!5e1!3m2!1sid!2sid!4v1778676357630!5m2!1sid!2sid"
                                class="absolute inset-0 w-full h-full"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                title="Lokasi Sindelaras Technology">
                        </iframe>
                    </div>
                </div>

                <div class="card p-6 bg-green-600 border-green-600 text-center">
                    <p class="text-white font-semibold mb-3">Mau lebih cepat? Chat langsung!</p>
                    <a href="{{ whatsappLink($settings->whatsapp ?? '', 'Halo, saya ingin konsultasi gratis') }}"
                       target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 bg-white text-green-700 font-bold px-6 py-3 rounded-full hover:bg-green-50 transition-colors">
                        💬 Buka WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
