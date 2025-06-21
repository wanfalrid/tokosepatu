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
use Exception;

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
    }    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pelanggan,email',
            'nomor_telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'tanggal_lahir' => 'nullable|date|before:today',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $pelanggan = Pelanggan::create([
            'id_pelanggan' => 'CUST-' . strtoupper(Str::random(8)),
            'nama' => $request->nama_lengkap,
            'email' => $request->email,
            'telepon' => $request->nomor_telepon,
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
            'tanggal_lahir' => 'required|date|before:today',
            'password' => 'nullable|string|min:6|confirmed',
            'foto_base64' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
        ];

        if ($request->password) {
            $updateData['kata_sandi'] = Hash::make($request->password);
        }

        // Handle base64 photo upload
        if ($request->foto_base64) {
            try {
                // Remove data:image/jpeg;base64, prefix
                $base64Data = preg_replace('#^data:image/\w+;base64,#i', '', $request->foto_base64);
                $imageData = base64_decode($base64Data);
                
                if ($imageData !== false) {
                    // Delete old photo if exists
                    if ($customer->foto && file_exists(public_path('storage/avatars/' . $customer->foto))) {
                        unlink(public_path('storage/avatars/' . $customer->foto));
                    }
                    
                    // Generate unique filename
                    $fileName = time() . '_' . $customer->id_pelanggan . '.jpg';
                    
                    // Create avatars directory if not exists
                    if (!file_exists(public_path('storage/avatars'))) {
                        mkdir(public_path('storage/avatars'), 0755, true);
                    }
                    
                    // Save the image
                    file_put_contents(public_path('storage/avatars/' . $fileName), $imageData);
                    
                    // Add photo to update data
                    $updateData['foto'] = $fileName;
                }
            } catch (Exception $e) {
                return back()->with('error', 'Gagal mengupload foto profil.');
            }
        }

        // Use query builder to update the record
        Pelanggan::where('id_pelanggan', $customer->id_pelanggan)->update($updateData);
        
        // Refresh the customer data in session
        session()->put([
            'customer_name' => $request->nama,
            'customer_email' => $request->email,
        ]);return back()->with('success', 'Profil berhasil diperbarui!');
    }
    
    /**
     * Upload profile photo
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $customer = Auth::guard('customer')->user();
        
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($customer->foto && file_exists(public_path('storage/avatars/' . $customer->foto))) {
                unlink(public_path('storage/avatars/' . $customer->foto));
            }
            
            // Generate unique filename
            $fileName = time() . '_' . $customer->id_pelanggan . '.' . $request->photo->extension();
            
            // Create avatars directory if not exists
            if (!file_exists(public_path('storage/avatars'))) {
                mkdir(public_path('storage/avatars'), 0755, true);
            }
            
            // Move uploaded file
            $request->photo->move(public_path('storage/avatars'), $fileName);
            
            // Update database
            Pelanggan::where('id_pelanggan', $customer->id_pelanggan)->update(['foto' => $fileName]);
            
            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diupload!',
                'photo_url' => asset('storage/avatars/' . $fileName)
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Gagal mengupload foto profil.'
        ], 400);
    }
    
    /**
     * Delete profile photo
     */
    public function deletePhoto()
    {
        $customer = Auth::guard('customer')->user();
        
        if ($customer->foto) {
            // Delete physical file
            if (file_exists(public_path('storage/avatars/' . $customer->foto))) {
                unlink(public_path('storage/avatars/' . $customer->foto));
            }
            
            // Update database
            Pelanggan::where('id_pelanggan', $customer->id_pelanggan)->update(['foto' => null]);
            
            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil dihapus!'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Tidak ada foto profil untuk dihapus.'
        ], 400);
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
