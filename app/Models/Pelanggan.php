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
    public $timestamps = true;

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
    ];

    protected $hidden = [
        'kata_sandi',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_pelanggan', 'id_pelanggan');
    }
    
    /**
     * Get the full URL for the profile photo
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/profile_photos/' . $this->foto);
        }
        return null;
    }
    
    /**
     * Check if customer has a profile photo
     */
    public function hasFoto()
    {
        return !empty($this->foto) && file_exists(storage_path('app/public/profile_photos/' . $this->foto));
    }
}