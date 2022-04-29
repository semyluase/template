<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserMenu;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login',[
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username'  =>  'required',
            'password'  =>  'required'
        ]);

        $credentials['remember'] = $request->rememberMe;

        // sqlsrv login
        $password = User::getPassword($credentials['username'],$credentials['password']);
        if (Auth::attempt(['username' => $credentials['username'], 'password' => (empty($password)) ? '' : $password[0]->password], $credentials['remember'])) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->with([
            'alert' => 'Username/Password Salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'data'  =>  [
                'status'    =>  true,
                'url'       =>  url('/login')
            ]
        ]);
    }
}
