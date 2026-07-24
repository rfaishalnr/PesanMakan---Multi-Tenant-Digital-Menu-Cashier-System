<x-filament-panels::page>

    <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border: 1px solid #E5E7EB; display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;"
        class="print-hide">
        <div style="flex: 1; min-width: 250px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">
                Masukkan Nomor / Nama Meja:
            </label>
            <input type="text" wire:model.live="tableNumber" placeholder="Contoh: 1, 5, atau Meja VIP"
                style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 16px; outline: none; transition: border-color 0.2s;"
                onfocus="this.style.borderColor='#FF801A'" onblur="this.style.borderColor='#D1D5DB'">
        </div>
        <button onclick="window.print()"
            style="background: #FF801A; color: white; border: none; padding: 14px 28px; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 16px; transition: background 0.2s;"
            onmouseover="this.style.background='#E67317'" onmouseout="this.style.background='#FF801A'">
            Cetak QR
        </button>
    </div>

    <div style="margin-top: 40px; display: flex; justify-content: center;" class="print-container">
        @if ($tableNumber)
            <div style="background: white; border: 3px dashed #D1D5DB; border-radius: 24px; padding: 40px 20px; text-align: center; width: 100%; max-width: 450px;"
                class="print-card">

                <h2
                    style="font-size: 36px; font-weight: 900; color: #111827; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 1px;">
                    MEJA {{ $tableNumber }}
                </h2>

                <img src="https://api.qrserver.com/v1/create-qr-code/?size=350x350&data={{ urlencode($this->storeUrl . '?table=' . $tableNumber) }}"
                    alt="QR Meja {{ $tableNumber }}"
                    style="width: 280px; height: 280px; margin: 0 auto 24px auto; display: block; border-radius: 8px;">

                <p style="font-size: 18px; color: #6B7280; line-height: 1.6; margin: 0;">
                    Scan untuk memesan di <br>
                    <strong style="font-size: 24px; color: #111827;">{{ auth()->user()->name }}</strong>
                </p>

            </div>
        @endif
    </div>

    <style>
        @media print {
            @page {
                margin: 0;
                size: portrait;
            }

            body {
                background-color: white !important;
            }

            /* Sembunyikan semua elemen dashboard Filament */
            .fi-sidebar,
            .fi-topbar,
            header,
            aside,
            .print-hide,
            .fi-breadcrumbs {
                display: none !important;
            }

            .fi-main {
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
            }

            /* Pusatkan QR Code di tengah kertas HVS */
            .print-container {
                margin-top: 0 !important;
                height: 100vh !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }

            /* Perbesar ukuran & buang garis putus-putus saat diprint */
            .print-card {
                border: none !important;
                transform: scale(1.4);
            }
        }
    </style>

</x-filament-panels::page>
