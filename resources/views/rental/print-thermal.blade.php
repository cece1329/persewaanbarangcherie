<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resi & Struk Thermal #{{ $rental->rental_code }} - ChérieRent</title>
    <link rel="icon" type="image/png" href="{{ asset('images/web/logodomain.png') }}">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Courier New', Courier, monospace, -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f1f3f5;
            color: #111;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 10px;
            font-size: 12px;
            line-height: 1.35;
        }

        /* Action Bar / Controls for screen */
        .no-print {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 12px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            width: 100%;
            max-width: 480px;
        }

        .btn {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 12px;
            font-weight: 700;
            padding: 8px 16px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: #e11d48;
            color: #fff;
        }
        .btn-primary:hover {
            background: #be123c;
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #cbd5e1;
        }
        .btn-secondary:hover {
            background: #e2e8f0;
        }

        .toggle-label {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
        }

        /* Thermal Container */
        .thermal-wrapper {
            width: 80mm;
            max-width: 100%;
            background: #ffffff;
            padding: 14px 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            transition: width 0.2s ease;
        }

        .width-58mm {
            width: 58mm !important;
            padding: 10px 8px !important;
            font-size: 10.5px !important;
        }

        /* Elements inside Receipt */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }

        .dashed-line {
            border-top: 1px dashed #444;
            margin: 8px 0;
            width: 100%;
        }

        .double-line {
            border-top: 2px solid #222;
            margin: 8px 0;
            width: 100%;
        }

        .brand-title {
            font-size: 15px;
            font-weight: 900;
            letter-spacing: 0.5px;
        }

        .brand-subtitle {
            font-size: 9.5px;
            letter-spacing: 0.8px;
            color: #444;
        }

        .badge-shipping {
            display: inline-block;
            border: 1.5px solid #000;
            padding: 3px 8px;
            font-size: 11px;
            font-weight: 900;
            margin: 6px 0;
            letter-spacing: 0.5px;
        }

        .row-kv {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin: 3px 0;
        }

        .row-kv .k {
            flex-shrink: 0;
            color: #333;
        }

        .row-kv .v {
            text-align: right;
            word-break: break-word;
        }

        .section-box {
            border: 1px solid #444;
            padding: 6px 8px;
            margin: 6px 0;
            border-radius: 4px;
        }

        .section-title {
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            border-bottom: 1px solid #666;
            padding-bottom: 2px;
            margin-bottom: 4px;
        }

        .qr-code-img {
            width: 90px;
            height: 90px;
            margin: 6px auto;
            display: block;
        }

        .cut-notice {
            text-align: center;
            font-size: 9px;
            color: #666;
            margin: 8px 0;
            letter-spacing: 1px;
        }

        /* Print Media Styles */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .thermal-wrapper {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                padding: 4px 6px !important;
            }
            @page {
                size: auto;
                margin: 0mm;
            }
        }
    </style>
