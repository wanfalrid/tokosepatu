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
        'ukuran',
        'warna',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];

    // Helper methods
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function getStockStatusAttribute()
    {
        if ($this->stok > 10) {
            return 'In Stock';
        } elseif ($this->stok > 0) {
            return 'Low Stock';
        } else {
            return 'Out of Stock';
        }
    }

    public function getStockStatusColorAttribute()
    {
        switch ($this->stock_status) {
            case 'In Stock':
                return 'success';
            case 'Low Stock':
                return 'warning';
            case 'Out of Stock':
                return 'danger';
            default:
                return 'secondary';
        }
    }

    public function getDiscountPriceAttribute()
    {
        // Example: 10% discount
        return $this->harga * 0.9;
    }

    public function getFormattedDiscountPriceAttribute()
    {
        return 'Rp ' . number_format($this->discount_price, 0, ',', '.');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_produk', 'id_produk');
    }
}
