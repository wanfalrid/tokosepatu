<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggan::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_akun', $request->status);
        }
        
        // Order by creation date
        $pelanggan = $query->orderBy('dibuat_pada', 'desc')->paginate(10);
        
        return view('admin.pelanggan.index', compact('pelanggan'));
    }
    
    public function show($id)
    {
        $pelanggan = Pelanggan::where('id_pelanggan', $id)->firstOrFail();
        
        // Get customer orders count
        $totalPesanan = $pelanggan->pesanan()->count();
        $totalBelanja = $pelanggan->pesanan()->sum('total_harga');
        
        return view('admin.pelanggan.show', compact('pelanggan', 'totalPesanan', 'totalBelanja'));
    }
    
    public function create()
    {
        return view('admin.pelanggan.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggan,email',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'tanggal_lahir' => 'nullable|date',
            'kata_sandi' => 'required|string|min:6|confirmed',
            'status_akun' => 'required|in:aktif,nonaktif,suspended',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = [
            'id_pelanggan' => 'CUST-' . strtoupper(Str::random(8)),
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'kata_sandi' => Hash::make($request->kata_sandi),
            'status_akun' => $request->status_akun,
            'dibuat_pada' => now(),
        ];
          // Handle file upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/avatars'), $filename);
            $data['foto'] = $filename;
        }
        
        Pelanggan::create($data);
        
        return redirect()->route('admin.pelanggan.index')
                        ->with('success', 'Pelanggan berhasil ditambahkan!');
    }
    
    public function edit($id)
    {
        $pelanggan = Pelanggan::where('id_pelanggan', $id)->firstOrFail();
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }
    
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::where('id_pelanggan', $id)->firstOrFail();
          $request->validate([
            'nama' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('pelanggan')->ignore($pelanggan->id_pelanggan, 'id_pelanggan')],
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'tanggal_lahir' => 'nullable|date',
            'status_akun' => 'required|in:aktif,nonaktif,suspended',
            'kata_sandi' => 'nullable|string|min:6|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'status_akun' => $request->status_akun,
        ];
        
        // Update password if provided
        if ($request->filled('kata_sandi')) {
            $data['kata_sandi'] = Hash::make($request->kata_sandi);
        }
          // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($pelanggan->foto && file_exists(public_path('storage/avatars/' . $pelanggan->foto))) {
                unlink(public_path('storage/avatars/' . $pelanggan->foto));
            }
            
            // Store new photo
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/avatars'), $filename);
            $data['foto'] = $filename;
        }
        
        $pelanggan->update($data);
        
        return redirect()->route('admin.pelanggan.index')
                        ->with('success', 'Data pelanggan berhasil diperbarui!');
    }
    
    public function destroy($id)
    {
        $pelanggan = Pelanggan::where('id_pelanggan', $id)->firstOrFail();
        
        // Check if customer has orders
        if ($pelanggan->pesanan()->count() > 0) {
            return response()->json([
                'success' => false, 
                'message' => 'Tidak dapat menghapus pelanggan yang memiliki riwayat pesanan!'
            ], 400);
        }
          // Delete photo if exists
        if ($pelanggan->foto && file_exists(public_path('storage/avatars/' . $pelanggan->foto))) {
            unlink(public_path('storage/avatars/' . $pelanggan->foto));
        }
        
        $pelanggan->delete();
        
        return response()->json([
            'success' => true, 
            'message' => 'Pelanggan berhasil dihapus!'
        ]);
    }
    
    public function toggleStatus(Request $request, $id)
    {
        $pelanggan = Pelanggan::where('id_pelanggan', $id)->firstOrFail();
        
        $newStatus = $pelanggan->status_akun === 'aktif' ? 'nonaktif' : 'aktif';
        $pelanggan->update(['status_akun' => $newStatus]);
          return response()->json([
            'success' => true, 
            'message' => 'Status pelanggan berhasil diubah!',
            'new_status' => $newStatus
        ]);
    }
    
    public function export(Request $request)
    {
        $query = Pelanggan::with('pesanan');
        
        // Apply same filters as index if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status_akun', $request->status);
        }
        
        $pelanggan = $query->orderBy('dibuat_pada', 'desc')->get();
        
        $filename = 'data_pelanggan_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function() use ($pelanggan) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header row
            fputcsv($file, [
                'ID Pelanggan',
                'Nama',
                'Email',
                'Telepon',
                'Alamat',
                'Tanggal Lahir',
                'Status Akun',
                'Total Pesanan',
                'Total Belanja (Rp)',
                'Terdaftar Pada'
            ]);
            
            // Data rows
            foreach ($pelanggan as $customer) {
                $totalPesanan = $customer->pesanan->count();
                $totalBelanja = $customer->pesanan->sum('total_harga');
                
                fputcsv($file, [
                    $customer->id_pelanggan,
                    $customer->nama,
                    $customer->email,
                    $customer->telepon,
                    $customer->alamat,
                    $customer->tanggal_lahir ? $customer->tanggal_lahir->format('Y-m-d') : '',
                    ucfirst($customer->status_akun),
                    $totalPesanan,
                    number_format($totalBelanja, 0, ',', '.'),
                    $customer->dibuat_pada instanceof \Carbon\Carbon 
                        ? $customer->dibuat_pada->format('Y-m-d H:i:s') 
                        : date('Y-m-d H:i:s', strtotime($customer->dibuat_pada))
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,suspend',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:pelanggan,id_pelanggan'
        ]);

        $action = $request->action;
        $ids = $request->ids;
        $count = 0;

        switch ($action) {
            case 'delete':
                // Check if any customer has orders
                $customersWithOrders = Pelanggan::whereIn('id_pelanggan', $ids)
                    ->whereHas('pesanan')
                    ->count();
                
                if ($customersWithOrders > 0) {
                    return response()->json([
                        'success' => false,
                        'message' => "Tidak dapat menghapus {$customersWithOrders} pelanggan yang memiliki riwayat pesanan!"
                    ], 400);
                }

                // Delete photos and customers
                $customers = Pelanggan::whereIn('id_pelanggan', $ids)->get();
                foreach ($customers as $customer) {
                    if ($customer->foto && file_exists(public_path('storage/avatars/' . $customer->foto))) {
                        unlink(public_path('storage/avatars/' . $customer->foto));
                    }
                }
                
                $count = Pelanggan::whereIn('id_pelanggan', $ids)->delete();
                $message = "Berhasil menghapus {$count} pelanggan";
                break;

            case 'activate':
                $count = Pelanggan::whereIn('id_pelanggan', $ids)->update(['status_akun' => 'aktif']);
                $message = "Berhasil mengaktifkan {$count} pelanggan";
                break;

            case 'deactivate':
                $count = Pelanggan::whereIn('id_pelanggan', $ids)->update(['status_akun' => 'nonaktif']);
                $message = "Berhasil menonaktifkan {$count} pelanggan";
                break;

            case 'suspend':
                $count = Pelanggan::whereIn('id_pelanggan', $ids)->update(['status_akun' => 'suspended']);
                $message = "Berhasil mensuspend {$count} pelanggan";
                break;

            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Aksi tidak valid'
                ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'count' => $count
        ]);
    }
}