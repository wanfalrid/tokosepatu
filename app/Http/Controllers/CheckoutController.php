<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Pembayaran;
use App\Models\TrackingPesanan;
use App\Models\Produk;
use App\Services\MidtransService;
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
    }      public function store(Request $request)
    {          $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'shipping_method' => 'required|in:regular,express,sameday',
            'payment_method' => 'required|in:midtrans,cod',
        ]);
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }
        
        // Get customer data if logged in
        $customer = Auth::guard('customer')->user();
        
        DB::beginTransaction();
        
        try {
            // Calculate shipping cost
            $shippingCosts = [
                'regular' => 0,
                'express' => 25000,
                'sameday' => 50000
            ];
              // Calculate totals
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['harga'] * $item['quantity'];
            }
            
            $shipping = $shippingCosts[$request->shipping_method];
            $tax = round($subtotal * 0.11); // Calculate 11% tax
            $total = $subtotal + $shipping + $tax;            // Create order
            $pesanan = Pesanan::create([
                'id_pesanan' => 'ORD-' . strtoupper(Str::random(8)),
                'id_pelanggan' => $customer ? $customer->id_pelanggan : null,
                'tanggal_pesanan' => now(),
                'status_pesanan' => 'menunggu', // Use correct enum value
                'metode_pengiriman' => $request->shipping_method,
                'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'pending', // Add payment status
                'total_harga' => $total,
                'alamat_pengiriman' => $request->alamat,
                'nama_penerima' => $request->nama_lengkap,
                'telepon_penerima' => $request->telepon,
                'email_penerima' => $request->email,
                'ongkos_kirim' => $shipping,
                'catatan_pesanan' => $request->catatan ?? null, // Add notes if provided
                'dibuat_pada' => now(),
            ]);
              // Create order details
            foreach ($cart as $item) {
                DetailPesanan::create([
                    'id_detail_pesanan' => 'DTL-' . strtoupper(Str::random(8)),
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_produk' => $item['id_produk'],
                    'jumlah' => $item['quantity'],
                    'harga_satuan' => $item['harga'],
                ]);
                
                // Update product stock
                $produk = Produk::find($item['id_produk']);
                if ($produk) {
                    $produk->stok -= $item['quantity'];
                    $produk->save();
                }
            }
              // If payment method is not COD, create Midtrans snap token
            if ($request->payment_method !== 'cod') {
                $midtransService = new MidtransService();
                
                // Prepare order data for Midtrans
                $orderData = [
                    'order_id' => $pesanan->id_pesanan,
                    'total_amount' => $total,
                    'customer' => [
                        'first_name' => $request->nama_lengkap,
                        'email' => $request->email,
                        'phone' => $request->telepon,
                        'address' => $request->alamat,
                    ],
                    'items' => []
                ];
                
                // Add cart items
                foreach ($cart as $item) {
                    $orderData['items'][] = [
                        'id' => $item['id_produk'],
                        'price' => $item['harga'],
                        'quantity' => $item['quantity'],
                        'name' => $item['nama_produk'],
                    ];
                }
                
                // Add shipping if not free
                if ($shipping > 0) {
                    $orderData['items'][] = [
                        'id' => 'shipping',
                        'price' => $shipping,
                        'quantity' => 1,
                        'name' => 'Ongkos Kirim (' . ucfirst($request->shipping_method) . ')',
                    ];
                }
                
                $snapToken = $midtransService->createSnapToken($orderData);                // Create payment record with snap token
                $pembayaran = Pembayaran::create([
                    'id_pembayaran' => 'PAY-' . strtoupper(Str::random(8)),
                    'id_pesanan' => $pesanan->id_pesanan,
                    'jumlah' => $total,
                    'jumlah_bayar' => $total,
                    'tanggal_pembayaran' => now(),
                    'status_pembayaran' => 'menunggu',
                    'dibuat_pada' => now(),
                ]);
                
                DB::commit();
                
                // Return JSON response with snap token for AJAX request
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'snap_token' => $snapToken,
                        'order_id' => $pesanan->id_pesanan,
                        'client_key' => $midtransService->getClientKey()
                    ]);
                }
                
                // For non-AJAX request, redirect to payment page
                session(['snap_token' => $snapToken, 'order_id' => $pesanan->id_pesanan]);
                return redirect()->route('checkout.payment', $pesanan->id_pesanan);            } else {                // COD payment
                $pembayaran = Pembayaran::create([
                    'id_pembayaran' => 'PAY-' . strtoupper(Str::random(8)),
                    'id_pesanan' => $pesanan->id_pesanan,
                    'jumlah' => $total,
                    'jumlah_bayar' => $total,
                    'tanggal_pembayaran' => now(),
                    'status_pembayaran' => 'menunggu',
                    'dibuat_pada' => now(),
                ]);
            }
              // Create tracking record
            TrackingPesanan::create([
                'id_tracking' => 'TRK-' . strtoupper(Str::random(8)),
                'id_pesanan' => $pesanan->id_pesanan,
                'status_pengiriman' => 'order_placed',
                'tanggal_update' => now(),
            ]);
            
            DB::commit();
            
            // Clear cart
            session()->forget('cart');
            
            return redirect()->route('checkout.success', $pesanan->id_pesanan)
                           ->with('success', 'Pesanan berhasil dibuat!');
                           
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }    }
    
    /**
     * Payment page for Midtrans
     */
    public function payment($orderId)
    {
        $pesanan = Pesanan::with(['detailPesanan.produk', 'pembayaran'])
                         ->where('id_pesanan', $orderId)
                         ->firstOrFail();
        
        $snapToken = session('snap_token');
        if (!$snapToken && $pesanan->pembayaran) {
            $snapToken = $pesanan->pembayaran->snap_token;
        }
        
        if (!$snapToken) {
            return redirect()->route('checkout.index')->with('error', 'Token pembayaran tidak ditemukan.');
        }
        
        $midtransService = new MidtransService();
        $clientKey = $midtransService->getClientKey();
        
        return view('checkout.payment', compact('pesanan', 'snapToken', 'clientKey'));
    }
    public function createSnapToken(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'shipping_method' => 'required|in:regular,express,sameday',
        ]);
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return response()->json(['error' => 'Keranjang belanja kosong.'], 400);
        }
        
        // Calculate shipping cost
        $shippingCosts = [
            'regular' => 0,
            'express' => 25000,
            'sameday' => 50000
        ];
        
        $shippingCost = $shippingCosts[$request->shipping_method];
        
        // Calculate totals
        $subtotal = 0;
        $items = [];
        
        foreach ($cart as $item) {
            $itemTotal = $item['harga'] * $item['quantity'];
            $subtotal += $itemTotal;
            
            $items[] = [
                'id' => $item['id_produk'],
                'price' => $item['harga'],
                'quantity' => $item['quantity'],
                'name' => $item['nama_produk'],
                'brand' => $item['merek'] ?? '',
                'category' => 'Sepatu'
            ];
        }
          // Add shipping as item if not free
        if ($shippingCost > 0) {
            $items[] = [
                'id' => 'SHIPPING',
                'price' => $shippingCost,
                'quantity' => 1,
                'name' => 'Ongkos Kirim (' . ucfirst($request->shipping_method) . ')',
                'category' => 'Shipping'
            ];
        }
        
        // Calculate tax (11%)
        $tax = round($subtotal * 0.11);
        
        // Add tax as item
        $items[] = [
            'id' => 'TAX',
            'price' => $tax,
            'quantity' => 1,
            'name' => 'Pajak (11%)',
            'category' => 'Tax'
        ];
        
        $total = $subtotal + $shippingCost + $tax;
        
        // Generate order ID
        $orderId = 'ORD-' . strtoupper(Str::random(8)) . '-' . time();
        
        // Prepare order data for Midtrans
        $orderData = [
            'order_id' => $orderId,
            'total_amount' => $total,
            'customer' => [
                'first_name' => $request->nama_lengkap,
                'last_name' => '',
                'email' => $request->email,
                'phone' => $request->telepon,
                'address' => $request->alamat,
            ],
            'items' => $items,
        ];
        
        try {
            $midtransService = new MidtransService();
            $snapToken = $midtransService->createSnapToken($orderData);
            
            // Store order data in session for later processing
            session()->put('pending_order', [
                'order_id' => $orderId,
                'customer_data' => $request->all(),
                'cart' => $cart,
                'total' => $total,
                'shipping_cost' => $shippingCost,
                'shipping_method' => $request->shipping_method,
            ]);
            
            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'total' => $total
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal membuat token pembayaran: ' . $e->getMessage()], 500);
        }
    }
      /**
     * Process payment callback from Midtrans
     */
    public function paymentCallback(Request $request)
    {
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $transactionStatus = $request->transaction_status;
        
        // Verify signature (implement signature verification for security)
        // For now, we'll proceed with processing
        
        $pendingOrder = session()->get('pending_order');
        
        if (!$pendingOrder || $pendingOrder['order_id'] !== $orderId) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        
        DB::beginTransaction();
        
        try {
            $customer = Auth::guard('customer')->user();
            
            // Determine payment status based on Midtrans transaction status
            $paymentStatus = 'menunggu';
            $orderStatus = 'menunggu';
            
            if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
                $paymentStatus = 'dibayar';
                $orderStatus = 'diproses';
            } elseif ($transactionStatus === 'pending') {
                $paymentStatus = 'menunggu';
                $orderStatus = 'menunggu';
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'])) {
                $paymentStatus = 'dibatalkan';
                $orderStatus = 'dibatalkan';
            }
            
            // Create order
            $pesanan = Pesanan::create([
                'id_pesanan' => $orderId,
                'id_pelanggan' => $customer ? $customer->id_pelanggan : null,
                'tanggal_pesanan' => now(),
                'status_pesanan' => $orderStatus,
                'metode_pengiriman' => $pendingOrder['shipping_method'],
                'payment_status' => $paymentStatus,
                'total_harga' => $pendingOrder['total'],
                'alamat_pengiriman' => $pendingOrder['customer_data']['alamat'],
                'nama_penerima' => $pendingOrder['customer_data']['nama_lengkap'],
                'telepon_penerima' => $pendingOrder['customer_data']['telepon'],
                'email_penerima' => $pendingOrder['customer_data']['email'],
                'ongkos_kirim' => $pendingOrder['shipping_cost'],
                'catatan_pesanan' => $pendingOrder['customer_data']['catatan'] ?? null,
                'dibuat_pada' => now(),
            ]);
            
            // Create order details
            foreach ($pendingOrder['cart'] as $item) {
                DetailPesanan::create([
                    'id_detail_pesanan' => 'DTL-' . strtoupper(Str::random(8)),
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_produk' => $item['id_produk'],
                    'jumlah' => $item['quantity'],
                    'harga_satuan' => $item['harga'],
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
                'jumlah' => $pendingOrder['total'],
                'jumlah_bayar' => $pendingOrder['total'],
                'status_pembayaran' => $paymentStatus,
                'tanggal_pembayaran' => $paymentStatus === 'dibayar' ? now() : now(),
                'dibuat_pada' => now(),
            ]);
            
            // Create tracking record
            TrackingPesanan::create([
                'id_tracking' => 'TRK-' . strtoupper(Str::random(8)),
                'id_pesanan' => $pesanan->id_pesanan,
                'status_pengiriman' => $paymentStatus === 'dibayar' ? 'payment_confirmed' : 'order_placed',
                'tanggal_update' => now(),
            ]);
            
            DB::commit();
            
            // Clear cart and pending order
            session()->forget(['cart', 'pending_order']);
            
            return response()->json(['success' => true, 'order_id' => $orderId]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Gagal memproses pesanan: ' . $e->getMessage()], 500);
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