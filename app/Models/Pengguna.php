<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengguna extends Authenticatable
{
    use HasFactory;
    
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_pengguna',
        'nama_lengkap',
        'email',
        'kata_sandi',
        'peran',
        'telepon',
        'foto',
        'dibuat_pada',
    ];

    protected $hidden = [
        'kata_sandi',
    ];

    protected $casts = [
        'dibuat_pada' => 'datetime',
    ];

    // Override timestamps
    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = null;

    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    // Accessor untuk name agar kompatibel dengan Auth
    public function getNameAttribute()
    {
        return $this->nama_lengkap;
    }

    // Accessor untuk password agar kompatibel dengan Auth
    public function getPasswordAttribute()
    {
        return $this->kata_sandi;
    }

    // Accessor untuk phone agar kompatibel dengan controller
    public function getPhoneAttribute()
    {
        return $this->telepon;
    }

    // Accessor untuk avatar agar kompatibel dengan controller
    public function getAvatarAttribute()
    {
        return $this->foto;
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_pengguna', 'id_pengguna');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_pengguna', 'id_pengguna');
    }
}
