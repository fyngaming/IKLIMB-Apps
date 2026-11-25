<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PsbAlumni extends Model
{
    use HasFactory;

    protected $table = 'psb_alumnis';

    protected $fillable = [
        'user_id',
        'nomor_registrasi',
        'nama_calon_santri',
        'hubungan_keluarga',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'jenjang_pilihan',
        'berkas_rapor',
        'status_seleksi',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
