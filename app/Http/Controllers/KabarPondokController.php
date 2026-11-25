<?php

namespace App\Http\Controllers;

use App\Models\KabarPondok;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class KabarPondokController extends Controller
{
    public function index(Request $request): View
    {
        $kategori = $request->query('kategori');

        $query = KabarPondok::whereNotNull('published_at');

        if ($kategori && $kategori !== 'Semua') {
            $query->where('kategori', $kategori);
        }

        $kabarList = $query->orderBy('is_pinned', 'desc')
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        $kategoriList = ['Semua', 'Berita', 'Pengumuman', 'Agenda', 'Prestasi'];

        return view('kabar-pondok.index', compact('kabarList', 'kategoriList', 'kategori'));
    }

    public function show(string $slug): View
    {
        $kabar = KabarPondok::where('slug', $slug)->firstOrFail();

        // Increment view count
        $kabar->increment('views_count');

        $relatedKabar = KabarPondok::where('id', '!=', $kabar->id)
            ->where('kategori', $kabar->kategori)
            ->limit(3)
            ->get();

        return view('kabar-pondok.show', compact('kabar', 'relatedKabar'));
    }

    public function create(): View
    {
        return view('kabar-pondok.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:Berita,Pengumuman,Agenda,Prestasi'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'konten' => ['required', 'string'],
            'gambar' => ['nullable', 'string'],
            'is_pinned' => ['nullable', 'boolean'],
        ]);

        $slug = Str::slug($validated['judul']).'-'.Str::random(5);

        $kabar = KabarPondok::create([
            'user_id' => Auth::id(),
            'judul' => $validated['judul'],
            'slug' => $slug,
            'kategori' => $validated['kategori'],
            'ringkasan' => $validated['ringkasan'] ?? Str::limit(strip_tags($validated['konten']), 150),
            'konten' => $validated['konten'],
            'gambar' => $validated['gambar'] ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=800&q=80',
            'is_pinned' => $request->boolean('is_pinned'),
            'published_at' => now(),
        ]);

        return redirect()->route('kabar-pondok.show', $kabar->slug)->with('success', 'Kabar pondok berhasil diterbitkan!');
    }
}
