<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DonasiPenyaluran extends Model
{
    use HasFactory;

    protected $table = 'donasi_penyalurans';

    protected $fillable = [
        'donasi_program_id',
        'judul_penyaluran',
        'nominal_disalurkan',
        'tanggal_penyaluran',
        'laporan_kegiatan',
        'foto_dokumentasi',
    ];

    protected function casts(): array
    {
        return [
            'nominal_disalurkan' => 'decimal:2',
            'tanggal_penyaluran' => 'date',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(DonasiProgram::class, 'donasi_program_id');
    }
}
