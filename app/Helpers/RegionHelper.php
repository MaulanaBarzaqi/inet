<?php

namespace App\Helpers;

use App\Models\Region;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\InternetPackage;

class RegionHelper
{
     /**
     * Generate unique slug for region
     */
    public static function generateUniqueSlug($name, $excludeId = null)
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        $query = Region::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        while ($query->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;

            $query = Region::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }
        return $slug;
    }

    /**
     * Generate unique image name for region
     */
    public static function generateUniqueImageName($name, $extension)
    {
        $baseName = Str::slug($name);
        $imageName = $baseName . '.' . $extension;
        $counter = 1;

        while (Storage::disk('public')->exists('assets/region/' . $imageName)) {
            $imageName = $baseName . '(' . $counter . ').' . $extension;
            $counter++;
        }
        
        return $imageName;
    }

    /**
     * Delete region image if exists
     */
    public static function deleteImage($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            return Storage::disk('public')->delete($imagePath);
        }
        
        return false;
    }

    /**
     * Handle region image upload
     */
    public static function handleImageUpload($file, $name, $currentImage = null)
    {
        // Hapus image lama jika ada
        if ($currentImage && Storage::disk('public')->exists($currentImage)) {
            Storage::disk('public')->delete($currentImage);
        }
        // Generate nama file baru
        $extension = $file->getClientOriginalExtension();
        $imageName = self::generateUniqueImageName($name, $extension);
        // Simpan file ke folder assets/region
        $path = $file->storeAs(
            'assets/region',
            $imageName,
            'public'
        );
        
        return $path;
    }
}