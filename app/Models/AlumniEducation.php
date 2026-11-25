<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlumniEducation extends Model
{
    use HasFactory;

    protected $table = 'alumni_educations';

    protected $fillable = [
        'alumni_profile_id',
        'jenjang',
        'nama_universitas',
        'program_studi',
        'tahun_masuk',
        'tahun_lulus',
        'gelar',
    ];

    public function alumniProfile(): BelongsTo
    {
        return $this->belongsTo(AlumniProfile::class);
    }
}
