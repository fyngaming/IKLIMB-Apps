<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DonasiProgram extends Model
{
    use HasFactory;

    protected $table = 'donasi_programs';

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'target_dana',
        'dana_terkumpul',
        'tanggal_berakhir',
        'deskripsi',
        'gambar',
        'is_aktif',
    ];

    protected function casts(): array
    {
        return [
            'target_dana' => 'decimal:2',
            'dana_terkumpul' => 'decimal:2',
            'tanggal_berakhir' => 'date',
            'is_aktif' => 'boolean',
        ];
    }

    public function transaksis(): HasMany
    {
        return $this->hasMany(DonasiTransaksi::class);
    }

    public function penyalurans(): HasMany
    {
        return $this->hasMany(DonasiPenyaluran::class);
    }

    public function getProgressPercentageAttribute(): int
    {
        if ($this->target_dana <= 0) {
            return 0;
        }

        return min(100, (int) round(($this->dana_terkumpul / $this->target_dana) * 100));
    }
}
