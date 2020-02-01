<?php

namespace App\Models;

use Illuminate\database\Eloquent\Model;

class Reservasi extends Model
{
    // define column name
    protected $fillable = [
        'meja_id',
        'harga_id',
        'user_id',
        'tanggal_booking',
        'status'
    ];

    // Untuk melakukan update field created_at dan update_at secara otomatis
    public $timestamps = true;

    public function meja()
    {
        return $this->belongsTo(Meja::class, 'meja_id');
    }
    public function harga()
    {
        return $this->belongsTo(Harga::class, 'harga_id');
    }
    public function reservasi()
    {
        return $this->hasMany(Bayar::class, 'reservasi_id');
    }
}