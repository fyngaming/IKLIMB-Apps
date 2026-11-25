<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DonasiTransaksi extends Model
{
    use HasFactory;

    protected $table = 'donasi_transaksis';

    protected $fillable = [
        'donasi_program_id',
        'user_id',
        'nama_donatur',
        'no_wa_donatur',
        'nominal',
        'bukti_transfer',
        'is_anonim',
        'status',
        'doa_harapan',
    ];

    protected function casts(): array
    {
        return [
            'nominal' => 'decimal:2',
            'is_anonim' => 'boolean',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(DonasiProgram::class, 'donasi_program_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
