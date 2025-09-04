<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\InternetPackage;

class InternetPackageHelper
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
        $query = InternetPackage::where('slug', $slugToCheck);
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

     /**
     * Generate unique image name for internet package
     */
    public static function generateUniqueImageName($name, $extension)
    {
        $baseName = Str::slug($name);
        $imageName = $baseName . '.' . $extension;
        $counter = 1;

        while (Storage::disk('public')->exists('assets/internet-package/' . $imageName)) {
            $imageName = $baseName . '(' . $counter . ').' . $extension;
            $counter++;
        }
        
        return $imageName;
    }

     /**
     * Delete internet package image if exists
     */
    public static function deleteImage($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            return Storage::disk('public')->delete($imagePath);
        }
        
        return false;
    }

     /**
     * Handle internet package image upload
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
        
        // Simpan file
        $path = $file->storeAs(
            'assets/internet-package',
            $imageName,
            'public'
        );
        
        return $path;
    }
}