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

    public function getRouteKeyName()
    {
        return 'id_produk';
    }

    public function getImageUrlAttribute()
    {
        if ($this->gambar) {
            // Check if it's already a full URL (starts with http/https)
            if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
                return $this->gambar;
            }
            // Otherwise, it's a local file in storage
            return asset('storage/product_images/' . $this->gambar);
        }
        // Fallback to default image
        return asset('images/no-image.svg');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_produk', 'id_produk');
    }
}