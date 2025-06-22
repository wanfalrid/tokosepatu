<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::guard('admin')->check()) {
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
        
        // Find admin user
        $admin = Pengguna::where('email', $request->email)
                        ->where('peran', 'admin')
                        ->first();
        
        if ($admin && Hash::check($request->password, $admin->kata_sandi)) {
            Auth::guard('admin')->login($admin);
            
            return redirect()->route('admin.dashboard')
                           ->with('success', 'Selamat datang di Admin Dashboard!');
        }
        
        return back()->withErrors([
            'email' => 'Email atau password salah.'
        ])->withInput();
    }
    
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')
                        ->with('success', 'Berhasil logout dari sistem.');
    }
    
    public function register()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.register');
    }
    
    public function processRegister(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|string|min:6|confirmed',
            'telepon' => 'nullable|string|max:20',
        ]);
        
        // Generate ID admin
        $lastAdmin = Pengguna::where('peran', 'admin')
                            ->orderBy('id_pengguna', 'desc')
                            ->first();
        
        $nextNumber = 1;
        if ($lastAdmin) {
            $lastNumber = (int) substr($lastAdmin->id_pengguna, 3);
            $nextNumber = $lastNumber + 1;
        }
        
        $adminId = 'ADM' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        
        // Create new admin
        $admin = Pengguna::create([
            'id_pengguna' => $adminId,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'kata_sandi' => Hash::make($request->password),
            'peran' => 'admin',
            'telepon' => $request->telepon,
            'dibuat_pada' => now(),
        ]);
        
        // Auto login after register
        Auth::guard('admin')->login($admin);
        
        return redirect()->route('admin.dashboard')
                       ->with('success', 'Akun admin berhasil dibuat! Selamat datang di Admin Dashboard.');
    }
}
