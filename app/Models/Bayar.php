<?php

namespace App\Models;

use Illuminate\database\Eloquent\Model;

class Bayar extends Model
{
    // define column name
    protected $fillable = [
        'total',
        'reservasi_id'
    ];

    // Untuk melakukan update field created_at dan update_at secara otomatis
    public $timestamps = true;

    public function reservasi()
    {

        return $this->belongsTo(Reservasi::class, 'reservasi_id');
    }
}