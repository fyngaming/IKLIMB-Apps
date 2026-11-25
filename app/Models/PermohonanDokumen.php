<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermohonanDokumen extends Model
{
    use HasFactory;

    protected $table = 'permohonan_dokumens';

    protected $fillable = [
        'user_id',
        'nomor_permohonan',
        'jenis_dokumen',
        'keperluan',
        'jumlah_eksemplar',
        'metode_pengambilan',
        'alamat_pengiriman',
        'file_lampiran',
        'file_hasil',
        'status',
        'catatan_admin',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
