<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balasan dari ChérieRent</title>
    <style>
        body { font-family: 'Georgia', serif; background: #fdf2f8; margin: 0; padding: 0; }
        .wrapper { max-width: 560px; margin: 40px auto; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 24px rgba(190,24,93,0.08); }
        .header { background: linear-gradient(135deg, #9f1239 0%, #be185d 50%, #db2777 100%); padding: 40px 32px; text-align: center; }
        .header h1 { color: #fff; font-size: 28px; margin: 0 0 6px; letter-spacing: 1px; }
        .header p { color: #fce7f3; font-size: 13px; margin: 0; }
        .body { padding: 36px 32px; color: #3b0a22; }
        .body p { font-size: 15px; line-height: 1.75; margin: 0 0 16px; }
        .original-msg { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 14px 18px; margin: 16px 0; }
        .original-msg p { font-size: 13px; color: #6b7280; margin: 0; white-space: pre-line; }
        .reply-box { background: #fdf2f8; border-left: 4px solid #ec4899; border-radius: 8px; padding: 20px 24px; margin: 20px 0; }
        .reply-box p { margin: 0; font-size: 15px; color: #831843; line-height: 1.8; white-space: pre-line; }
        .btn { display: inline-block; background: linear-gradient(135deg, #be185d, #ec4899); color: #fff !important; text-decoration: none; padding: 14px 32px; border-radius: 50px; font-size: 14px; font-weight: bold; margin: 20px 0; }
        .footer { background: #fdf2f8; border-top: 1px solid #fce7f3; padding: 24px 32px; text-align: center; font-size: 12px; color: #9d174d; }
        .footer a { color: #be185d; text-decoration: none; }
        .divider { height: 1px; background: #fce7f3; margin: 24px 0; }
        .label { font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #be185d; margin-bottom: 8px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>ChérieRent ✿</h1>
            <p>Balasan dari Atelier Concierge</p>
        </div>

        <div class="body">
            <p>Halo, <strong>{{ $contactMessage->name }}</strong> 🌸</p>

            <p>Tim <strong>Atelier Concierge ChérieRent</strong> telah membalas pesan Anda mengenai <strong>"{{ $contactMessage->subject }}"</strong>.</p>

            <div class="label">💌 Balasan dari Admin</div>
            <div class="reply-box">
                <p>{{ $contactMessage->admin_reply }}</p>
            </div>

            <div class="divider"></div>

            <div class="label">📝 Pesan Asal Anda</div>
            <div class="original-msg">
                <p>{{ $contactMessage->message }}</p>
            </div>

            <p>Jika masih ada pertanyaan lain, jangan ragu untuk menghubungi kami kembali atau langsung chat via WhatsApp:</p>

            <div style="text-align:center;">
                <a href="https://wa.me/6289540164390" class="btn">💬 Chat WhatsApp</a>
            </div>

            <div class="divider"></div>

            <p style="font-size:13px; color:#9d174d;">Untuk membalas email ini, kirimkan pesan Anda ke <a href="mailto:rentcherie@gmail.com" style="color:#be185d;">rentcherie@gmail.com</a> 🌷</p>
        </div>

        <div class="footer">
            <p><strong>ChérieRent</strong> — Dress Like a Dream ✨</p>
            <p><a href="mailto:rentcherie@gmail.com">rentcherie@gmail.com</a> · <a href="https://wa.me/6289540164390">WhatsApp</a></p>
            <p style="margin-top:8px; color:#c4b5c0;">Dikirim: {{ $contactMessage->replied_at?->format('d M Y, H:i') }} WIB</p>
        </div>
    </div>
</body>
</html>
