<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KajianMateri extends Model
{
    use HasFactory;

    protected $table = 'kajian_materis';

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'nama_narasumber',
        'media_type',
        'media_url',
        'ringkasan',
        'konten',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }
}
