<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'id_pelanggan',
        'id_pengguna',
        'total_harga',
        'status_pesanan',
        'tanggal_pesanan',
        'estimasi_selesai',
        'nomor_resi',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'tanggal_pesanan' => 'date',
        'estimasi_selesai' => 'datetime',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pesanan', 'id_pesanan');
    }

    public function trackingPesanan()
    {
        return $this->hasMany(TrackingPesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
