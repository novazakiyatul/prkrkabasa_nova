<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slot;
use App\Models\Kendaraan;
use App\Models\ParkirSession;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
                // Kunci keamanan: Pastikan pengguna sudah login
        if (!auth()->check()) {
            return redirect('/login');
        }
        
        // Kunci keamanan: Operator Lapangan otomatis ditendang balik ke sesi-parkir
        if (auth()->user()->peran === 'Operator Lapangan') {
            return redirect('/sesi-parkir');
        }

            // 1. Hitung ringkasan statistik atas langsung dari sesi parkir
    $slotTerisi = ParkirSession::where('status', 'Aktif')->count();
    
    // Tentukan total slot parkir aplikasi kamu, misalnya kapasitasnya 50 slot
    $totalSlotKapasitas = 50; 
    $slotTersedia = $totalSlotKapasitas - $slotTerisi;

    // Pendapatan hari ini dari sesi parkir yang sudah Lunas hari ini (WIB)
    $pendapatanHariIni = ParkirSession::where('status', 'Lunas')
        ->whereDate('waktu_keluar', date('Y-m-d'))
        ->sum('biaya');

        // 2. Ambil data untuk tabel Sesi Parkir Aktif (Status: Aktif atau Segera habis)
        $sesiAktif = ParkirSession::with(['kendaraan'])
            ->whereIn('status', ['Aktif', 'Segera habis'])
            ->orderBy('waktu_masuk', 'desc')
            ->get();

           // Hitung total kapasitas slot gabungan dari semua area parkir di database
    // (Asumsi nama Modelnya adalah 'Area', silakan sesuaikan jika namanya berbeda)
    $totalKapasitasAsli = \App\Models\Area::sum('total_slot') ?? 80;

    return view('dashboard', compact(
        'slotTerisi',
        'slotTersedia',
        'pendapatanHariIni',
        'sesiAktif',
        'totalKapasitasAsli' // Kita ikut sertakan variabel baru ini ke view
    ));

    }


public function sesiParkir()
{
    $sesiAktif = ParkirSession::with(['kendaraan', 'slot'])
        ->whereIn('status', ['Aktif', 'Segera habis'])
        ->orderBy('waktu_masuk', 'desc')
        ->get();

    return view('sesi-parkir', compact('sesiAktif'));
}
}