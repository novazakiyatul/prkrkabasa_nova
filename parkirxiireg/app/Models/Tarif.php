<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    // KUNCI UTAMA: Memberikan izin agar kolom ini bisa disimpan ke database
    protected $fillable = ['jenis_kendaraan', 'tarif_per_jam'];
}
