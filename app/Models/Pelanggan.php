<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true; // Enable timestamps for updated_at

    protected $fillable = [
        'id_pelanggan',
        'nama',
        'email',
        'telepon',
        'alamat',
        'tanggal_lahir',
        'kata_sandi',
        'status_akun',
        'foto',
        'dibuat_pada',
    ];

    protected $hidden = [
        'kata_sandi',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'dibuat_pada' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Custom timestamp column names
    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'updated_at';

    // Define custom created_at accessor
    public function getCreatedAtAttribute()
    {
        return $this->dibuat_pada;
    }

    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_pelanggan', 'id_pelanggan');
    }

    /**
     * Check if the customer has a profile photo
     */
    public function hasFoto()
    {
        return !empty($this->foto) && file_exists(public_path('storage/avatars/' . $this->foto));
    }

    /**
     * Get the full URL for the customer's profile photo
     */
    public function getFotoUrl()
    {
        if ($this->hasFoto()) {
            return asset('storage/avatars/' . $this->foto);
        }
        
        return null;
    }

    /**
     * Get foto_url attribute accessor
     */
    public function getFotoUrlAttribute()
    {
        return $this->getFotoUrl();
    }

    /**
     * Get the customer's display name
     */
    public function getDisplayName()
    {
        return $this->nama;
    }

    /**
     * Get the customer's avatar (alias for getFotoUrl)
     */
    public function getAvatar()
    {
        return $this->getFotoUrl();
    }
}