<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        if (session()->has('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.login');
    }
    
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        // Simple authentication (in real app, use proper authentication)
        if ($request->email === 'admin@shoemart.com' && $request->password === 'admin123') {
            session()->put('admin_logged_in', true);
            session()->put('admin_name', 'Administrator');
            session()->put('admin_email', $request->email);
            
            return redirect()->route('admin.dashboard')
                           ->with('success', 'Selamat datang di Admin Dashboard!');
        }
        
        return back()->withErrors([
            'email' => 'Email atau password salah.'
        ])->withInput();
    }
    
    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_name', 'admin_email']);
        return redirect()->route('admin.login')
                        ->with('success', 'Berhasil logout dari sistem.');
    }
}
