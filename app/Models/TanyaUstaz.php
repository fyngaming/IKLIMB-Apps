<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TanyaUstaz extends Model
{
    use HasFactory;

    protected $table = 'tanya_ustazs';

    protected $fillable = [
        'user_id',
        'kategori_keilmuan',
        'judul_pertanyaan',
        'pertanyaan',
        'is_anonim',
        'status',
        'dijawab_oleh',
        'nama_ustaz_penjawab',
        'jawaban',
        'answered_at',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'is_anonim' => 'boolean',
            'is_public' => 'boolean',
            'answered_at' => 'datetime',
        ];
    }

    public function penanya(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ustaz(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dijawab_oleh');
    }
}
