<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class InternetPackage extends Model
{
    //
    Use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'speed',
        'ideal_device',
        'installation',
        'monthly_bill',
    ];
    protected $hidden = [
        //
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function internetInstallations(): HasMany
    {
        return $this->hasMany(InternetInstallation::class,'internet_package_id');
    }

    
    public function getImageUrlAttribute() 
    {
        return $this->image ? url('storage/' . $this->image) : null;
    }
}
