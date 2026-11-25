<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgendaReuni extends Model
{
    use HasFactory;

    protected $table = 'agenda_reunis';

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi',
        'biaya_donasi',
        'kuota',
        'deskripsi',
        'gambar',
        'kontak_person',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'datetime',
            'tanggal_selesai' => 'datetime',
            'biaya_donasi' => 'decimal:2',
        ];
    }

    public function rsvps(): HasMany
    {
        return $this->hasMany(AgendaRsvp::class);
    }
}
