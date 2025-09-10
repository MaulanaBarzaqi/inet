<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{   
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'location',
        'description'
    ];
    
     protected $hidden = [
        //
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'region_id');
    }

    public function nonAdminUsers(): HasMany
    {
        // return $this->hasMany(User::class)->where('is_admin', false);
        return $this->hasMany(User::class)->where('role', '!=', 'admin');
    }

    public function getImageUrlAttribute() 
    {
        return $this->image ? url('storage/' . $this->image) : null;
    }
}
