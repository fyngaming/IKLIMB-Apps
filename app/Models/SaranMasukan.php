<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaranMasukan extends Model
{
    use HasFactory;

    protected $table = 'saran_masukans';

    protected $fillable = [
        'user_id',
        'topik',
        'isi_aspirasi',
        'lampiran',
        'status',
        'tanggapan_pondok',
        'ditanggapi_at',
    ];

    protected function casts(): array
    {
        return [
            'ditanggapi_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
