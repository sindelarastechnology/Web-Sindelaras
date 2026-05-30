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

<section class="section-padding bg-white dark:bg-dark-base">
    <div class="container-custom max-w-4xl">
        <div class="prose-custom">
            @if($page?->content)
                {!! $page->content !!}
            @else
                <h2>Pendahuluan</h2>
                <p>Kami menghargai privasi Anda dan berkomitmen untuk melindungi data pribadi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda saat mengunjungi website kami.</p>

                <h2>Data yang Kami Kumpulkan</h2>
                <p>Kami dapat mengumpulkan informasi berikut:</p>
                <ul>
                    <li><strong>Data Pribadi:</strong> Nama, alamat email, nomor telepon yang Anda berikan melalui formulir kontak.</li>
                    <li><strong>Data Penggunaan:</strong> Informasi tentang cara Anda menggunakan website kami, halaman yang dikunjungi, dan durasi kunjungan.</li>
                    <li><strong>Data Perangkat:</strong> Informasi tentang perangkat Anda termasuk alamat IP, jenis browser, dan sistem operasi.</li>
                </ul>

                <h2>Penggunaan Cookie</h2>
                <p>Website kami menggunakan cookie untuk meningkatkan pengalaman browsing Anda. Cookie adalah file teks kecil yang disimpan di perangkat Anda. Kami menggunakan:</p>
                <ul>
                    <li><strong>Cookie Penting:</strong> Diperlukan untuk fungsi dasar website.</li>
                    <li><strong>Cookie Analitik:</strong> Membantu kami memahami bagaimana pengunjung menggunakan website.</li>
                    <li><strong>Cookie Iklan:</strong> Digunakan untuk menampilkan iklan yang relevan melalui Google AdSense.</li>
                </ul>
                <p>Dengan menggunakan website kami, Anda menyetujui penggunaan cookie sesuai dengan kebijakan ini. Anda dapat mengelola preferensi cookie melalui pengaturan browser Anda.</p>

                <h2>Google AdSense</h2>
                <p>Kami menggunakan Google AdSense untuk menampilkan iklan. Google AdSense menggunakan cookie untuk menayangkan iklan berdasarkan kunjungan Anda ke website kami dan website lain. Google menggunakan data ini untuk menampilkan iklan yang lebih relevan.</p>
                <p>Informasi lebih lanjut tentang bagaimana Google menggunakan data dapat ditemukan di <a href="https://policies.google.com/technologies/partner-sites" target="_blank" rel="noopener noreferrer">Kebijakan Privasi Google</a>.</p>
                <p>Anda dapat memilih untuk tidak menerima iklan yang dipersonalisasi dengan mengunjungi <a href="https://adssettings.google.com" target="_blank" rel="noopener noreferrer">Setelan Iklan Google</a>.</p>

                <h2>Hak Anda</h2>
                <p>Anda memiliki hak untuk:</p>
                <ul>
                    <li>Mengakses data pribadi yang kami simpan</li>
                    <li>Meminta koreksi data yang tidak akurat</li>
                    <li>Meminta penghapusan data Anda</li>
                    <li>Menolak pemrosesan data untuk kepentingan pemasaran</li>
                    <li>Menarik kembali persetujuan cookie kapan saja</li>
                </ul>

                <h2>Keamanan Data</h2>
                <p>Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang sesuai untuk melindungi data pribadi Anda dari akses tidak sah, perubahan, pengungkapan, atau penghancuran.</p>

                <h2>Perubahan Kebijakan</h2>
                <p>Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Perubahan akan diumumkan melalui website kami. Disarankan untuk meninjau halaman ini secara berkala.</p>

                <h2>Kontak</h2>
                <p>Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini, silakan hubungi kami:</p>
                <ul>
                    @if($settings->email)
                        <li>Email: <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></li>
                    @endif
                    @if($settings->whatsapp)
                        <li>WhatsApp: {{ $settings->whatsapp }}</li>
                    @endif
                    @if($settings->address)
                        <li>Alamat: {{ $settings->address }}</li>
                    @endif
                </ul>
                <p><em>Terakhir diperbarui: {{ date('d F Y') }}</em></p>
            @endif
        </div>
    </div>
</section>

@endsection
