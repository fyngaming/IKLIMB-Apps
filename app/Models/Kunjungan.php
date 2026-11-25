<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kunjungan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kode_kunjungan',
        'qr_visit_token',
        'tanggal_kunjungan',
        'jam_kunjungan',
        'tujuan',
        'pihak_ditemui',
        'jumlah_rombongan',
        'kendaraan',
        'is_menginap',
        'catatan_alumni',
        'status',
        'catatan_petugas',
        'jadwal_ulang_tanggal',
        'jadwal_ulang_jam',
        'checked_in_at',
        'checked_in_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kunjungan' => 'date',
            'jadwal_ulang_tanggal' => 'date',
            'is_menginap' => 'boolean',
            'checked_in_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function securityUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }
}
