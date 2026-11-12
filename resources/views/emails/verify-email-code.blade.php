<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi ChérieRent</title>
</head>
<body style="margin: 0; padding: 24px 12px; background-color: #fcf8fa; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #27272a;">
    <div style="max-width: 520px; margin: 0 auto; background-color: #ffffff; border: 1px solid #f9bec7; border-radius: 24px; padding: 32px 24px; box-shadow: 0 4px 20px rgba(244, 63, 94, 0.06); text-align: center;">

        {{-- Brand Header --}}
        <div style="margin-bottom: 24px; text-align: center;">
            <img src="{{ asset('images/web/logodomain.png') }}" alt="ChérieRent Logo" width="64" height="64" style="display: block; width: 64px; height: 64px; object-fit: contain; margin: 0 auto 10px auto;" />
            <h2 style="font-family: Georgia, 'Times New Roman', serif; font-size: 26px; font-weight: bold; color: #18181b; margin: 0; letter-spacing: -0.5px;">ChérieRent</h2>
            <p style="font-size: 10px; text-transform: uppercase; letter-spacing: 2.5px; color: #e05269; font-weight: bold; margin: 4px 0 0 0;">Couture & Rental Atelier</p>
        </div>

        <div style="border-top: 1px solid #ffe4ec; margin-bottom: 24px;"></div>

        {{-- Greeting --}}
        <h1 style="font-size: 20px; font-weight: bold; color: #18181b; margin-bottom: 8px;">
            Halo, {{ $recipientName }}!
        </h1>
        <p style="font-size: 13px; line-height: 1.6; color: #52525b; margin: 0 0 20px 0;">
            Terima kasih telah bergabung di ChérieRent. Gunakan kode verifikasi di bawah ini untuk mengaktifkan akunmu:
        </p>

        {{-- Big 6-Digit OTP Box --}}
        <div style="background-color: #fff0f4; border: 2px dashed #f9bec7; border-radius: 18px; padding: 20px 16px; margin: 24px 0;">
            <div style="font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; color: #e05269; margin-bottom: 8px;">
                KODE VERIFIKASI AKUN ANDA
            </div>
            <div style="font-size: 38px; font-weight: bold; letter-spacing: 10px; color: #9f1239; font-family: 'Courier New', Courier, monospace; margin: 4px 0;">
                {{ $otpCode }}
            </div>
            <p style="font-size: 11px; color: #71717a; margin: 8px 0 0 0;">
                Kode ini berlaku selama <strong>2 jam</strong>. Jangan berikan kode ini kepada siapa pun.
            </p>
        </div>

        {{-- Alternative Click Link --}}
        <p style="font-size: 12px; color: #71717a; margin: 24px 0 12px 0;">
            Atau cukup klik tombol di bawah untuk verifikasi otomatis:
        </p>

        <a href="{{ $verificationUrl }}" style="display: inline-block; background-color: #e05269; color: #ffffff; font-size: 13px; font-weight: bold; text-decoration: none; padding: 13px 32px; border-radius: 9999px; letter-spacing: 0.5px; box-shadow: 0 4px 12px rgba(224, 82, 105, 0.25);">
            Verifikasi Akun Saya &rarr;
        </a>

        <div style="border-top: 1px solid #ffe4ec; margin-top: 32px; padding-top: 20px; text-align: center;">
            <p style="font-size: 11px; color: #a1a1aa; line-height: 1.5; margin: 0 0 4px 0;">
                Jika kamu tidak merasa mendaftar di ChérieRent Atelier, abaikan email ini.
            </p>
            <p style="font-size: 10px; color: #a1a1aa; margin: 0;">
                ChérieRent Atelier • Jl. Flower Ribbon No. 12, Jakarta Selatan<br>
                Concierge: +62 895-4016-43905 • support@cherierent.com
            </p>
        </div>

    </div>
</body>
</html>

