<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\TrackingPesanan;
use Illuminate\Support\Str;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['pembayaran', 'detailPesanan.produk'])
                          ->orderBy('tanggal_pesanan', 'desc')
                          ->paginate(10);
        return view('admin.pesanan.index', compact('pesanan'));
    }
    
    public function show($id)
    {
        $pesanan = Pesanan::with(['detailPesanan.produk', 'pembayaran', 'trackingPesanan'])
                          ->where('id_pesanan', $id)
                          ->firstOrFail();
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
}
