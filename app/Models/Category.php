<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{     
      
    Use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    protected $hidden = [
        //
    ];

    public function internetPackages(): HasMany
    {
        return $this->hasMany(InternetPackage::class);
    }
}
