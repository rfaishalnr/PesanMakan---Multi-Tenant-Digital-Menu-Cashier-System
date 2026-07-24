@auth
    @php
        $user = auth()->user();
        $isStore = $user->role === 'store';
        
        // Cek apakah ada data penting yang masih kosong (QRIS tidak termasuk)
        $isIncomplete = empty($user->store_logo) || 
                        empty($user->phone_number) || 
                        empty($user->address) || 
                        empty($user->bank_name) || 
                        empty($user->bank_account) || 
                        empty($user->bank_account_name);
    @endphp

    @if($isStore && $isIncomplete)
        <div style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; background-color: #FFFBEB; border: 1px solid #FDE68A; border-left: 6px solid #F59E0B; padding: 16px 20px; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); width: calc(100% - 48px); max-width: 380px; font-family: system-ui, -apple-system, sans-serif; pointer-events: auto;">
            
            <div style="display: flex; align-items: flex-start; gap: 14px;">
                <div style="font-size: 24px; line-height: 1.2;">⚠️</div>
                
                <div>
                    <h4 style="margin: 0 0 6px 0; font-size: 15px; font-weight: 700; color: #92400E;">Data Toko Belum Lengkap!</h4>
                    
                    <p style="margin: 0 0 14px 0; font-size: 13px; color: #B45309; line-height: 1.5;">
                        Agar toko Anda dapat menerima pesanan dan menarik dana pencairan secara otomatis, silakan lengkapi <b>Gambar Toko</b> dan <b>Data Rekening Bank</b> Anda.
                    </p>

                    <a href="/admin/store-settings" style="display: inline-block; background-color: #D97706; color: #ffffff; padding: 8px 16px; text-decoration: none; border-radius: 6px; font-size: 12px; font-weight: 700; transition: all 0.2s; box-shadow: 0 2px 4px rgba(217, 119, 6, 0.3);">
                        Lengkapi Sekarang &rarr;
                    </a>
                </div>
            </div>

        </div>
    @endif
@endauth