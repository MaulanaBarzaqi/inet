<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'role',
        'region_id',
        'fcm_token',
        'internet_installation_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
        ];
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            // generate uuid otomatis
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
        });
    }

    public function internetInstallation(): HasOne
    {
        return $this->hasOne(InternetInstallation::class, 'user_id');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

     /**
     * Specifies the user's FCM tokens
     *
     * @return string|array
     */
    public function routeNotificationForFcm(): string|array|null
    {
        return $this->fcm_token;
    }

     /**
     * Scope untuk mendapatkan user berdasarkan role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope untuk mendapatkan user berdasarkan region
     */
    public function scopeByRegion($query, $regionId)
    {
        return $query->where('region_id', $regionId);
    }

     /**
     * Scope untuk mendapatkan user yang memiliki FCM token
     */
    public function scopeWithValidFcmToken($query)
    {
        return $query->whereNotNull('fcm_token')->where('fcm_token', '!=', '');
    }

}
