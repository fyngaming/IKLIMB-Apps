@extends('layouts.app')

@section('content')
<div class="p-4 space-y-4" x-data="scannerApp()">
    
    <!-- Header -->
    <div class="bg-gradient-to-r from-slate-900 to-cyan-950 text-white p-4 rounded-3xl shadow-lg border border-cyan-800/40">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2.5">
                <div class="w-10 h-10 rounded-2xl bg-cyan-800 text-cyan-200 flex items-center justify-center shadow">
                    <svg class="w-5 h-5 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div>
                    <span class="text-[10px] text-cyan-300 font-bold uppercase tracking-wider block">Pos Satpam PPIB</span>
                    <h1 class="text-sm font-extrabold text-white">Scanner Gerbang Keamanan</h1>
                </div>
            </div>
            <span class="px-2.5 py-1 rounded-full bg-cyan-900/80 text-cyan-200 border border-cyan-700 text-[10px] font-bold">
                Role Keamanan
            </span>
        </div>
    </div>

    <!-- Scanner Box -->
    <div class="bg-white p-4 rounded-3xl border border-slate-200 shadow-sm space-y-3">
        <div class="flex items-center justify-between border-b pb-2">
            <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5">
                <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                <span>Pemindai Kamera Web</span>
            </h2>
            <div class="flex items-center space-x-1">
                <button type="button" @click="startScanner()" x-show="!isScanning" class="px-2.5 py-1 rounded-lg bg-cyan-800 text-white font-bold text-xs shadow-sm flex items-center space-x-1">
                    <span>Nyalakan Kamera</span>
                </button>
                <button type="button" @click="stopScanner()" x-show="isScanning" class="px-2.5 py-1 rounded-lg bg-rose-600 text-white font-bold text-xs shadow-sm">
                    Matikan Kamera
                </button>
            </div>
        </div>

        <!-- Camera Viewport with html5-qrcode -->
        <div class="relative bg-slate-950 rounded-2xl overflow-hidden min-h-[220px] flex items-center justify-center border-2 border-slate-800">
            <div id="reader" class="w-full"></div>
            
            <div x-show="!isScanning" class="text-center p-6 space-y-2 text-slate-400">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <p class="text-xs">Kamera scanner belum aktif. Tekan tombol "Nyalakan Kamera" atau gunakan input manual kode tiket di bawah.</p>
            </div>
        </div>

        <!-- Manual Code Input Fallback -->
        <div class="pt-2 border-t border-slate-100">
            <label class="block text-[11px] font-bold text-slate-600 mb-1">Input Manual Kode Tiket / Token Alumni:</label>
            <div class="flex space-x-2">
                <input type="text" x-model="manualCode" placeholder="Contoh: VISIT-XYZ123 / KNJ-... / IKLIMB-..."
                    @keyup.enter="processCode(manualCode)"
                    class="flex-1 px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-cyan-600 uppercase font-mono">
                <button type="button" @click="processCode(manualCode)" :disabled="loading" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl shadow-sm">
                    <span x-show="!loading">Verifikasi</span>
                    <span x-show="loading">...</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Scan Result Card Modal/Box -->
    <div x-show="scanResult" x-cloak class="p-4 bg-white rounded-3xl border-2 border-cyan-500 shadow-xl space-y-3">
        <!-- Result Header -->
        <div class="flex items-center justify-between border-b pb-2">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-xl bg-cyan-100 text-cyan-800 flex items-center justify-center flex-shrink-0">
                    <template x-if="scanResult?.type === 'kunjungan'">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    </template>
                    <template x-if="scanResult?.type !== 'kunjungan'">
                        <svg class="w-4 h-4 text-cyan-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                    </template>
                </div>
                <div>
                    <h3 class="font-extrabold text-sm text-slate-900" x-text="scanResult?.type === 'kunjungan' ? 'Tiket Kunjungan Valid' : 'Identitas Alumni Resmi PPIB'"></h3>
                    <p class="text-[10px] text-slate-500" x-text="scanResult?.data?.nama_alumni"></p>
                </div>
            </div>
            <button @click="scanResult = null" class="text-slate-400 hover:text-slate-700 text-sm font-bold">&times; Tutup</button>
        </div>

        <!-- If Kunjungan -->
        <template x-if="scanResult?.type === 'kunjungan'">
            <div class="space-y-2.5 text-xs">
                <div class="grid grid-cols-2 gap-2 p-2.5 bg-slate-50 rounded-xl">
                    <div>
                        <span class="text-[10px] text-slate-400 block">Kode Kunjungan:</span>
                        <span class="font-mono font-bold text-slate-800" x-text="scanResult.data.kode_kunjungan"></span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 block">Status:</span>
                        <span class="font-bold uppercase text-emerald-700" x-text="scanResult.data.status"></span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 block">Jadwal:</span>
                        <span class="font-semibold text-slate-700" x-text="scanResult.data.tanggal_kunjungan + ' ' + scanResult.data.jam_kunjungan"></span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 block">Rombongan:</span>
                        <span class="font-semibold text-slate-700" x-text="scanResult.data.jumlah_rombongan + ' Orang (' + scanResult.data.kendaraan + ')'"></span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-[10px] text-slate-400 block">Tujuan & Pihak Ditemui:</span>
                        <span class="font-semibold text-slate-800" x-text="scanResult.data.tujuan + ' (' + scanResult.data.pihak_ditemui + ')'"></span>
                    </div>
                </div>

                <!-- Check-In Button -->
                <div x-show="!scanResult.data.checked_in_at">
                    <button type="button" @click="confirmCheckIn(scanResult.data.id)" class="w-full py-2.5 px-4 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs shadow-md transition flex items-center justify-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Konfirmasi Masuk Pos Gerbang (Check-In)</span>
                    </button>
                </div>

                <div x-show="scanResult.data.checked_in_at" class="p-2.5 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-xl text-center font-bold flex items-center justify-center space-x-1.5">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Sudah Check-In pada: <span x-text="scanResult.data.checked_in_at"></span></span>
                </div>
            </div>
        </template>

        <!-- If Identitas Alumni -->
        <template x-if="scanResult?.type === 'identitas'">
            <div class="space-y-2 text-xs">
                <div class="p-2.5 bg-emerald-50 text-emerald-900 rounded-xl border border-emerald-200 space-y-1">
                    <div class="flex justify-between">
                        <span class="text-[10px] text-emerald-700">NIS Santri:</span>
                        <span class="font-mono font-bold" x-text="scanResult.data.nis"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[10px] text-emerald-700">Angkatan:</span>
                        <span class="font-bold" x-text="scanResult.data.angkatan"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[10px] text-emerald-700">Jenjang:</span>
                        <span class="font-semibold" x-text="scanResult.data.jenjang_pondok"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[10px] text-emerald-700">Domisili:</span>
                        <span class="font-semibold" x-text="scanResult.data.domisili"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[10px] text-emerald-700">Pekerjaan:</span>
                        <span class="font-semibold" x-text="scanResult.data.pekerjaan"></span>
                    </div>
                </div>
                <div class="text-[11px] text-center text-emerald-800 font-bold flex items-center justify-center space-x-1.5">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span>Alumni Resmi PPIB Terdaftar di Sistem</span>
                </div>
            </div>
        </template>
    </div>

    <!-- Today's Visits Table -->
    <div class="bg-white p-4 rounded-3xl border border-slate-200 shadow-sm space-y-3">
        <div class="flex items-center justify-between border-b pb-2">
            <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">
                Jadwal Kunjungan Hari Ini ({{ count($todayKunjungans) }})
            </h2>
            <span class="text-[10px] text-slate-400 font-mono">{{ date('d M Y') }}</span>
        </div>

        <div class="space-y-2">
            @forelse($todayKunjungans as $k)
                <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between text-xs">
                    <div>
                        <div class="font-bold text-slate-800">{{ $k->user->name }}</div>
                        <div class="text-[11px] text-slate-500">{{ substr($k->jam_kunjungan, 0, 5) }} WIB &bull; {{ $k->pihak_ditemui }}</div>
                    </div>
                    <div>
                        @if($k->checked_in_at)
                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">
                                Checked-In
                            </span>
                        @else
                            <button type="button" @click="processCode('{{ $k->qr_visit_token }}')" class="px-2 py-1 bg-cyan-800 hover:bg-cyan-900 text-white rounded-lg text-[10px] font-bold">
                                Proses Check-In
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-xs text-center text-slate-500 py-3">Tidak ada jadwal kunjungan untuk hari ini.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection

