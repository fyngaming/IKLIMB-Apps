<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AlumniProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'master_santri_id',
        'nis',
        'qr_identity_token',
        'angkatan',
        'jenjang_pondok',
        'tempat_lahir',
        'tanggal_lahir',
        'status_pernikahan',
        'alamat_lengkap',
        'kabupaten_kota',
        'provinsi',
        'negara',
        'latitude',
        'longitude',
        'pekerjaan_lembaga',
        'pekerjaan_divisi',
        'pekerjaan_jabatan',
        'bio',
        'privacy_settings',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'privacy_settings' => 'array',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function masterSantri(): BelongsTo
    {
        return $this->belongsTo(MasterSantri::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(AlumniEducation::class);
    }

    public function canShowWa(): bool
    {
        return $this->privacy_settings['show_wa'] ?? true;
    }

    public function canShowAddress(): bool
    {
        return $this->privacy_settings['show_address'] ?? true;
    }

    public function canShowJob(): bool
    {
        return $this->privacy_settings['show_job'] ?? true;
    }

    public function canShowEducation(): bool
    {
        return $this->privacy_settings['show_education'] ?? true;
    }
}
