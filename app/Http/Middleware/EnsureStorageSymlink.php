<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureStorageSymlink
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Ensure storage symlink exists on every request
        // This is a workaround for shared hosting where symlinks might break
        $this->ensureSymlinkExists();
        
        return $next($request);
    }

    /**
     * Ensure the storage symlink exists.
     */
    private function ensureSymlinkExists()
    {
        $link = public_path('storage');
        $target = storage_path('app/public');

        // If symlink doesn't exist, create it
        if (!file_exists($link) || !is_link($link)) {
            // Remove broken symlink if it exists
            if (file_exists($link) || is_link($link)) {
                @unlink($link);
            }

            // Try to create symlink
            @symlink($target, $link);
        }
    }
}
