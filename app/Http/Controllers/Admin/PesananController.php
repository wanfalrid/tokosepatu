<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\TrackingPesanan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PesananController extends Controller
{    public function index()
    {
        $pesanan = Pesanan::with(['pembayaran', 'detailPesanan.produk'])
                          ->orderBy('dibuat_pada', 'desc')
                          ->paginate(10);
        return view('admin.pesanan.index', compact('pesanan'));
    }
      public function show($id)
    {
        $pesanan = Pesanan::with(['detailPesanan.produk', 'pembayaran', 'trackingPesanan', 'pelanggan'])
                          ->where('id_pesanan', $id)
                          ->firstOrFail();
        
        // Debug: Load detail pesanan dengan subtotal
        $pesanan->load(['detailPesanan' => function($query) {
            $query->with('produk');
        }]);
        
        return view('admin.pesanan.show', compact('pesanan'));
    }
      public function updateStatus(Request $request, $id)
    {        $request->validate([
            'status_pesanan' => 'required|in:menunggu,diproses,dikirim,selesai,dibatalkan',
            'keterangan' => 'nullable|string|max:255'
        ]);
        
        $pesanan = Pesanan::where('id_pesanan', $id)->firstOrFail();
        $pesanan->update(['status_pesanan' => $request->status_pesanan]);
        
        // Add tracking record
        TrackingPesanan::create([
            'id_tracking' => 'TRK-' . strtoupper(Str::random(8)),
            'id_pesanan' => $id,
            'status_pengiriman' => $request->status_pesanan,
            'tanggal_update' => now()
        ]);
        
        return response()->json(['success' => true, 'message' => 'Status pesanan berhasil diperbarui!']);
    }
      /**
     * Update nomor resi pesanan
     */
    public function updateResi(Request $request, $id)
    {
        try {
            // Validasi input dengan custom error handling untuk JSON response
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'courier' => 'required|string|max:50',
                'awb' => 'required|string|max:100'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            $pesanan = Pesanan::where('id_pesanan', $id)->first();
            
            if (!$pesanan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan'
                ], 404);
            }
              // Update nomor resi dan courier
            $pesanan->update([
                'nomor_resi' => $request->awb,
                'kurir' => $request->courier
            ]);
            
            // Update status menjadi dikirim jika belum
            if ($pesanan->status_pesanan === 'diproses') {
                $pesanan->update(['status_pesanan' => 'dikirim']);
                
                // Add tracking record
                TrackingPesanan::create([
                    'id_tracking' => 'TRK-' . strtoupper(Str::random(8)),
                    'id_pesanan' => $id,
                    'status_pengiriman' => 'dikirim',
                    'keterangan' => 'Paket telah dikirim dengan nomor resi: ' . $request->awb,
                    'tanggal_update' => now()
                ]);
            }
            
            return response()->json([
                'success' => true, 
                'message' => 'Nomor resi berhasil disimpan!',
                'data' => [
                    'awb' => $request->awb,
                    'courier' => $request->courier,
                    'status' => $pesanan->fresh()->status_pesanan
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
      /**
     * Track package menggunakan API BinderByte
     */
    public function trackPackage($id)
    {
        try {
            $pesanan = Pesanan::where('id_pesanan', $id)->first();
            
            if (!$pesanan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan'
                ], 404);
            }
              if (!$pesanan->nomor_resi || !$pesanan->kurir) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor resi atau kurir belum diatur'
                ]);
            }
            
            $apiKey = '74c214db8373a74d99c63c1ec1404fefde45ab9325f2193b4da5686190e788f3';
            $courier = $pesanan->kurir;
            $awb = $pesanan->nomor_resi;
            
            // Call BinderByte API
            $client = new \GuzzleHttp\Client();
            $response = $client->get('https://api.binderbyte.com/v1/track', [
                'query' => [
                    'api_key' => $apiKey,
                    'courier' => $courier,
                    'awb' => $awb
                ],
                'timeout' => 30,
                'headers' => [
                    'Accept' => 'application/json',
                    'User-Agent' => 'TokoSepatu/1.0'
                ]
            ]);
            
            $data = json_decode($response->getBody(), true);
            
            if ($data && isset($data['status']) && $data['status'] == 200) {
                return response()->json([
                    'success' => true,
                    'tracking' => $data['data']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $data['message'] ?? 'Gagal melacak paket'
                ]);
            }
            
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal terhubung ke API tracking: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
