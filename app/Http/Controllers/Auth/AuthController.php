<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{    public function showLogin()
    {
        // Redirect jika sudah login
        if (Auth::guard('customer')->check()) {
            return redirect()->route('home');
        }
        
        return view('auth.login');
    }

    public function showRegister()
    {
        // Redirect jika sudah login
        if (Auth::guard('customer')->check()) {
            return redirect()->route('home');
        }
        
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $pelanggan = Pelanggan::where('email', $credentials['email'])->first();

        if ($pelanggan && Hash::check($credentials['password'], $pelanggan->kata_sandi)) {
            Auth::guard('customer')->login($pelanggan);
            
            session()->put([
                'customer_logged_in' => true,
                'customer_id' => $pelanggan->id_pelanggan,
                'customer_name' => $pelanggan->nama,
                'customer_email' => $pelanggan->email,
            ]);

            return redirect()->intended(route('home'))
                           ->with('success', 'Selamat datang, ' . $pelanggan->nama . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.'
        ])->withInput($request->only('email'));
    }

    public function register(Request $request)
    {        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pelanggan,email',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'tanggal_lahir' => 'nullable|date|before:today',
            'password' => 'required|string|min:6|confirmed',        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $pelanggan = Pelanggan::create([
            'id_pelanggan' => 'CUST-' . strtoupper(Str::random(8)),
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'kata_sandi' => Hash::make($request->password),
            'status_akun' => 'aktif',
        ]);

        Auth::guard('customer')->login($pelanggan);
        
        session()->put([
            'customer_logged_in' => true,
            'customer_id' => $pelanggan->id_pelanggan,
            'customer_name' => $pelanggan->nama,
            'customer_email' => $pelanggan->email,
        ]);

        return redirect()->route('home')
                       ->with('success', 'Registrasi berhasil! Selamat datang, ' . $pelanggan->nama . '!');
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        
        session()->forget([
            'customer_logged_in',
            'customer_id', 
            'customer_name',
            'customer_email'
        ]);

        return redirect()->route('home')
                       ->with('success', 'Anda berhasil logout.');
    }

    public function profile()
    {
        $customer = Auth::guard('customer')->user();
        return view('auth.profile', compact('customer'));
    }    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();
          $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pelanggan,email,' . $customer->id_pelanggan . ',id_pelanggan',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'tanggal_lahir' => 'nullable|date|before:today',
            'password' => 'nullable|string|min:6|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_base64' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }        $updateData = [
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
        ];        // Handle photo upload
        if ($request->hasFile('foto') || $request->filled('foto_base64')) {
            // Delete old photo if exists
            if ($customer->foto) {
                $oldPhotoPath = storage_path('app/public/profile_photos/' . $customer->foto);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }
            
            $filename = null;
            
            // Handle base64 image from cropper
            if ($request->filled('foto_base64')) {
                $imageData = $request->foto_base64;
                
                // Remove data:image/jpeg;base64, prefix
                if (strpos($imageData, 'data:image') === 0) {
                    $imageData = substr($imageData, strpos($imageData, ',') + 1);
                }
                
                $imageData = base64_decode($imageData);
                $filename = $customer->id_pelanggan . '_' . time() . '.jpg';
                
                // Create directory if it doesn't exist
                $uploadPath = storage_path('app/public/profile_photos');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                file_put_contents($uploadPath . '/' . $filename, $imageData);
            }
            // Handle regular file upload
            elseif ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = $customer->id_pelanggan . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Create directory if it doesn't exist
                $uploadPath = storage_path('app/public/profile_photos');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                $file->move($uploadPath, $filename);
            }
            
            if ($filename) {
                $updateData['foto'] = $filename;
            }
        }

        if ($request->password) {
            $updateData['kata_sandi'] = Hash::make($request->password);
        }

        // Use query builder to update the record
        Pelanggan::where('id_pelanggan', $customer->id_pelanggan)->update($updateData);
        
        // Refresh the customer data in session
        session()->put([
            'customer_name' => $request->nama,
            'customer_email' => $request->email,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
      /**
     * Delete profile photo
     */
    public function deletePhoto()
    {
        $customer = Auth::guard('customer')->user();
        
        if ($customer->foto) {
            $photoPath = storage_path('app/public/profile_photos/' . $customer->foto);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
            
            Pelanggan::where('id_pelanggan', $customer->id_pelanggan)->update(['foto' => null]);
            
            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Foto profil berhasil dihapus!']);
            }
            
            return back()->with('success', 'Foto profil berhasil dihapus!');
        }
        
        if (request()->expectsJson()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada foto profil untuk dihapus.']);
        }
        
        return back()->with('error', 'Tidak ada foto profil untuk dihapus.');
    }
    
    /**
     * Show customer order history
     */
    public function orders()
    {
        $customer = Auth::guard('customer')->user();
        $orders = Pesanan::with(['detailPesanan.produk', 'pembayaran', 'trackingPesanan'])
                         ->where('id_pelanggan', $customer->id_pelanggan)
                         ->orderBy('tanggal_pesanan', 'desc')
                         ->paginate(10);
        
        return view('auth.orders.index', compact('orders'));
    }
    
    /**
     * Show specific order details
     */
    public function orderDetail($id)
    {
        $customer = Auth::guard('customer')->user();
        $order = Pesanan::with(['detailPesanan.produk', 'pembayaran', 'trackingPesanan'])
                        ->where('id_pesanan', $id)
                        ->where('id_pelanggan', $customer->id_pelanggan)
                        ->firstOrFail();
        
        return view('auth.orders.detail', compact('order'));
    }
    
    /**
     * Show order tracking
     */
    public function orderTracking($id)
    {
        $customer = Auth::guard('customer')->user();
        $order = Pesanan::with(['trackingPesanan'])
                        ->where('id_pesanan', $id)
                        ->where('id_pelanggan', $customer->id_pelanggan)
                        ->firstOrFail();
        
        return view('auth.orders.tracking', compact('order'));
    }
}
