<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InternetInstallation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
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

    public function internetPackage(): BelongsTo
    {
        return $this->belongsTo(InternetPackage::class, 'internet_package_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
