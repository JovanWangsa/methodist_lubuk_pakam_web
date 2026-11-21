<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\AturUlangPassword;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_SUPER_ADMIN = 'super_admin';

    public const ROLE_ADMIN_KONTEN = 'admin_konten';

    public const ROLE_ADMIN_PPDB = 'admin_ppdb';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /** Nama peran untuk ditampilkan. */
    public const NAMA_PERAN = [
        self::ROLE_SUPER_ADMIN => 'Super Admin',
        self::ROLE_ADMIN_KONTEN => 'Admin Konten',
        self::ROLE_ADMIN_PPDB => 'Admin PPDB',
    ];

    public function namaPeran(): string
    {
        return self::NAMA_PERAN[$this->role] ?? $this->role;
    }

    /**
     * Kirim email atur ulang password dalam Bahasa Indonesia.
     */
    public function sendPasswordResetNotification(#[\SensitiveParameter] $token): void
    {
        $this->notify(new AturUlangPassword($token));
    }

    public function punyaPeran(string ...$peran): bool
    {
        return in_array($this->role, $peran, true);
    }
}
