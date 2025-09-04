<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class InternetInstallation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'nik',
        'phone',
        'address',
        'status',
        'user_id',
        'internet_package_id',
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'internet_package_id' => 'integer',
    ];

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

    public function internetPackage(): BelongsTo
    {
        return $this->belongsTo(InternetPackage::class, 'internet_package_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
