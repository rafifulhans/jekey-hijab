<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('auth.login'); // Assuming you have a login view
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:255'],
            'password' => ['required', 'min:8', 'max:255'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended(route('dashboard'));
        }
 
        return back();
    }
    
}