@push('scripts')
<!-- Include html5-qrcode library -->
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    function scannerApp() {
        return {
            isScanning: false,
            html5QrCode: null,
            manualCode: '',
            loading: false,
            scanResult: null,

            startScanner() {
                this.isScanning = true;
                this.$nextTick(() => {
                    this.html5QrCode = new Html5Qrcode("reader");
                    const config = { fps: 10, qrbox: { width: 220, height: 220 } };

                    this.html5QrCode.start(
                        { facingMode: "environment" },
                        config,
                        (decodedText, decodedResult) => {
                            console.log("QR Terdeteksi: ", decodedText);
                            this.processCode(decodedText);
                            this.stopScanner();
                        },
                        (errorMessage) => {
                            // parse error, ignore per frame
                        }
                    ).catch((err) => {
                        alert("Tidak dapat mengakses kamera: " + err + ". Silakan gunakan input manual kode.");
                        this.isScanning = false;
                    });
                });
            },

            stopScanner() {
                if (this.html5QrCode) {
                    this.html5QrCode.stop().then(() => {
                        this.isScanning = false;
                    }).catch((err) => {
                        console.error(err);
                        this.isScanning = false;
                    });
                } else {
                    this.isScanning = false;
                }
            },

            processCode(code) {
                if (!code || !code.trim()) {
                    alert("Masukkan kode QR atau tiket terlebih dahulu.");
                    return;
                }

                this.loading = true;
                fetch("{{ route('keamanan.verify') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({ code: code.trim() })
                })
                .then(res => res.json())
                .then(data => {
                    this.loading = false;
                    if (data.success) {
                        this.scanResult = data;
                        this.manualCode = '';
                    } else {
                        alert(data.message || "Kode QR tidak valid.");
                    }
                })
                .catch(err => {
                    this.loading = false;
                    alert("Gagal memverifikasi kode: " + err);
                });
            },

            confirmCheckIn(kunjunganId) {
                if (!confirm("Konfirmasi tamu telah tiba di pos gerbang PPIB?")) return;

                fetch(`/keamanan/check-in/${kunjunganId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        if (this.scanResult && this.scanResult.data) {
                            this.scanResult.data.checked_in_at = data.checked_in_at;
                        }
                    } else {
                        alert("Gagal check-in.");
                    }
                })
                .catch(err => alert("Error: " + err));
            }
        }
    }
</script>
@endpush
