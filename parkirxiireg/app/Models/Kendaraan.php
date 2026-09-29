<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    // Masukkan ke dalam kurung kurawal ini
    protected $fillable = ['plat_nomor', 'jenis_kendaraan'];
}
