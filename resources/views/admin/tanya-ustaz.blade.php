@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ showAnswerModal: false, selectedQuestion: {} }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b pb-4 border-slate-200">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-700">&larr; Panel Admin</a>
                <span>/</span>
                <span class="font-bold text-slate-800">Manajemen Tanya Ustaz</span>
            </div>
            <h1 class="text-xl font-black text-slate-900">Konsultasi Keagamaan Alumni PPIB</h1>
            <p class="text-xs text-slate-500">Jawab pertanyaan seputar fiqih, muamalah, aqidah, dan keluarga dari alumni pondok pesantren.</p>
        </div>
    </div>

    <!-- Questions List -->
    <div class="space-y-4">
        @forelse($questions as $q)
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 space-y-3.5 hover:shadow-md transition">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b pb-3 border-slate-100">
                    <div class="flex items-center space-x-2">
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 font-bold text-[10px]">{{ $q->kategori_keilmuan }}</span>
                        <span class="text-[10px] text-slate-400">&bull; {{ $q->created_at->diffForHumans() }}</span>
                        @if($q->is_public)
                            <span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 font-bold text-[9px] inline-flex items-center space-x-1">
                                <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Publik</span>
                            </span>
                        @endif
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ $q->status === 'dijawab' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                        {{ $q->status === 'dijawab' ? 'Sudah Dijawab' : 'Menunggu Jawaban' }}
                    </span>
                </div>

                <div>
                    <h3 class="font-black text-sm text-slate-900">{{ $q->judul_pertanyaan }}</h3>
                    <p class="text-xs text-slate-600 mt-1 leading-relaxed bg-slate-50 p-3 rounded-2xl border border-slate-100">
                        {{ $q->pertanyaan }}
                    </p>
                    <p class="text-[10px] text-slate-400 mt-1.5">
                        Diajukan oleh: <span class="font-semibold text-slate-600">{{ $q->is_anonim ? 'Hamba Allah (Anonim)' : ($q->penanya->name ?? 'Alumni') }}</span>
                    </p>
                </div>

                @if($q->status === 'dijawab')
                    <div class="bg-emerald-50/70 p-4 rounded-2xl border border-emerald-200/80 space-y-1.5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-emerald-950 flex items-center space-x-1.5">
                                <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                                <span>Jawaban Ustaz: {{ $q->nama_ustaz_penjawab }}</span>
                            </span>
                            <span class="text-[10px] text-emerald-700">{{ $q->answered_at ? $q->answered_at->format('d M Y H:i') : '' }}</span>
                        </div>
                        <p class="text-xs text-emerald-900 leading-relaxed whitespace-pre-line">{{ $q->jawaban }}</p>
                    </div>
                @endif

                <div class="pt-2 flex justify-end">
                    <button type="button" @click="selectedQuestion = {
                        id: {{ $q->id }},
                        judul: '{{ addslashes($q->judul_pertanyaan) }}',
                        pertanyaan: '{{ addslashes($q->pertanyaan) }}',
                        ustaz: '{{ addslashes($q->nama_ustaz_penjawab ?? auth()->user()->name) }}',
                        jawaban: '{{ addslashes($q->jawaban ?? '') }}',
                        is_public: {{ $q->is_public ? 'true' : 'false' }}
                    }; showAnswerModal = true" class="px-4 py-2 rounded-xl {{ $q->status === 'dijawab' ? 'bg-slate-100 hover:bg-slate-200 text-slate-700' : 'bg-emerald-800 hover:bg-emerald-900 text-white' }} font-bold text-xs shadow-sm transition">
                        {{ $q->status === 'dijawab' ? 'Edit Jawaban' : 'Tuliskan Jawaban Asatizah' }}
                    </button>
                </div>
            </div>
        @empty
            <div class="bg-white p-8 rounded-3xl border border-slate-200 text-center text-slate-400 text-xs">
                Belum ada pertanyaan konsultasi yang masuk.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-2">
        {{ $questions->links() }}
    </div>

    <!-- MODAL TULIS JAWABAN USTAZ -->
    <div x-show="showAnswerModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100" @click.away="showAnswerModal = false">
            <div class="flex items-center justify-between border-b pb-3">
                <h3 class="font-black text-base text-slate-900">Beri Jawaban Konsultasi Keagamaan</h3>
                <button type="button" @click="showAnswerModal = false" class="text-slate-400 hover:text-slate-600 font-bold text-lg">&times;</button>
            </div>

            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1 text-xs">
                <span class="font-extrabold text-slate-900 block" x-text="selectedQuestion.judul"></span>
                <p class="text-slate-600 leading-relaxed text-[11px]" x-text="selectedQuestion.pertanyaan"></p>
            </div>

            <form :action="'/admin/tanya-ustaz/' + selectedQuestion.id + '/jawab'" method="POST" class="space-y-3.5 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Asatizah / Pengasuh Penjawab <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_ustaz_penjawab" x-model="selectedQuestion.ustaz" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 font-semibold">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Teks Jawaban & Penjelasan Fatwa <span class="text-rose-500">*</span></label>
                    <textarea name="jawaban" x-model="selectedQuestion.jawaban" rows="6" required placeholder="Tuliskan jawaban berdasarkan Al-Qur'an, As-Sunnah, dan pandangan ulama mu'tabar..." class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 leading-relaxed"></textarea>
                </div>

                <div class="flex items-center space-x-2 pt-1">
                    <input type="checkbox" name="is_public" id="is_public" x-model="selectedQuestion.is_public" value="1" class="rounded text-emerald-600 focus:ring-emerald-500">
                    <label for="is_public" class="font-semibold text-slate-700 text-xs">Tampilkan jawaban di halaman publik Tanya Ustaz (Bermanfaat bagi rekan alumni lain)</label>
                </div>

                <div class="pt-3 border-t flex justify-end space-x-2">
                    <button type="button" @click="showAnswerModal = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold shadow-md">Kirimkan Jawaban</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
