<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MasterSantri extends Model
{
    use HasFactory;

    protected $table = 'master_santri';

    protected $fillable = [
        'nis',
        'nama_lengkap',
        'angkatan',
        'jenjang_pondok',
        'tahun_masuk',
        'tahun_lulus',
        'tempat_lahir',
        'tanggal_lahir',
        'nama_wali',
        'status_kelulusan',
        'is_registered',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'is_registered' => 'boolean',
        ];
    }

    public function alumniProfile(): HasOne
    {
        return $this->hasOne(AlumniProfile::class);
    }
}
