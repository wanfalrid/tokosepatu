<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Pembayaran;
use App\Models\TrackingPesanan;
use App\Models\Produk;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TestOrderSeeder extends Seeder
{
    public function run()
    {
        // Create test customer
        $customer = Pelanggan::firstOrCreate(
            ['email' => 'test@customer.com'],
            [
                'id_pelanggan' => 'CUST-TEST01',
                'nama' => 'John Doe',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Test No. 123, Jakarta',
                'tanggal_lahir' => '1990-01-01',
                'kata_sandi' => Hash::make('password123'),
                'status_akun' => 'aktif',
            ]
        );

        // Get some products
        $products = Produk::take(3)->get();
        
        if ($products->count() < 3) {
            $this->command->info('Not enough products in database. Please run ProdukSeeder first.');
            return;
        }

        // Create test orders
        $orderStatuses = ['pending', 'diproses', 'dikirim', 'selesai'];
        $paymentMethods = ['transfer', 'cod', 'ewallet'];

        for ($i = 1; $i <= 5; $i++) {
            $orderDate = Carbon::now()->subDays(rand(1, 30));
            $status = $orderStatuses[array_rand($orderStatuses)];
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
            
            // Create order
            $order = Pesanan::create([
                'id_pesanan' => 'ORD-TEST' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'id_pelanggan' => $customer->id_pelanggan,
                'tanggal_pesanan' => $orderDate,
                'status_pesanan' => $status,
                'total_harga' => 0, // Will be calculated
                'nama_penerima' => $customer->nama,
                'alamat_pengiriman' => $customer->alamat,
                'telepon_penerima' => $customer->telepon,
                'catatan_pesanan' => 'Test order #' . $i,
                'nomor_resi' => $status === 'dikirim' || $status === 'selesai' ? 'RESI' . str_pad($i, 8, '0', STR_PAD_LEFT) : null,
                'estimasi_selesai' => $status === 'dikirim' ? $orderDate->addDays(3) : null,
            ]);

            $totalHarga = 0;

            // Create order details (1-3 random products per order)
            $orderProductCount = rand(1, 3);
            $selectedProducts = $products->random($orderProductCount);
            
            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 2);
                $subtotal = $product->harga * $quantity;
                $totalHarga += $subtotal;

                DetailPesanan::create([
                    'id_detail' => 'DTL-TEST' . $i . '-' . $product->id_produk,
                    'id_pesanan' => $order->id_pesanan,
                    'id_produk' => $product->id_produk,
                    'jumlah' => $quantity,
                    'harga_satuan' => $product->harga,
                    'subtotal' => $subtotal,
                ]);
            }

            // Update order total
            $order->update(['total_harga' => $totalHarga]);

            // Create payment
            Pembayaran::create([
                'id_pembayaran' => 'PAY-TEST' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'id_pesanan' => $order->id_pesanan,
                'metode_pembayaran' => $paymentMethod,
                'jumlah_bayar' => $totalHarga,
                'status_pembayaran' => $status === 'pending' ? 'pending' : 'paid',
                'tanggal_pembayaran' => $status === 'pending' ? null : $orderDate->addMinutes(30),
            ]);

            // Create tracking
            $trackingStatuses = [];
            switch ($status) {
                case 'pending':
                    $trackingStatuses = ['order_placed'];
                    break;
                case 'diproses':
                    $trackingStatuses = ['order_placed', 'payment_confirmed', 'processing'];
                    break;
                case 'dikirim':
                    $trackingStatuses = ['order_placed', 'payment_confirmed', 'processing', 'shipped'];
                    break;
                case 'selesai':
                    $trackingStatuses = ['order_placed', 'payment_confirmed', 'processing', 'shipped', 'delivered'];
                    break;
            }

            $trackingDate = $orderDate;
            foreach ($trackingStatuses as $trackingStatus) {
                TrackingPesanan::create([
                    'id_tracking' => 'TRK-TEST' . $i . '-' . strtoupper(substr($trackingStatus, 0, 3)),
                    'id_pesanan' => $order->id_pesanan,
                    'status_tracking' => $trackingStatus,
                    'keterangan' => ucfirst(str_replace('_', ' ', $trackingStatus)),
                    'tanggal_update' => $trackingDate,
                    'detail_tracking' => 'Test tracking for ' . $trackingStatus,
                ]);
                $trackingDate = $trackingDate->addHours(rand(2, 24));
            }
        }

        $this->command->info('Test orders created successfully!');
        $this->command->info('Test customer email: test@customer.com');
        $this->command->info('Test customer password: password123');
    }
}
