<?php

namespace App\Models;

use Illuminate\database\Eloquent\Model;

class Harga extends Model
{
    // define column name
    protected $fillable = [
        'biaya',
        'kursi'
    ];

    // Untuk melakukan update field created_at dan update_at secara otomatis
    public $timestamps = true;

    public function harga()
    {

        return $this->hasMany(Reservasi::class, 'harga_id');
    }
}