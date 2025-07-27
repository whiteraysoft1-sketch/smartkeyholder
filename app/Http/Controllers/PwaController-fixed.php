<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrCode;
use App\Models\UserProfile;

class PwaController extends Controller
{
    /**
     * Generate PWA manifest for a specific user or demo
     */
    public function manifest($uuid = null)
    {
        // Default manifest values
        $manifest = [
            'name' => 'Smart Tag',
            'short_name' => 'SmartTag',
            'description' => 'Digital Profile & Smart Tag',
            'start_url' => '/',
            'display' => 'standalone',
            'background_color' => '#ffffff',
            'theme_color' => '#4F46E5',
            'orientation' => 'portrait',
            'scope' => '/',
            'lang' => 'en',
            'dir' => 'ltr',
            'categories' => ['business', 'productivity', 'social'],
            'icons' => [
                [
                    'src' => asset('images/default-pwa-icon-192.png'),
                    'sizes' => '192x192',
                    'type' => 'image/png',
                    'purpose' => 'any maskable'
                ],
                [
                    'src' => asset('images/default-pwa-icon-512.svg'),
                    'sizes' => '512x512',
                    'type' => 'image/svg+xml',
                    'purpose' => 'any maskable'
                ]
            ]
        ];

        // If UUID is provided and not 'demo', try to get specific user data
        if ($uuid && $uuid !== 'demo') {
            $qrCode = QrCode::where('uuid', $uuid)->first();
            
            if ($qrCode && $qrCode->user) {
                $user = $qrCode->user;
                $profile = $user->profile;
                
                // Only customize manifest if PWA is enabled for this profile
                if ($profile && $profile->pwa_enabled) {
                    // Customize manifest based on user profile
                    $manifest['name'] = $profile->pwa_app_name ?? $profile->display_name ?? $user->name ?? 'Smart Tag';
                    $manifest['short_name'] = $profile->pwa_short_name ?? $this->generateShortName($manifest['name']);
                    $manifest['description'] = $profile->pwa_description ?? $profile->bio ?? 'Digital Profile';
                    $manifest['start_url'] = "/qr/{$uuid}?utm_source=pwa";
                    $manifest['scope'] = "/qr/{$uuid}/";
                    $manifest['theme_color'] = $profile->pwa_theme_color ?? '#4F46E5';
                    $manifest['background_color'] = $profile->pwa_background_color ?? '#ffffff';
                    $manifest['id'] = "smart-tag-{$uuid}";
                    
                    // Clear default icons and add custom ones
                    $manifest['icons'] = [];
                    
                    // Use custom PWA icon if available
                    if ($profile->pwa_icon) {
                        $manifest['icons'][] = [
                            'src' => \Storage::disk('public')->url($profile->pwa_icon),
                            'sizes' => '192x192',
                            'type' => 'image/png',
                            'purpose' => 'any'
                        ];
                        $manifest['icons'][] = [
                            'src' => \Storage::disk('public')->url($profile->pwa_icon),
                            'sizes' => '192x192',
                            'type' => 'image/png',
                            'purpose' => 'maskable'
                        ];
                    }
                    
                    // Use splash icon if available
                    if ($profile->pwa_splash_icon) {
                        $manifest['icons'][] = [
                            'src' => \Storage::disk('public')->url($profile->pwa_splash_icon),
                            'sizes' => '512x512',
                            'type' => 'image/png',
                            'purpose' => 'any'
                        ];
                        $manifest['icons'][] = [
                            'src' => \Storage::disk('public')->url($profile->pwa_splash_icon),
                            'sizes' => '512x512',
                            'type' => 'image/png',
                            'purpose' => 'maskable'
                        ];
                    }
                    
                    // Fallback to profile image if no PWA icons
                    if (empty($manifest['icons']) && $profile->profile_image) {
                        $manifest['icons'][] = [
                            'src' => $profile->full_profile_image_url,
                            'sizes' => '192x192',
                            'type' => 'image/png',
                            'purpose' => 'any maskable'
                        ];
                    }
                    
                    // Fallback to default icons if still empty
                    if (empty($manifest['icons'])) {
                        $manifest['icons'] = [
                            [
                                'src' => asset('images/default-pwa-icon-192.png'),
                                'sizes' => '192x192',
                                'type' => 'image/png',
                                'purpose' => 'any maskable'
                            ],
                            [
                                'src' => asset('images/default-pwa-icon-512.svg'),
                                'sizes' => '512x512',
                                'type' => 'image/svg+xml',
                                'purpose' => 'any maskable'
                            ]
                        ];
                    }
                    
                    // Add shortcuts for profile actions
                    $manifest['shortcuts'] = [
                        [
                            'name' => 'Contact',
                            'short_name' => 'Contact',
                            'description' => 'Contact ' . ($profile->display_name ?? $user->name),
                            'url' => "/qr/{$uuid}#contact",
                            'icons' => [
                                [
                                    'src' => asset('images/pwa-icon-96.png'),
                                    'sizes' => '96x96'
                                ]
                            ]
                        ]
                    ];
                    
                    if ($profile->phone) {
                        $manifest['shortcuts'][] = [
                            'name' => 'Call',
                            'short_name' => 'Call',
                            'description' => 'Call ' . ($profile->display_name ?? $user->name),
                            'url' => "tel:{$profile->phone}",
                            'icons' => [
                                [
                                    'src' => asset('images/pwa-icon-96.png'),
                                    'sizes' => '96x96'
                                ]
                            ]
                        ];
                    }
                }
            }
        }

        return response()->json($manifest)
            ->header('Content-Type', 'application/manifest+json')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Generate service worker for PWA
     */
    public function serviceWorker($uuid = null)
    {
        $cacheName = 'smart-tag-v1.1.0';
        $offlineUrl = '/offline';
        
        if ($uuid && $uuid !== 'demo') {
            $cacheName = "smart-tag-{$uuid}-v1.1.0";
            $offlineUrl = "/qr/{$uuid}/offline";
        }

        $serviceWorkerContent = "
// Smart Tag Service Worker - Enhanced Mobile PWA Version
const CACHE_NAME = '{$cacheName}';
const OFFLINE_URL = '{$offlineUrl}';

// Files to cache for offline functionality
const urlsToCache = [
    '/qr/{$uuid}',
    '/manifest.json',
    '/images/pwa-icon-192.png',
    '/images/pwa-icon-512.png',
    '/images/pwa-icon-192-maskable.png',
    '/images/pwa-icon-512-maskable.png',
    '/images/default-pwa-icon-192.png'
];

// Install event - cache resources
self.addEventListener('install', function(event) {
    console.log('[SW] Installing Service Worker v1.1.0');
    
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function(cache) {
                console.log('[SW] Caching app shell');
                return cache.addAll(urlsToCache);
            })
            .then(function() {
                console.log('[SW] Service Worker installed successfully');
                return self.skipWaiting();
            })
            .catch(function(error) {
                console.error('[SW] Failed to cache resources:', error);
            })
    );
});

// Activate event - clean up old caches
self.addEventListener('activate', function(event) {
    console.log('[SW] Activating Service Worker v1.1.0');
    
    event.waitUntil(
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.map(function(cacheName) {
                    if (cacheName !== CACHE_NAME) {
                        console.log('[SW] Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(function() {
            console.log('[SW] Service Worker activated successfully');
            return self.clients.claim();
        })
    );
});

// Fetch event - serve cached content when offline
self.addEventListener('fetch', function(event) {
    // Skip cross-origin requests
    if (!event.request.url.startsWith(self.location.origin)) {
        return;
    }

    // Handle navigation requests
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request)
                .catch(function() {
                    return caches.match(OFFLINE_URL);
                })
        );
        return;
    }

    // Handle other requests with cache-first strategy
    event.respondWith(
        caches.match(event.request)
            .then(function(response) {
                // Return cached version if available
                if (response) {
                    return response;
                }

                // Otherwise fetch from network
                return fetch(event.request)
                    .then(function(response) {
                        // Don't cache if not a valid response
                        if (!response || response.status !== 200 || response.type !== 'basic') {
                            return response;
                        }

                        // Clone the response
                        var responseToCache = response.clone();

                        // Add to cache for future use
                        caches.open(CACHE_NAME)
                            .then(function(cache) {
                                cache.put(event.request, responseToCache);
                            });

                        return response;
                    })
                    .catch(function() {
                        // If both cache and network fail, show offline page for HTML requests
                        if (event.request.headers.get('accept').includes('text/html')) {
                            return caches.match(OFFLINE_URL);
                        }
                    });
            })
    );
});

