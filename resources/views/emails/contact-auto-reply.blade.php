<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima kasih — ChérieRent</title>
    <style>
        body { font-family: 'Georgia', serif; background: #fdf2f8; margin: 0; padding: 0; }
        .wrapper { max-width: 560px; margin: 40px auto; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 24px rgba(190,24,93,0.08); }
        .header { background: linear-gradient(135deg, #9f1239 0%, #be185d 50%, #db2777 100%); padding: 40px 32px; text-align: center; }
        .header h1 { color: #fff; font-size: 28px; margin: 0 0 6px; letter-spacing: 1px; }
        .header p { color: #fce7f3; font-size: 13px; margin: 0; }
        .body { padding: 36px 32px; color: #3b0a22; }
        .body p { font-size: 15px; line-height: 1.75; margin: 0 0 16px; }
        .highlight { background: #fdf2f8; border-left: 4px solid #ec4899; border-radius: 8px; padding: 16px 20px; margin: 20px 0; }
        .highlight p { margin: 0; font-size: 14px; color: #831843; }
        .btn { display: inline-block; background: linear-gradient(135deg, #be185d, #ec4899); color: #fff !important; text-decoration: none; padding: 14px 32px; border-radius: 50px; font-size: 14px; font-weight: bold; margin: 20px 0; }
        .footer { background: #fdf2f8; border-top: 1px solid #fce7f3; padding: 24px 32px; text-align: center; font-size: 12px; color: #9d174d; }
        .footer a { color: #be185d; text-decoration: none; }
        .divider { height: 1px; background: #fce7f3; margin: 24px 0; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>ChérieRent ✿</h1>
            <p>Atelier Persewaan Gaun Premium</p>
        </div>

        <div class="body">
            <p>Halo, <strong>{{ $contactMessage->name }}</strong> 🌸</p>

            <p>Terima kasih sudah menghubungi <strong>Atelier ChérieRent</strong>! Kami sudah menerima pesan Anda dengan baik.</p>

            <div class="highlight">
                <p><strong>Subjek:</strong> {{ $contactMessage->subject }}</p>
                <p style="margin-top:8px;"><strong>Pesan Anda:</strong></p>
                <p style="margin-top:4px; white-space:pre-line;">{{ $contactMessage->message }}</p>
            </div>

            <p>Tim <strong>Atelier Concierge</strong> kami akan membaca pesan Anda dan memberikan balasan dalam waktu <strong>1×24 jam</strong> pada hari kerja (Senin–Sabtu, 09.00–20.00 WIB).</p>

            <p>Jika Anda memerlukan bantuan segera, Anda juga bisa menghubungi kami melalui WhatsApp:</p>

            <div style="text-align:center;">
                <a href="https://wa.me/6289540164390" class="btn">💬 Chat WhatsApp</a>
            </div>

            <div class="divider"></div>

            <p style="font-size:13px; color:#9d174d;">Email ini dikirim secara otomatis. Mohon jangan membalas email ini langsung — untuk konfirmasi balasan, tunggu email berikutnya dari kami. 🌷</p>
        </div>

        <div class="footer">
            <p><strong>ChérieRent</strong> — Dress Like a Dream ✨</p>
            <p><a href="mailto:rentcherie@gmail.com">rentcherie@gmail.com</a> · <a href="https://wa.me/6289540164390">WhatsApp</a></p>
        </div>
    </div>
</body>
</html>
