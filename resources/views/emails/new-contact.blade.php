<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px;">
<div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <div style="background: linear-gradient(135deg, #1e40af, #1e3a8a); padding: 24px; text-align: center;">
        <h1 style="color: #fff; margin: 0; font-size: 20px;">📬 Pesan Baru Masuk</h1>
        <p style="color: #93c5fd; margin: 4px 0 0;">Sindelaras Technology</p>
    </div>
    <div style="padding: 24px;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr><td style="padding: 8px 0; color: #64748b; width: 120px;">Nama</td><td style="padding: 8px 0; font-weight: bold;">{{ $contact->name }}</td></tr>
            <tr><td style="padding: 8px 0; color: #64748b;">Email</td><td style="padding: 8px 0;"><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td></tr>
            <tr><td style="padding: 8px 0; color: #64748b;">Telepon</td><td style="padding: 8px 0;">{{ $contact->phone ?? '-' }}</td></tr>
            <tr><td style="padding: 8px 0; color: #64748b;">Perusahaan</td><td style="padding: 8px 0;">{{ $contact->company ?? '-' }}</td></tr>
            <tr><td style="padding: 8px 0; color: #64748b;">Subjek</td><td style="padding: 8px 0; font-weight: bold;">{{ $contact->subject }}</td></tr>
        </table>
        <div style="background: #f8fafc; border-left: 4px solid #3b82f6; padding: 16px; border-radius: 4px; margin-top: 16px;">
            <p style="margin: 0; color: #334155; line-height: 1.6;">{{ $contact->message }}</p>
        </div>
        <div style="margin-top: 24px; text-align: center;">
            <a href="{{ config('app.url') }}/admin/contacts" style="background: #1e40af; color: #fff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold;">
                Buka Admin Panel
            </a>
        </div>
    </div>
    <div style="background: #f8fafc; padding: 16px; text-align: center; color: #94a3b8; font-size: 12px;">
        {{ config('app.name') }} · {{ config('app.url') }}
    </div>
</div>
</body>
</html>
