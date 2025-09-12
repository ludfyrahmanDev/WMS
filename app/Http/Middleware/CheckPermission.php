<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        $user = $request->user();
        if(request()->has('cv_id')){
            session(['cv_id' => request()->get('cv_id')]);
        }
        // If user is not authenticated, redirect to login
        if (!$user) {
            return redirect()->route('login');
        }

        // If user doesn't have a role, deny access
        if (!$user->role) {
            return response()->view('pages.errors.403', [
                'message' => 'Halaman tidak tersedia. Anda belum memiliki role yang ditentukan.',
                'missing_permissions' => []
            ], 403);
        }

        // If user has super_admin role, allow all access
        if ($user->role->name === 'super_admin') {
            return $next($request);
        }

        // Check if user has any of the required permissions
        $hasPermission = false;
        $missingPermissions = [];
        
        foreach ($permissions as $permission) {
            if ($user->hasPermission($permission)) {
                $hasPermission = true;
                break;
            } else {
                $missingPermissions[] = $permission;
            }
        }

        // If user doesn't have required permissions, show custom 403 page
        if (!$hasPermission) {
            // Log the unauthorized access attempt
            \Log::warning('Unauthorized access attempt', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'role' => $user->role->name ?? 'No Role',
                'requested_url' => $request->fullUrl(),
                'required_permissions' => $permissions,
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip()
            ]);

            return response()->view('pages.errors.403', [
                'message' => 'Halaman tidak tersedia. Anda tidak memiliki izin untuk mengakses halaman ini.',
                'missing_permissions' => $missingPermissions
            ], 403);
        }

        return $next($request);
    }
}