// Handle background sync (optional - for future use)
self.addEventListener('sync', function(event) {
    console.log('[SW] Background sync triggered:', event.tag);
    
    if (event.tag === 'background-sync') {
        event.waitUntil(
            // Perform background sync tasks here
            console.log('[SW] Performing background sync')
        );
    }
});

// Handle messages from main thread
self.addEventListener('message', function(event) {
    console.log('[SW] Message received:', event.data);
    
    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
});

console.log('[SW] Service Worker v1.1.0 loaded successfully for profile {$uuid}');
";

        return response($serviceWorkerContent)
            ->header('Content-Type', 'application/javascript')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Generate a short name from the full name
     */
    private function generateShortName($name)
    {
        if (strlen($name) <= 12) {
            return $name;
        }
        
        // Try to use initials or first word
        $words = explode(' ', $name);
        if (count($words) > 1) {
            $initials = '';
            foreach ($words as $word) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
            if (strlen($initials) <= 12) {
                return $initials;
            }
        }
        
        // Fallback to truncated name
        return substr($name, 0, 12);
    }

    /**
     * Update PWA settings from dashboard form
     */
    public function updateDashboardSettings(Request $request)
    {
        $user = auth()->user();
        $profile = $user->profile;

        $validated = $request->validate([
            'pwa_enabled' => 'nullable|boolean',
            'pwa_app_name' => 'required|string|max:45',
            'pwa_short_name' => 'required|string|max:12',
            'pwa_description' => 'nullable|string|max:120',
            'pwa_theme_color' => 'nullable|string|max:16',
            'pwa_background_color' => 'nullable|string|max:16',
            'pwa_icon' => 'nullable|image|mimes:png,jpeg,svg,svg+xml|max:2048',
            'pwa_splash_icon' => 'nullable|image|mimes:png,jpeg,svg,svg+xml|max:4096',
        ]);

        $profile->pwa_enabled = $request->boolean('pwa_enabled');
        $profile->pwa_app_name = $request->input('pwa_app_name');
        $profile->pwa_short_name = $request->input('pwa_short_name');
        $profile->pwa_description = $request->input('pwa_description');
        $profile->pwa_theme_color = $request->input('pwa_theme_color');
        $profile->pwa_background_color = $request->input('pwa_background_color');

        // Handle App Icon upload
        if ($request->hasFile('pwa_icon')) {
            if ($profile->pwa_icon) {
                \Storage::disk('public')->delete($profile->pwa_icon);
            }
            $profile->pwa_icon = $request->file('pwa_icon')->store('pwa/icons', 'public');
        }
        // Remove App Icon
        if ($request->has('remove_app_icon') && $profile->pwa_icon) {
            \Storage::disk('public')->delete($profile->pwa_icon);
            $profile->pwa_icon = null;
        }

        // Handle Splash Icon upload
        if ($request->hasFile('pwa_splash_icon')) {
            if ($profile->pwa_splash_icon) {
                \Storage::disk('public')->delete($profile->pwa_splash_icon);
            }
            $profile->pwa_splash_icon = $request->file('pwa_splash_icon')->store('pwa/splash', 'public');
        }
        // Remove Splash Icon
        if ($request->has('remove_splash_icon') && $profile->pwa_splash_icon) {
            \Storage::disk('public')->delete($profile->pwa_splash_icon);
            $profile->pwa_splash_icon = null;
        }

        $profile->save();

        return redirect()->back()->with('success', 'PWA settings updated successfully!');
    }
}