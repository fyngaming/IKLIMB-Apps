<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InfoLowonganUsaha extends Model
{
    use HasFactory;

    protected $table = 'info_lowongan_usahas';

    protected $fillable = [
        'user_id',
        'tipe',
        'judul',
        'nama_perusahaan_usaha',
        'bidang_industri',
        'deskripsi',
        'lokasi',
        'kontak_wa',
        'link_website',
        'foto_brosur',
        'is_verified',
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
