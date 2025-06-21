# Integrasi Midtrans - Checkout System

## Persiapan

### 1. Install Midtrans PHP SDK

```bash
composer require midtrans/midtrans-php
```

### 2. Konfigurasi Environment

Tambahkan ke file `.env`:

```bash
MIDTRANS_SERVER_KEY=SB-Mid-server-YOUR_SERVER_KEY_HERE
MIDTRANS_CLIENT_KEY=SB-Mid-client-YOUR_CLIENT_KEY_HERE
```

**Untuk Sandbox (Testing):**

-   Server Key: `SB-Mid-server-xxxxxxxxx`
-   Client Key: `SB-Mid-client-xxxxxxxxx`

**Untuk Production:**

-   Server Key: `Mid-server-xxxxxxxxx`
-   Client Key: `Mid-client-xxxxxxxxx`

### 3. Dapatkan API Keys

1. Daftar di [Midtrans Dashboard](https://dashboard.midtrans.com/)
2. Pilih environment (Sandbox untuk testing, Production untuk live)
3. Pergi ke Settings > Access Keys
4. Copy Server Key dan Client Key

## Fitur yang Diimplementasikan

### 1. Payment Methods

-   **Midtrans**: Credit Card, Bank Transfer, E-Wallet (GoPay, OVO, DANA, dll)
-   **COD**: Cash on Delivery

### 2. Payment Flow

#### Untuk COD:

1. User pilih metode COD
2. Form submit langsung ke server
3. Order dibuat dengan status 'pending'
4. Redirect ke success page

#### Untuk Midtrans:

1. User pilih metode "Pembayaran Online"
2. JavaScript buat AJAX request ke `/checkout/create-snap-token`
3. Server response dengan snap_token
4. JavaScript buka Midtrans Snap popup
5. User selesaikan pembayaran
6. Callback ke `/checkout/payment-callback`
7. Server update order status
8. Redirect ke success page

### 3. File yang Terlibat

#### Controllers:

-   `CheckoutController.php`:
    -   `store()`: Handle form checkout
    -   `createSnapToken()`: Buat Midtrans snap token
    -   `paymentCallback()`: Handle callback dari Midtrans
    -   `payment()`: Halaman pembayaran (optional)
    -   `success()`: Halaman sukses

#### Services:

-   `MidtransService.php`: Handle komunikasi dengan Midtrans API

#### Views:

-   `checkout/index.blade.php`: Form checkout dengan integrasi Midtrans
-   `checkout/payment.blade.php`: Halaman pembayaran dedicated
-   `checkout/success.blade.php`: Halaman sukses

#### Routes:

```php
Route::middleware(['customer'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/checkout/create-snap-token', [CheckoutController::class, 'createSnapToken'])->name('checkout.create-snap-token');
    Route::post('/checkout/payment-callback', [CheckoutController::class, 'paymentCallback'])->name('checkout.payment-callback');
    Route::get('/checkout/payment/{orderId}', [CheckoutController::class, 'payment'])->name('checkout.payment');
});
Route::get('/checkout/success/{orderId}', [CheckoutController::class, 'success'])->name('checkout.success');
```

### 4. Database Structure

#### Tabel `pesanan`:

```sql
id_pesanan, id_pelanggan, tanggal_pesanan, status_pesanan, total_harga,
payment_method, payment_status, alamat_pengiriman, nama_penerima,
telepon_penerima, email_penerima, dibuat_pada
```

#### Tabel `pembayaran`:

```sql
id_pembayaran, id_pesanan, id_pengguna, jumlah_bayar, tanggal_pembayaran,
status_pembayaran, snap_token, midtrans_order_id, payment_type,
transaction_status, fraud_status, payment_expired_at, midtrans_response, dibuat_pada
```

## Testing

### 1. Sandbox Testing

-   Gunakan test credit card numbers dari [Midtrans Documentation](https://docs.midtrans.com/en/technical-reference/sandbox-test)
-   Test card: `4811 1111 1111 1114`
-   CVV: `123`
-   Exp: `01/25`

### 2. Test Scenarios

1. **Successful Payment**: Complete payment flow
2. **Failed Payment**: Use failed test card
3. **Pending Payment**: Bank transfer scenario
4. **COD Order**: Cash on delivery flow

## Production Checklist

1. [ ] Ganti ke Production API keys
2. [ ] Update Midtrans script URL dari sandbox ke production
3. [ ] Implement proper signature verification
4. [ ] Setup webhook notifications
5. [ ] Configure notification URLs di Midtrans Dashboard
6. [ ] Test semua payment methods di production environment

## Troubleshooting

### Common Issues:

1. **"Client key not found"**: Pastikan MIDTRANS_CLIENT_KEY di .env sudah benar
2. **"Snap token error"**: Cek MIDTRANS_SERVER_KEY dan format data yang dikirim
3. **"CORS error"**: Pastikan domain sudah didaftarkan di Midtrans Dashboard
4. **"Payment popup tidak muncul"**: Cek console browser untuk error JavaScript

### Debug Steps:

1. Cek file `.env` untuk API keys
2. Cek console browser untuk JavaScript errors
3. Cek Laravel logs untuk server errors
4. Verify di Midtrans Dashboard untuk transaction logs
