<?php

namespace App\Models;

use Illuminate\database\Eloquent\Model;

class Meja extends Model
{
    // define column name
    protected $fillable = [
        'no_meja',
        'kursi',
        'posisi',
        'status'
    ];

    // Untuk melakukan update field created_at dan update_at secara otomatis
    public $timestamps = true;

    public function meja()
    {
        return $this->hasMany(Reservasi::class, 'meja_id');
    }
}