</head>
<body>

    <!-- On-screen Action Toolbar -->
    <div class="no-print">
        <button onclick="window.print()" class="btn btn-primary">
            🖨️ Cetak Struk / Resi Thermal
        </button>
        <a href="{{ route('rental.invoice', $rental->rental_code) }}" class="btn btn-secondary">
            📄 Lihat Nota PDF (A4)
        </a>
        <div style="display: flex; align-items: center; gap: 6px;">
            <span class="toggle-label">Ukuran:</span>
            <button type="button" onclick="setWidth('80mm')" id="btn80" class="btn btn-secondary" style="padding: 5px 10px; font-size: 11px; font-weight: bold;">80mm</button>
            <button type="button" onclick="setWidth('58mm')" id="btn58" class="btn btn-secondary" style="padding: 5px 10px; font-size: 11px;">58mm</button>
        </div>
    </div>

    <!-- Thermal Receipt & Shipping Label Container -->
    <div class="thermal-wrapper" id="receiptContainer">

        <!-- Store Header -->
        <div class="text-center">
            <div class="brand-title">CHÉRIERENT ATELIER</div>
            <div class="brand-subtitle">HAUTE COUTURE & VINTAGE GOWN</div>
            <div style="font-size: 9.5px; margin-top: 2px;">Jl. Senopati No. 42, Kebayoran Baru, Jakarta</div>
            <div style="font-size: 9px; color: #555;">WhatsApp: 0812-9988-7766 | IG: @cherierent</div>
        </div>

        <div class="dashed-line"></div>

        <!-- Receipt / Shipment Badge -->
        <div class="text-center">
            <div class="badge-shipping">
                RESI &amp; NOTA SEWA RESMI
            </div>
            <div style="font-size: 12px; font-weight: bold; letter-spacing: 0.5px;">
                #{{ $rental->rental_code }}
            </div>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=CHERIE_RENT_{{ $rental->rental_code }}" alt="QR Code Resi" class="qr-code-img">
            <div style="font-size: 8.5px; color: #555;">Scan QR untuk verifikasi pesanan &amp; return</div>
        </div>

        <div class="dashed-line"></div>

        <!-- General Order Metadata -->
        <div class="row-kv">
            <span class="k">Waktu Order:</span>
            <span class="v font-bold">{{ $rental->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="row-kv">
            <span class="k">Metode Kirim:</span>
            <span class="v font-bold uppercase">{{ $rental->shipping_method === 'delivery' ? 'Express Courier' : 'Atelier Self Pickup' }}</span>
        </div>
        <div class="row-kv">
            <span class="k">Pembayaran:</span>
            <span class="v font-bold uppercase">{{ str_replace('_', ' ', $rental->payment_method) }}</span>
        </div>
        <div class="row-kv">
            <span class="k">Status Sewa:</span>
            <span class="v font-bold uppercase">[{{ $rental->status_label }}]</span>
        </div>

        <div class="dashed-line"></div>

        <!-- Shipping Label Section (Untuk Tempelan Paket Kurir) -->
        <div class="section-box">
            <div class="section-title">📍 TUJUAN PENGIRIMAN (PENERIMA):</div>
            <div style="font-size: 12px; font-weight: bold; margin-bottom: 2px;">
                {{ $rental->user->name }}
            </div>
            <div style="font-size: 11px; font-weight: bold; margin-bottom: 4px;">
                Telp: {{ $rental->user->phone ?? '-' }}
            </div>
            <div style="font-size: 11px; line-height: 1.35; word-break: break-word;">
                {{ $rental->shipping_address }}
            </div>
            @if($rental->notes)
                <div style="margin-top: 5px; padding-top: 4px; border-top: 1px dotted #888; font-size: 10px; font-style: italic;">
                    <strong>Catatan Kurir:</strong> {{ $rental->notes }}
                </div>
            @endif
        </div>

        <div class="dashed-line"></div>

        <!-- Item Detail -->
        <div class="section-title">👗 GAUN YANG DISEWA:</div>
        <div style="margin: 4px 0;">
            <div class="font-bold" style="font-size: 12px;">{{ $rental->dress->name }}</div>
            <div style="font-size: 10.5px; color: #333;">
                Kategori: {{ $rental->dress->category->name ?? 'Haute Couture' }}<br>
                Size: <strong>{{ $rental->dress->size }}</strong> | Warna: <strong>{{ $rental->dress->color }}</strong>
            </div>
        </div>

        <div class="row-kv" style="font-size: 11px; margin-top: 4px;">
            <span class="k">Jadwal Sewa:</span>
            <span class="v font-bold">{{ $rental->start_date->format('d/m/Y') }} - {{ $rental->end_date->format('d/m/Y') }}</span>
        </div>
        <div class="row-kv" style="font-size: 11px;">
            <span class="k">Durasi:</span>
            <span class="v font-bold">{{ $rental->total_days }} Hari</span>
        </div>

        <div class="dashed-line"></div>

        <!-- Payment Breakdown -->
        <div class="row-kv">
            <span class="k">Sewa Gaun:</span>
            <span class="v">Rp {{ number_format($rental->rental_price, 0, ',', '.') }}</span>
        </div>
        <div class="row-kv">
            <span class="k">Deposit Jaminan:</span>
            <span class="v">Rp {{ number_format($rental->deposit_fee, 0, ',', '.') }}</span>
        </div>
        
        <div class="double-line"></div>

        <div class="row-kv" style="font-size: 13px;">
            <span class="k font-bold">TOTAL BAYAR:</span>
            <span class="v font-bold">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
        </div>
        <div class="text-right" style="font-size: 9.5px; color: #444; margin-top: 2px;">
            (Status: LUNAS &amp; TERVERIFIKASI)
        </div>

        <div class="dashed-line"></div>

        <!-- Return & Care Reminder -->
        <div style="font-size: 9px; line-height: 1.35; color: #333; margin: 6px 0;">
            <strong>KETENTUAN PENTING:</strong><br>
            1. Harap kembalikan gaun paling lambat tgl <strong>{{ $rental->end_date->format('d/m/Y') }}</strong>.<br>
            2. Uang jaminan (deposit Rp {{ number_format($rental->deposit_fee, 0, ',', '.') }}) akan ditransfer kembali 100% setelah gaun tiba &amp; lolos inspeksi kebersihan.<br>
            3. <strong>Dilarang mencuci sendiri gaun</strong> (garment cleaning sudah ditangani oleh tim ahli atelier kami).
        </div>

        <div class="cut-notice">
            - - - - [ POTONG &amp; TEMPEL DI PAKET ] - - - -
        </div>

        <div class="text-center" style="font-size: 9px; color: #555; margin-top: 6px;">
            Terima kasih telah mempercayakan busana milestone Anda kepada <strong>ChérieRent Atelier</strong>.
        </div>

    </div>

    <script>
        function setWidth(w) {
            const container = document.getElementById('receiptContainer');
            const btn80 = document.getElementById('btn80');
            const btn58 = document.getElementById('btn58');
            if (w === '58mm') {
                container.classList.add('width-58mm');
                btn58.classList.add('btn-primary');
                btn58.classList.remove('btn-secondary');
                btn80.classList.remove('btn-primary');
                btn80.classList.add('btn-secondary');
            } else {
                container.classList.remove('width-58mm');
                btn80.classList.add('btn-primary');
                btn80.classList.remove('btn-secondary');
                btn58.classList.remove('btn-primary');
                btn58.classList.add('btn-secondary');
            }
        }

        // Auto print jika ada parameter ?autoprint=1
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('autoprint') === '1') {
            window.addEventListener('load', () => {
                setTimeout(() => window.print(), 400);
            });
        }
    </script>
</body>
</html>
