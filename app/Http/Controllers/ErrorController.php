<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    /**
     * Show the 403 access denied page
     */
    public function accessDenied(Request $request)
    {
        $message = $request->get('message', 'Halaman tidak tersedia untuk Anda');
        $missingPermissions = $request->get('permissions', []);
        
        return view('pages.errors.403', [
            'message' => $message,
            'missing_permissions' => $missingPermissions
        ]);
    }

    /**
     * Show a general unavailable page message
     */
    public function pageUnavailable()
    {
        return view('pages.errors.403', [
            'message' => 'Halaman tidak tersedia saat ini',
            'missing_permissions' => []
        ]);
    }
}
