<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingPesanan extends Model
{
    protected $table = 'tracking_pesanan';
    protected $primaryKey = 'id_tracking';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_tracking',
        'id_pesanan',
        'nomor_resi',
        'kurir',
        'status_pengiriman',
        'tanggal_update',
        'detail_tracking',
    ];

    protected $casts = [
        'tanggal_update' => 'datetime',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
