<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk memberi izin input kolom
    protected $fillable = ['nama_area', 'total_slot']; 
}
