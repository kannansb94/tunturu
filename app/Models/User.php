<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'role_id',
        'phone',
        'address',
        'kyc_status',
        'aadhaar_path',
        'pan_path',
        'address_proof_path',
        'phone_verified_at',
        'banned_at',
        'last_viewed_sales_at',
        'last_viewed_rentals_at',
    ];

    public function isAdmin(): bool
    {
        if ($this->role_relation) {
            return in_array($this->role_relation->slug, ['admin', 'editor', 'billing']);
        }
        return in_array($this->role, ['admin', 'editor', 'billing']);
    }

    public function isSuperAdmin(): bool
    {
        if ($this->role_relation) {
            return $this->role_relation->slug === 'admin';
        }
        return $this->role === 'admin';
    }

    public function role_relation()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function hasPermission($permission): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if (!$this->role_relation) {
            return false;
        }

        return in_array($permission, $this->role_relation->permissions ?? []);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'banned_at' => 'datetime',
            'last_viewed_sales_at' => 'datetime',
            'last_viewed_rentals_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
