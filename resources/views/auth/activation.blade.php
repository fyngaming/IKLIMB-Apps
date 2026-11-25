@extends('layouts.auth')

@section('content')
<div class="space-y-4">
    <div class="text-center">
        <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-bold tracking-wide uppercase">
            Aktivasi Akun Alumni
        </span>
        <h2 class="text-lg font-bold text-slate-800 mt-2">Selamat, {{ $user->name }}!</h2>
        <p class="text-xs text-slate-500 mt-1">Pendaftaran Anda telah disetujui oleh Koordinator IKLIMB. Buat kata sandi akun Anda untuk melanjutkan.</p>
    </div>

    <!-- Alumni Card Brief -->
    <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs space-y-1">
        <div class="flex justify-between">
            <span class="text-emerald-700 font-medium">NIS:</span>
            <span class="font-bold text-emerald-950 font-mono">{{ $user->alumniProfile->nis }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-emerald-700 font-medium">WhatsApp:</span>
            <span class="font-bold text-emerald-950 font-mono">{{ $user->no_wa }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-emerald-700 font-medium">Angkatan:</span>
            <span class="font-bold text-emerald-950">{{ $user->alumniProfile->angkatan }}</span>
        </div>
    </div>

    <form action="{{ route('activation.submit', $token) }}" method="POST" class="space-y-3.5">
        @csrf
        <div>
            <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">
                Buat Kata Sandi Baru <span class="text-rose-500">*</span>
            </label>
            <input type="password" name="password" id="password" required minlength="6"
                placeholder="Minimal 6 karakter"
                class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1">
                Ulangi Kata Sandi <span class="text-rose-500">*</span>
            </label>
            <input type="password" name="password_confirmation" id="password_confirmation" required minlength="6"
                placeholder="Ketik ulang kata sandi baru"
                class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        </div>

        <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-emerald-800 to-emerald-700 hover:from-emerald-900 hover:to-emerald-800 text-white font-bold text-sm shadow-md transition transform active:scale-95">
            Aktifkan Akun & Lanjut ke Onboarding
        </button>
    </form>
</div>
@endsection
