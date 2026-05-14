<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px;">
<div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <div style="background: linear-gradient(135deg, #1e40af, #1e3a8a); padding: 24px; text-align: center;">
        <h1 style="color: #fff; margin: 0; font-size: 20px;">✅ Terima Kasih!</h1>
        <p style="color: #93c5fd; margin: 4px 0 0;">Pesan Anda telah kami terima</p>
    </div>
    <div style="padding: 24px;">
        <p style="color: #334155; line-height: 1.6;">Halo <strong>{{ $contact->name }}</strong>,</p>
        <p style="color: #334155; line-height: 1.6;">Terima kasih telah menghubungi Sindelaras Technology. Pesan Anda dengan subjek <strong>"{{ $contact->subject }}"</strong> sudah kami terima dan akan segera kami proses.</p>
        <p style="color: #334155; line-height: 1.6;">Tim kami akan menghubungi Anda dalam 1x24 jam melalui WhatsApp atau email.</p>
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 16px; border-radius: 8px; margin-top: 16px;">
            <p style="margin: 0; color: #166534; font-size: 14px;">💡 Sambil menunggu, Anda bisa lihat portfolio kami di <a href="{{ route('portfolio.index') }}" style="color: #1e40af;">sini</a>.</p>
        </div>
    </div>
    <div style="background: #f8fafc; padding: 16px; text-align: center; color: #94a3b8; font-size: 12px;">
        {{ config('app.name') }} · {{ config('app.url') }}
    </div>
</div>
</body>
</html>
