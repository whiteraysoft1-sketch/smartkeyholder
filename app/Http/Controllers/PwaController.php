<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PwaController extends Controller
{
    /**
     * Generate PWA manifest for a specific user
     */
    public function manifest($uuid)
    {
        // Find user by QR code UUID
        $qrCode = \App\Models\QrCode::where('uuid', $uuid)->first();
        
        if (!$qrCode || !$qrCode->user || !$qrCode->user->profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        $user = $qrCode->user;
        $profile = $user->profile;

        // Check if PWA is enabled
        if (!$profile->pwa_enabled) {
            return response()->json(['error' => 'PWA not enabled'], 404);
        }

        $manifest = [
            'name' => $profile->pwa_app_name ?: $profile->display_name ?: $user->name,
            'short_name' => $profile->pwa_short_name ?: substr($profile->pwa_app_name ?: $profile->display_name ?: $user->name, 0, 12),
            'description' => $profile->bio ?: 'Digital Profile',
            'start_url' => route('qr.view', $uuid),
            'display' => 'standalone',
            'background_color' => $profile->pwa_background_color ?: '#ffffff',
            'theme_color' => $profile->pwa_theme_color ?: '#000000',
            'orientation' => 'portrait',
            'scope' => route('qr.view', $uuid),
            'lang' => 'en',
            'categories' => ['business', 'social', 'productivity'],
            'icons' => []
        ];

        // Add icons if available
        if ($profile->pwa_icon) {
            $iconUrl = asset('storage/' . $profile->pwa_icon);
            $manifest['icons'] = [
                [
                    'src' => $iconUrl,
                    'sizes' => '192x192',
                    'type' => 'image/png',
                    'purpose' => 'any maskable'
                ],
                [
                    'src' => $iconUrl,
                    'sizes' => '512x512',
                    'type' => 'image/png',
                    'purpose' => 'any maskable'
                ]
            ];
        } else {
            // Default icon
            $manifest['icons'] = [
                [
                    'src' => asset('images/default-pwa-icon-192.png'),
                    'sizes' => '192x192',
                    'type' => 'image/png'
                ],
                [
                    'src' => asset('images/default-pwa-icon-512.png'),
                    'sizes' => '512x512',
                    'type' => 'image/png'
                ]
            ];
        }

        return response()->json($manifest)
            ->header('Content-Type', 'application/manifest+json');
    }

    /**
     * Generate service worker for PWA
     */
    public function serviceWorker($uuid)
    {
        $qrCode = \App\Models\QrCode::where('uuid', $uuid)->first();
        
        if (!$qrCode || !$qrCode->user || !$qrCode->user->profile) {
            return response('// Service worker not available', 404)
                ->header('Content-Type', 'application/javascript');
        }

        $profile = $qrCode->user->profile;

        if (!$profile->pwa_enabled) {
            return response('// PWA not enabled', 404)
                ->header('Content-Type', 'application/javascript');
        }

        $serviceWorker = "
const CACHE_NAME = 'whiteray-profile-{$uuid}-v1';
const urlsToCache = [
    '" . route('qr.view', $uuid) . "',
    '/css/app.css',
    '/js/app.js'
];

self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function(cache) {
                return cache.addAll(urlsToCache);
            })
    );
});

self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request)
            .then(function(response) {
                if (response) {
                    return response;
                }
                return fetch(event.request);
            }
        )
    );
});

self.addEventListener('activate', function(event) {
    event.waitUntil(
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.map(function(cacheName) {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});
";

        return response($serviceWorker)
            ->header('Content-Type', 'application/javascript');
    }
}