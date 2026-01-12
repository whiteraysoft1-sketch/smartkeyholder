<?php

namespace App\Helpers;

class StorageHelper
{
    /**
     * Generate correct storage URL for hosted environments
     */
    public static function getImageUrl($path, $folder = '')
    {
        if (!$path) {
            return null;
        }

        // Ensure path starts with the correct folder
        if ($folder && strpos($path, $folder . '/') !== 0) {
            $path = $folder . '/' . ltrim($path, '/');
        }

        // For hosted environments, use direct URL construction
        if (self::isHostedEnvironment()) {
            $baseUrl = self::getStorageBaseUrl();
            return $baseUrl . '/' . ltrim($path, '/');
        }

        // For local development, use Laravel storage
        return \Storage::disk('public')->url($path);
    }

    /**
     * Check if we're in a hosted environment
     */
    public static function isHostedEnvironment()
    {
        $appUrl = config('app.url', '');
        return str_contains($appUrl, 'smart-keyholder.click') || 
               app()->environment('production') ||
               !empty(env('STORAGE_URL'));
    }

    /**
     * Get the storage base URL
     */
    public static function getStorageBaseUrl()
    {
        // Use STORAGE_URL if set
        if ($storageUrl = env('STORAGE_URL')) {
            return rtrim($storageUrl, '/');
        }

        // Check if we're on Hostinger with file server URL
        $appUrl = rtrim(config('app.url'), '/');
        if (str_contains($appUrl, 'smart-keyholder.click')) {
            // Try to detect Hostinger file server structure
            // This is a fallback if STORAGE_URL is not set
            return 'https://srv1238-files.hstgr.io/11b20f5480f75c32/files/public_html/storage/app/public';
        }

        // For hosted environments, remove /public from app URL and add /storage
        if (str_contains($appUrl, '/public')) {
            $baseUrl = str_replace('/public', '', $appUrl);
            return $baseUrl . '/storage';
        }

        // Default fallback
        return $appUrl . '/storage';
    }

    /**
     * Generate profile image URL
     */
    public static function getProfileImageUrl($imagePath)
    {
        return self::getImageUrl($imagePath, 'profile_images');
    }

    /**
     * Generate background image URL
     */
    public static function getBackgroundImageUrl($imagePath)
    {
        return self::getImageUrl($imagePath, 'background_images');
    }

    /**
     * Generate gallery image URL
     */
    public static function getGalleryImageUrl($imagePath)
    {
        return self::getImageUrl($imagePath, 'gallery_images');
    }

    /**
     * Generate store product image URL
     */
    public static function getStoreProductImageUrl($imagePath)
    {
        return self::getImageUrl($imagePath, 'store_products');
    }
}