<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('admin/*') || $request->is('admin')) {
            return $next($request);
        }

        try {
            $settings = app('settings');
            if ($settings && $settings->maintenance_mode) {
                return response()->view('errors.503', [], 503);
            }
        } catch (\Exception $e) {
            // Table may not exist in testing, skip
        }

        return $next($request);
    }
}
