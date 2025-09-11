<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnhancedPermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        $user = $request->user();

        // If user is not authenticated, redirect to login
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Silakan login terlebih dahulu',
                    'error' => 'Unauthenticated'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // If user doesn't have a role, deny access
        if (!$user->role) {
            return $this->accessDeniedResponse($request, 'Anda belum memiliki role yang ditentukan');
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

        if (!$hasPermission) {
            $message = 'Halaman tidak tersedia. Anda tidak memiliki izin untuk mengakses halaman ini.';
            return $this->accessDeniedResponse($request, $message, $missingPermissions);
        }

        return $next($request);
    }

    /**
     * Return access denied response
     */
    private function accessDeniedResponse(Request $request, string $message, array $missingPermissions = [])
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'error' => 'Access Denied',
                'missing_permissions' => $missingPermissions
            ], 403);
        }

        return response()->view('pages.errors.403', [
            'message' => $message,
            'missing_permissions' => $missingPermissions
        ], 403);
    }
}
