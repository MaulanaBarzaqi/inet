<?php

namespace App\Helpers;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryHelper
{
    /**
     * Generate unique slug for internet package
     */
    public static function generateUniqueSlug($name, $excludeId = null)
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        // Gunakan closure untuk query dasar yang bisa digunakan berulang
       $checkSlugExists = function ($slugToCheck) use ($excludeId) {
        $query = Category::where('slug', $slugToCheck);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        return $query->exists();
       };
        // check slug awal dulu
        while ($checkSlugExists($slug)) {
        $slug = $baseSlug . '-' . $counter;
        $counter++;
    }
        return $slug;
    }
}