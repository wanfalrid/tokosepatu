<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Pembayaran;
use App\Models\TrackingPesanan;
use App\Models\Produk;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }
        
        // Get customer data if logged in
        $customer = Auth::guard('customer')->user();
        
        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['quantity'];
        }
        
        $tax = $subtotal * 0.11; // 11% tax
        $shipping = 0; // Free shipping
        $total = $subtotal + $tax + $shipping;
        
        return view('checkout.index', compact('cart', 'subtotal', 'tax', 'shipping', 'total', 'customer'));
    }
      public function store(Request $request)
    {        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'kota' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10',
            'metode_pembayaran' => 'required|in:transfer,cod,ewallet',
        ]);
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }
        
        // Get customer data if logged in
        $customer = Auth::guard('customer')->user();
        
        DB::beginTransaction();
        
        try {
            // Calculate totals
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['harga'] * $item['quantity'];
            }
            
            $tax = $subtotal * 0.11;
            $shipping = 0;
            $total = $subtotal + $tax + $shipping;
            
            // Create order
            $pesanan = Pesanan::create([
                'id_pesanan' => 'ORD-' . strtoupper(Str::random(8)),
                'id_pelanggan' => $customer ? $customer->id_pelanggan : null, // Link to customer if logged in
                'tanggal_pesanan' => now(),
                'status_pesanan' => 'pending',
                'total_harga' => $total,
                'alamat_pengiriman' => $request->alamat . ', ' . $request->kota . ' ' . $request->kode_pos,
                'nama_penerima' => $request->nama_lengkap,
                'telepon_penerima' => $request->telepon,
                'email_penerima' => $request->email,
            ]);
            
            // Create order details
            foreach ($cart as $item) {
                DetailPesanan::create([
                    'id_detail' => 'DTL-' . strtoupper(Str::random(8)),
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_produk' => $item['id_produk'],
                    'jumlah' => $item['quantity'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['quantity'],
                ]);
                
                // Update product stock
                $produk = Produk::find($item['id_produk']);
                if ($produk) {
                    $produk->stok -= $item['quantity'];
                    $produk->save();
                }
            }
            
            // Create payment record
            $pembayaran = Pembayaran::create([
                'id_pembayaran' => 'PAY-' . strtoupper(Str::random(8)),
                'id_pesanan' => $pesanan->id_pesanan,
                'metode_pembayaran' => $request->metode_pembayaran,
                'jumlah_bayar' => $total,
                'status_pembayaran' => $request->metode_pembayaran === 'cod' ? 'pending' : 'awaiting_payment',
                'tanggal_pembayaran' => $request->metode_pembayaran === 'cod' ? null : now(),
            ]);
            
            // Create tracking record
            TrackingPesanan::create([
                'id_tracking' => 'TRK-' . strtoupper(Str::random(8)),
                'id_pesanan' => $pesanan->id_pesanan,
                'status_tracking' => 'order_placed',
                'keterangan' => 'Pesanan berhasil dibuat',
                'tanggal_update' => now(),
            ]);
            
            DB::commit();
            
            // Clear cart
            session()->forget('cart');
            
            return redirect()->route('checkout.success', $pesanan->id_pesanan)
                           ->with('success', 'Pesanan berhasil dibuat!');
                           
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }
    
    public function success($orderId)
    {
        $pesanan = Pesanan::with(['detailPesanan.produk', 'pembayaran', 'trackingPesanan'])
                          ->where('id_pesanan', $orderId)
                          ->firstOrFail();
        
        return view('checkout.success', compact('pesanan'));
    }
}
