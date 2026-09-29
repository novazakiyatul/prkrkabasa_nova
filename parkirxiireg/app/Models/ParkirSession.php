<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkirSession extends Model
{
    // Mengizinkan semua kolom diisi tanpa diblokir
    protected $guarded = [];

    // 🔗 HUBUNGAN 1: Menyambungkan Sesi Parkir ke Tabel Kendaraan kamu
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    // 🔗 HUBUNGAN 2: Menyambungkan Sesi Parkir ke Tabel Slots yang kita isi tadi
    public function slot()
    {
        return $this->belongsTo(Slot::class, 'slot_id');
    }
}
