<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'no_wa',
        'email',
        'password',
        'role',
        'status',
        'is_first_login',
        'activation_token',
        'activation_expires_at',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'activation_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'activation_expires_at' => 'datetime',
            'is_first_login' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function alumniProfile(): HasOne
    {
        return $this->hasOne(AlumniProfile::class);
    }

    public function kunjungans(): HasMany
    {
        return $this->hasMany(Kunjungan::class);
    }

    public function permohonanDokumens(): HasMany
    {
        return $this->hasMany(PermohonanDokumen::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKoordinator(): bool
    {
        return $this->role === 'koordinator' || $this->role === 'admin';
    }

    public function isKeamanan(): bool
    {
        return $this->role === 'keamanan' || $this->role === 'admin';
    }

    public function isAlumni(): bool
    {
        return $this->role === 'alumni';
    }

    public function isVerified(): bool
    {
        return $this->status === 'aktif';
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Super Administrator',
            'koordinator' => 'Koordinator Angkatan',
            'keamanan' => 'Pos Keamanan Satpam',
            default => 'Alumni PPIB',
        };
    }

    public function getRoleSubtitleAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Super Administrator • Pengelola Sistem Terpadu PPIB',
            'koordinator' => 'Koordinator Wilayah & Pengurus IKLIMB PPIB',
            'keamanan' => 'Petugas Jaga Gerbang & Verifikasi Tiket Kunjungan',
            default => 'Alumni Terdaftar Pondok Pesantren Imam Bukhari',
        };
    }

    public function getStatusBadgeLabelAttribute(): string
    {
        if ($this->status !== 'aktif') {
            return 'Menunggu Verifikasi';
        }

        return match ($this->role) {
            'admin' => 'Super Admin Aktif',
            'koordinator' => 'Koordinator Aktif',
            'keamanan' => 'Petugas Siaga',
            default => 'Alumni Terverifikasi',
        };
    }
}
