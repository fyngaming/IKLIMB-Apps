<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgendaRsvp extends Model
{
    use HasFactory;

    protected $table = 'agenda_rsvps';

    protected $fillable = [
        'agenda_reuni_id',
        'user_id',
        'status_kehadiran',
        'jumlah_tamu',
        'catatan',
    ];

    public function agenda(): BelongsTo
    {
        return $this->belongsTo(AgendaReuni::class, 'agenda_reuni_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
