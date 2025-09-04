<?php

namespace App\Helpers;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerHelper
{
     /**
     * Generate unique slug for banner
     */
    public static function generateUniqueSlug($title, $excludeId = null)
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        // closure
        $checkSlugExists = function ($slugToCheck) use ($excludeId) {
            $query = Banner::where('slug', $slugToCheck);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            return $query->exists();
        };
        // check slug
        while ($checkSlugExists($slug)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        return $slug;
    }

    /**
     * Generate unique image name for banner
     */
    public static function generateUniqueImageName($title, $extension)
    {
        
        $baseName = Str::slug($title);
        $imageName = $baseName . '.' . $extension;
        $counter = 1;

        while (Storage::disk('public')->exists('assets/banner/' . $imageName)) {
            $imageName = $baseName . '(' . $counter . ').' . $extension;
            $counter++;
        }
        
        return $imageName;
    }

     /**
     * Delete banner image if exists
     */
    public static function deleteImage($imagePath)
    {
         if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            return Storage::disk('public')->delete($imagePath);
        }
        
        return false;
    }

     /**
     * Handle banner image upload
     */
    public static function handleImageUpload($file, $title, $currentImage = null)
    {
        // Hapus image lama jika ada
        if ($currentImage && Storage::disk('public')->exists($currentImage)) {
            Storage::disk('public')->delete($currentImage);
        }

        // Generate nama file baru
        $extension = $file->getClientOriginalExtension();
        $imageName = self::generateUniqueImageName($title, $extension);
        
        // Simpan file
        $path = $file->storeAs(
            'assets/banner',
            $imageName,
            'public'
        );
        
        return $path;
    }
}