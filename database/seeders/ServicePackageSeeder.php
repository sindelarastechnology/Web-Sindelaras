<?php

namespace Database\Seeders;

use App\Models\ServicePackage;
use Illuminate\Database\Seeder;

class ServicePackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'service_id' => 1,
                'name' => 'Paket Hemat',
                'slug' => 'paket-hemat',
                'short_description' => 'Solusi website sederhana dan terjangkau untuk memulai bisnis online Anda dengan fitur-fitur esensial.',
                'price' => 1500000,
                'price_sale' => null,
                'features' => [
                    'Domain .com / .id (1 Tahun)',
                    'Hosting 3GB (1 Tahun)',
                    '5 Halaman Website',
                    'Desain Responsive (Mobile Friendly)',
                    'Form Kontak',
                    'Integrasi Sosial Media',
                    'SSL Certificate Gratis',
                    'SEO Dasar',
                    'Garansi Revisi 2x',
                ],
                'bonus' => ['Gratis 1 buah email profesional'],
                'delivery_time' => '7-14 Hari Kerja',
                'is_active' => true,
                'is_popular' => false,
                'maintenance' => 'Rp350.000/bulan — Update konten, backup, monitoring keamanan.',
                'cta_text' => 'Pilih Paket Hemat',
                'sort_order' => 1,
            ],
            [
                'service_id' => 1,
                'name' => 'Paket Bisnis',
                'slug' => 'paket-bisnis',
                'short_description' => 'Website profesional dengan fitur lengkap untuk mengembangkan bisnis Anda secara online.',
                'price' => 4500000,
                'price_sale' => 3500000,
                'features' => [
                    'Domain .com / .id (1 Tahun)',
                    'Hosting 10GB (1 Tahun)',
                    '10 Halaman Website',
                    'Desain Responsive (Mobile Friendly)',
                    'Form Kontak + Chat Integration',
                    'Integrasi Sosial Media',
                    'SSL Certificate Gratis',
                    'SEO Lanjutan (On-Page)',
                    'Integrasi Payment Gateway',
                    'Galeri Portfolio / Produk',
                    'Google Maps Integration',
                    'Garansi Revisi 3x',
                ],
                'bonus' => ['Gratis 3 email profesional', 'Google My Business setup'],
                'delivery_time' => '14-21 Hari Kerja',
                'is_active' => true,
                'is_popular' => true,
                'maintenance' => 'Rp500.000/bulan — Update konten, backup mingguan, monitoring, laporan bulanan.',
                'cta_text' => 'Pilih Paket Bisnis',
                'sort_order' => 2,
            ],
            [
                'service_id' => 1,
                'name' => 'Paket Enterprise',
                'slug' => 'paket-enterprise',
                'short_description' => 'Solusi website premium dengan fitur enterprise dan dukungan prioritas untuk perusahaan Anda.',
                'price' => 10000000,
                'price_sale' => 7500000,
                'features' => [
                    'Domain Premium (.com / .co.id) 1 Tahun',
                    'Hosting Unlimited / VPS (1 Tahun)',
                    'Halaman Tidak Terbatas',
                    'Desain Custom Premium (Mobile Friendly)',
                    'Form Kontak + Chat Integration + CRM',
                    'Integrasi Sosial Media + Auto Posting',
                    'SSL Certificate Gratis + Keamanan Ekstra',
                    'SEO Komprehensif (On-Page & Off-Page)',
                    'Integrasi Payment Gateway Multi',
                    'Sistem Manajemen Konten (CMS)',
                    'Multi Language Support',
                    'Analytics & Reporting Dashboard',
                    'Google Maps + Multi Lokasi',
                    'Garansi Revisi 6x',
                ],
                'bonus' => ['Gratis 5 email profesional', 'Google My Business', 'Google Ads Voucher 200rb'],
                'delivery_time' => '21-30 Hari Kerja',
                'is_active' => true,
                'is_popular' => false,
                'maintenance' => 'Rp1.000.000/bulan — Update konten, backup harian, monitoring 24/7, laporan mingguan, prioritas support.',
                'cta_text' => 'Pilih Paket Enterprise',
                'sort_order' => 3,
            ],
        ];

        foreach ($packages as $package) {
            ServicePackage::create($package);
        }

        $this->command->info('Service packages seeded successfully!');
    }
}
