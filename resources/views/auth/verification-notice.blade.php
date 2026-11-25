@extends('layouts.auth')

@section('content')
<div class="space-y-4 text-center">
    <div class="w-16 h-16 rounded-full bg-amber-100 text-amber-600 mx-auto flex items-center justify-center ring-8 ring-amber-50">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </div>

    <div>
        <h2 class="text-lg font-bold text-slate-800">Akun Menunggu Verifikasi</h2>
        <p class="text-xs text-slate-500 mt-1">Status: <span class="font-bold text-amber-600">Menunggu Persetujuan Koordinator IKLIMB</span></p>
    </div>

    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 text-left text-xs space-y-2">
        <div class="flex justify-between border-b pb-1.5 border-slate-200">
            <span class="text-slate-500">Nama:</span>
            <span class="font-bold text-slate-800">{{ $user->name }}</span>
        </div>
        <div class="flex justify-between border-b pb-1.5 border-slate-200">
            <span class="text-slate-500">WhatsApp:</span>
            <span class="font-bold text-slate-800">{{ $user->no_wa }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-slate-500">NIS:</span>
            <span class="font-bold text-slate-800">{{ $user->alumniProfile->nis ?? '-' }}</span>
        </div>
    </div>

    <p class="text-xs text-slate-600 leading-relaxed">
        Pendaftaran Anda sedang ditinjau. Silakan tunggu link aktivasi yang dikirimkan oleh Koordinator IKLIMB melalui WhatsApp.
    </p>

    <div class="pt-2 flex flex-col space-y-2">
        <a href="{{ route('login.quick', 'koordinator') }}" class="w-full py-2.5 px-3 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white text-xs font-bold shadow border border-emerald-600/80 transition active:scale-95 text-center">
            Masuk sebagai Koordinator (Uji Coba Verifikasi)
        </a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-xs text-slate-500 hover:text-rose-600 font-medium">
            Keluar dari Akun Ini
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
    </div>
</div>
@endsection
