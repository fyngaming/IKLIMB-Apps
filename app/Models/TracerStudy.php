<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TracerStudy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tahun_survey',
        'status_kiprah',
        'nama_instansi',
        'pendapatan_rata_rata',
        'keselarasan_ilmu',
        'kontribusi_pondok_feedback',
        'saran_kurikulum',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
