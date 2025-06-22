<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_produk',
        'nama_produk',
        'harga',
        'stok',
        'gambar',
        'deskripsi',
        'merek',
        'kategori',
        'ukuran',
        'warna',
        'dibuat_pada',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
        'dibuat_pada' => 'datetime',
    ];

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_produk', 'id_produk');
    }
}