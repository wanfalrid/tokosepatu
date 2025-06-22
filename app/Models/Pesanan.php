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
        'total_harga',
        'status_pesanan',
        'payment_status',
        'metode_pengiriman',
        'tanggal_pesanan',
        'estimasi_selesai',
        'nomor_resi',
        'ongkos_kirim',
        'alamat_pengiriman',
        'nama_penerima',
        'telepon_penerima',
        'email_penerima',
        'catatan_pesanan',
        'dibuat_pada',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'ongkos_kirim' => 'decimal:2',
        'tanggal_pesanan' => 'date',
        'estimasi_selesai' => 'datetime',
        'dibuat_pada' => 'datetime',
    ];

    /**
     * Accessor untuk total (alias untuk total_harga)
     */
    public function getTotalAttribute()
    {
        return $this->total_harga;
    }

    /**
     * Hitung total dari detail pesanan
     */
    public function getTotalFromDetailsAttribute()
    {
        return $this->detailPesanan->sum('subtotal');
    }

    /**
     * Hitung grand total dengan ongkir
     */
    public function getGrandTotalAttribute()
    {
        return $this->getTotalFromDetailsAttribute() + ($this->ongkos_kirim ?? 0);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
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