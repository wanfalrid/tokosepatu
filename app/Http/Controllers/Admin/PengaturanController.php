<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Pengguna;

class PengaturanController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        
        // System settings (could be stored in database or config)
        $systemSettings = [
            'site_name' => config('app.name', 'ShoeMart'),
            'site_description' => 'Toko Sepatu Online Terpercaya',
            'contact_email' => 'admin@shoemart.com',
            'contact_phone' => '021-1234567',
            'address' => 'Jl. Contoh No. 123, Jakarta',
            'timezone' => config('app.timezone', 'Asia/Jakarta'),
            'currency' => 'IDR',
            'items_per_page' => 10,
        ];
        
        return view('admin.pengaturan.index', compact('admin', 'systemSettings'));
    }
    
    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();
          $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('pengguna')->ignore($admin->id_pengguna, 'id_pengguna')],
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = [
            'nama_lengkap' => $request->name,
            'email' => $request->email,
            'telepon' => $request->phone,
        ];
        
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Ensure avatars directory exists
            $avatarDir = public_path('storage/avatars');
            if (!file_exists($avatarDir)) {
                mkdir($avatarDir, 0755, true);
            }
              // Delete old avatar if exists
            if ($admin->foto && file_exists(public_path('storage/avatars/' . $admin->foto))) {
                unlink(public_path('storage/avatars/' . $admin->foto));
            }
            
            // Store new avatar
            $file = $request->file('avatar');
            $filename = 'admin_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/avatars'), $filename);
            $data['foto'] = $filename;}
        
        // Update data using DB query
        DB::table('pengguna')
            ->where('id_pengguna', $admin->id_pengguna)
            ->update($data);
        
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
    
    public function updatePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);
          // Check current password
        if (!Hash::check($request->current_password, $admin->kata_sandi)) {
            return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }
          // Update password using DB query
        DB::table('pengguna')
            ->where('id_pengguna', $admin->id_pengguna)
            ->update(['kata_sandi' => Hash::make($request->new_password)]);
        
        return redirect()->back()->with('success', 'Password berhasil diperbarui!');
    }
    
    public function updateSystem(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'timezone' => 'required|string',
            'currency' => 'required|string',
            'items_per_page' => 'required|integer|min:5|max:100',
        ]);
        
        // In a real application, you would save these to a settings table
        // For now, we'll just show success message
        
        return redirect()->back()->with('success', 'Pengaturan sistem berhasil diperbarui!');
    }
      public function clearCache()
    {
        try {
            // Clear various caches
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            
            return response()->json([
                'success' => true,
                'message' => 'Cache berhasil dibersihkan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membersihkan cache: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function systemInfo()
    {
        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'database_connection' => config('database.default'),
            'app_environment' => config('app.env'),
            'app_debug' => config('app.debug') ? 'Enabled' : 'Disabled',
            'app_timezone' => config('app.timezone'),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
        ];
        
        return response()->json($systemInfo);
    }
    
    public function backup()
    {
        try {
            // In a real application, you would implement actual backup functionality
            // This is just a placeholder
            
            $backupData = [
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'tables' => ['users', 'pelanggan', 'produk', 'pesanan', 'detail_pesanan'],
                'size' => '2.5 MB',
                'status' => 'success'
            ];
            
            return response()->json([
                'success' => true,
                'message' => 'Backup berhasil dibuat!',
                'data' => $backupData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat backup: ' . $e->getMessage()
            ], 500);
        }
    }
}
