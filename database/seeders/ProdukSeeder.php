<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produk = [
            [
                'id_produk' => 'PRD001',
                'nama_produk' => 'Nike Air Max 270',
                'harga' => 1899000,
                'stok' => 15,
                'gambar' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'deskripsi' => 'Sepatu olahraga premium dengan teknologi Air Max untuk kenyamanan maksimal',
                'merek' => 'Nike',
                'ukuran' => '40-44',
                'warna' => 'Hitam/Putih',
                'dibuat_pada' => now(),
            ],
            [
                'id_produk' => 'PRD002',
                'nama_produk' => 'Adidas Ultraboost 22',
                'harga' => 2299000,
                'stok' => 12,
                'gambar' => 'https://images.unsplash.com/photo-1608667508764-33cf0726b13a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'deskripsi' => 'Sepatu lari dengan teknologi Boost untuk performa terbaik',
                'merek' => 'Adidas',
                'ukuran' => '39-45',
                'warna' => 'Putih/Biru',
                'dibuat_pada' => now(),
            ],
            [
                'id_produk' => 'PRD003',
                'nama_produk' => 'Converse Chuck Taylor All Star',
                'harga' => 899000,
                'stok' => 20,
                'gambar' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'deskripsi' => 'Sepatu kasual klasik dengan desain timeless yang cocok untuk berbagai outfit',
                'merek' => 'Converse',
                'ukuran' => '36-44',
                'warna' => 'Merah',
                'dibuat_pada' => now(),
            ],
            [
                'id_produk' => 'PRD004',
                'nama_produk' => 'Vans Old Skool',
                'harga' => 1099000,
                'stok' => 18,
                'gambar' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'deskripsi' => 'Sepatu skate klasik dengan garis samping khas Vans',
                'merek' => 'Vans',
                'ukuran' => '38-45',
                'warna' => 'Hitam/Putih',
                'dibuat_pada' => now(),
            ],
            [
                'id_produk' => 'PRD005',
                'nama_produk' => 'New Balance 997H',
                'harga' => 1599000,
                'stok' => 10,
                'gambar' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'deskripsi' => 'Sepatu retro running dengan bantalan REVlite untuk kenyamanan sepanjang hari',
                'merek' => 'New Balance',
                'ukuran' => '40-46',
                'warna' => 'Abu-abu/Merah',
                'dibuat_pada' => now(),
            ],
            [
                'id_produk' => 'PRD006',
                'nama_produk' => 'Puma RS-X³',
                'harga' => 1799000,
                'stok' => 8,
                'gambar' => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'deskripsi' => 'Sepatu futuristik dengan desain chunky yang trendy',
                'merek' => 'Puma',
                'ukuran' => '39-44',
                'warna' => 'Putih/Biru/Merah',
                'dibuat_pada' => now(),
            ],
            [
                'id_produk' => 'PRD007',
                'nama_produk' => 'Dr. Martens 1460',
                'harga' => 2899000,
                'stok' => 6,
                'gambar' => 'https://images.unsplash.com/photo-1518002171953-a080ee817e1f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'deskripsi' => 'Sepatu boots klasik dengan kulit premium dan sol AirWair',
                'merek' => 'Dr. Martens',
                'ukuran' => '37-45',
                'warna' => 'Hitam',
                'dibuat_pada' => now(),
            ],
            [
                'id_produk' => 'PRD008',
                'nama_produk' => 'Reebok Classic Leather',
                'harga' => 1199000,
                'stok' => 14,
                'gambar' => 'https://images.unsplash.com/photo-1560769629-975ec94e6a86?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'deskripsi' => 'Sepatu kasual retro dengan upper kulit premium',
                'merek' => 'Reebok',
                'ukuran' => '38-44',
                'warna' => 'Putih',
                'dibuat_pada' => now(),
            ],
            [
                'id_produk' => 'PRD009',
                'nama_produk' => 'ASICS Gel-Lyte III',
                'harga' => 1399000,
                'stok' => 11,
                'gambar' => 'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'deskripsi' => 'Sepatu running retro dengan teknologi Gel untuk kenyamanan maksimal',
                'merek' => 'ASICS',
                'ukuran' => '39-45',
                'warna' => 'Biru/Putih',
                'dibuat_pada' => now(),
            ],
            [
                'id_produk' => 'PRD010',
                'nama_produk' => 'Jordan 1 Retro High',
                'harga' => 2699000,
                'stok' => 5,
                'gambar' => 'https://images.unsplash.com/photo-1556906781-9a412961c28c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'deskripsi' => 'Sepatu basket ikonik dengan desain klasik yang timeless',
                'merek' => 'Jordan',
                'ukuran' => '40-46',
                'warna' => 'Hitam/Merah/Putih',
                'dibuat_pada' => now(),
            ],
        ];

        foreach ($produk as $item) {
            Produk::create($item);
        }
    }
}
