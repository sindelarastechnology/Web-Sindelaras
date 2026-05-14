<?php

if (!function_exists('settings')) {
    function settings(?string $key = null): mixed
    {
        $s = app('settings');
        return $key ? ($s->$key ?? null) : $s;
    }
}

if (!function_exists('site_whatsapp')) {
    function site_whatsapp(): string
    {
        $settings = app('settings');
        return $settings->whatsapp ?? config('app.fallback_whatsapp', '6285804217886');
    }
}

if (!function_exists('whatsappLink')) {
    function whatsappLink(?string $phone = null, string $message = ''): string
    {
        $phone = $phone ?: site_whatsapp();
        $phone = preg_replace('/^0/', '62', (string) $phone);
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (empty($phone)) {
            \Illuminate\Support\Facades\Log::warning('WhatsApp link generated with empty phone number');
            return '#';
        }
        $encoded = urlencode($message);
        return "https://wa.me/{$phone}" . ($message ? "?text={$encoded}" : '');
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah(int|float $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('isActiveRoute')) {
    function isActiveRoute(string $routeName, string $activeClass = 'active'): string
    {
        return request()->routeIs($routeName) ? $activeClass : '';
    }
}
