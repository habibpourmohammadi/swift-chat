<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Logs the user out of the application.
     */
    public function logout(Request $request)
    {
        // Log the user out of the application
        Auth::logout();

        // Invalidate the current session to prevent reuse of session data
        $request->session()->invalidate();

        // Regenerate the CSRF token to protect against cross-site request forgery
        $request->session()->regenerateToken();

        // Redirect the user to the login page
        return redirect()->route("auth.login.page");
    }
}
