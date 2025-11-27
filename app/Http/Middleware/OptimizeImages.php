<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OptimizeImages
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Add image optimization headers
        if ($response->headers->get('Content-Type') && strpos($response->headers->get('Content-Type'), 'image/') === 0) {
            $response->headers->set('Cache-Control', 'public, max-age=31536000'); // 1 year
            $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
        }
        
        return $response;
    }
}