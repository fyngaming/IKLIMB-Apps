@extends('layouts.app')

@section('content')
<div class="p-4 lg:p-6 space-y-4 text-center">

    <div class="max-w-md mx-auto space-y-4">
        <div class="space-y-1">
            <h1 class="text-lg font-extrabold text-slate-900">{{ $user->role === 'koordinator' ? 'Kartu Digital Koordinator' : 'Kartu Alumni Digital' }}</h1>
            <p class="text-xs text-slate-500">{{ $user->role === 'koordinator' ? 'Tunjukkan QR Code ini sebagai identitas pengurus koordinator resmi IKLIMB PPIB.' : 'Tunjukkan QR Code ini di pos keamanan saat berkunjung ke Pondok Pesantren PPIB.' }}</p>
        </div>

        <!-- Digital Alumni Card Design (Premium Islamic Emerald & Gold Theme) -->
        <div id="kartu-alumni-card" class="w-full bg-gradient-to-br from-emerald-950 via-emerald-900 to-emerald-950 text-white rounded-3xl p-5 shadow-2xl relative overflow-hidden border-2 border-gold-400 text-left">
            
            <!-- Ornaments -->
            <div class="absolute -right-12 -top-12 w-40 h-40 bg-gold-400/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -left-12 -bottom-12 w-40 h-40 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
            
            <!-- Card Header -->
            <div class="flex items-center justify-between pb-3 border-b border-gold-400/30 relative z-10">
                <div class="flex items-center space-x-2.5">
                    <div class="w-11 h-11 rounded-xl bg-white p-1 border border-gold-400 flex items-center justify-center shadow">
                        <img src="/images/logo-ppib.png" alt="Logo PPIB" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h2 class="font-extrabold text-sm text-gold-300 tracking-wide uppercase">IKLIMB PPIB</h2>
                        <p class="text-[9px] text-emerald-200">{{ $user->role === 'koordinator' ? 'Kartu Tanda Pengurus Koordinator' : 'Kartu Tanda Anggota Alumni Resmi' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="px-2 py-0.5 rounded-full bg-gold-400/20 text-gold-300 border border-gold-400/40 text-[9px] font-bold uppercase tracking-wider">
                        {{ $user->role === 'koordinator' ? 'Koordinator Resmi' : 'Official Member' }}
                    </span>
                </div>
            </div>

            <!-- Card Body with QR Code -->
            <div class="my-4 flex flex-col items-center justify-center relative z-10">
                <!-- QR Container -->
                <div class="p-3 bg-white rounded-2xl shadow-xl border-4 border-gold-400/80">
                    <div class="w-44 h-44 flex items-center justify-center">
                        {!! $qrSvg !!}
                    </div>
                </div>
                
                <div class="mt-2 text-center">
                    <span class="text-[10px] text-emerald-300 font-mono tracking-widest block uppercase">{{ $user->role === 'koordinator' ? 'ID TOKEN KOORDINATOR' : 'ID TOKEN ALUMNI' }}</span>
                    <span class="font-mono text-xs font-bold text-gold-300 tracking-wider">{{ $profile->qr_identity_token }}</span>
                </div>
            </div>

            <!-- Card Member Details -->
            <div class="pt-3 border-t border-gold-400/30 text-xs relative z-10 space-y-1.5">
                <div>
                    <span class="text-[10px] text-emerald-300 uppercase tracking-wider block">Nama Lengkap</span>
                    <span class="font-bold text-sm text-white">{{ $user->name }}</span>
                </div>

                <div class="grid grid-cols-2 gap-2 pt-1 text-[11px]">
                    @if($user->role === 'koordinator')
                        <div>
                            <span class="text-[9px] text-emerald-300 uppercase block">Peran / Jabatan</span>
                            <span class="font-bold text-gold-300">Koordinator Angkatan</span>
                        </div>
                        <div>
                            <span class="text-[9px] text-emerald-300 uppercase block">Afiliasi</span>
                            <span class="font-semibold text-white">Pengurus IKLIMB</span>
                        </div>
                        <div>
                            <span class="text-[9px] text-emerald-300 uppercase block">Lembaga</span>
                            <span class="font-semibold text-white">Ponpes PPIB</span>
                        </div>
                        <div>
                            <span class="text-[9px] text-emerald-300 uppercase block">Status</span>
                            <span class="font-bold text-emerald-300 flex items-center space-x-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block"></span>
                                <span>Koordinator Aktif</span>
                            </span>
                        </div>
                    @else
                        <div>
                            <span class="text-[9px] text-emerald-300 uppercase block">NIS Santri</span>
                            <span class="font-mono font-bold text-gold-300">{{ $profile->nis ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-[9px] text-emerald-300 uppercase block">Angkatan</span>
                            <span class="font-semibold text-white">{{ $profile->angkatan ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-[9px] text-emerald-300 uppercase block">Jenjang Pondok</span>
                            <span class="font-semibold text-white">{{ $profile->jenjang_pondok ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-[9px] text-emerald-300 uppercase block">Status</span>
                            <span class="font-bold text-emerald-300 flex items-center space-x-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block"></span>
                                <span>Aktif Terdaftar</span>
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Bottom Card Seal -->
            <div class="mt-4 pt-2.5 border-t border-emerald-800/80 flex items-center justify-between text-[9px] text-emerald-300">
                <span>Pondok Pesantren PPIB</span>
                <span>Diterbitkan: {{ date('Y') }}</span>
            </div>
        </div>

        <!-- Actions -->
        <div class="grid grid-cols-2 gap-2 pt-1">
            <button onclick="window.print()" class="py-2.5 px-3 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs flex items-center justify-center space-x-1.5 shadow transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak Kartu</span>
            </button>

            <a href="{{ route('kunjungan.create') }}" class="py-2.5 px-3 rounded-xl bg-gradient-to-r from-emerald-800 to-emerald-700 hover:from-emerald-900 text-white font-bold text-xs flex items-center justify-center space-x-1.5 shadow transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Rencana Kunjungan</span>
            </a>
        </div>
    </div>

</div>
@endsection
