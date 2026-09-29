<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkirSession;
use App\Models\Tarif;
use Carbon\Carbon;

class ParkirSessionController extends Controller
{
    // ==========================================
    // MENAMPILKAN SESI AKTIF & TARIF DINAMIS
    // ==========================================
    public function index()
    {
        // Mengambil sesi parkir yang statusnya belum lunas
        $sessions = ParkirSession::with('kendaraan')->where('status', '!=', 'Lunas')->get();

        foreach ($sessions as $session) {
            if ($session->kendaraan) {
                // 1. Cari tarif per jam berdasarkan jenis kendaraannya
                $dataTarif = Tarif::where('jenis_kendaraan', $session->kendaraan->jenis_kendaraan)->first();
                $tarifPerJam = $dataTarif ? $dataTarif->tarif_per_jam : 2000;

                // 2. Hitung selisih waktu dari created_at sampai sekarang
                $waktuMasuk = Carbon::parse($session->created_at);
                $waktuSekarang = Carbon::now();
                
                $durasiJam = ceil($waktuMasuk->diffInMinutes($waktuSekarang) / 60);
                if ($durasiJam < 1) {
                    $durasiJam = 1;
                }

                // 3. Simpan nilai hasil hitungan ke variabel temporer
                $session->biaya_saat_ini = $durasiJam * $tarifPerJam;
            } else {
                $session->biaya_saat_ini = 0;
            }
        }

        return view('sesi-parkir', ['parkirSessions' => $sessions]);
    }

    // ==========================================
    // MENYIMPAN KENDARAAN MASUK BARU & CEK DUPLIKASI
    // ==========================================
   public function store(Request $request)
{
    // 1. Validasi input form masuk
    $request->validate([
        'plat_nomor' => 'required|string',
        'jenis_kendaraan' => 'required|string',
    ]);

    // 2. CEK DUPLIKASI KENDARAAN AKTIF
    $isAktif = ParkirSession::where('status', '!=', 'Lunas')
        ->whereHas('kendaraan', function($query) use ($request) {
            $query->where('plat_nomor', $request->plat_nomor);
        })->exists();

    if ($isAktif) {
        return redirect()->back()->with('error', 'Kendaraan dengan plat nomor ini sudah berada di dalam area parkir!');
    }

    // 3. AMBIL SLOT PARKIR OTOMATIS
    $slotTersedia = \App\Models\Slot::first();

    // 4. PEMBUATAN / PENCARIAN DATA KENDARAAN
    $kendaraan = \App\Models\Kendaraan::firstOrCreate(
        ['plat_nomor' => $request->plat_nomor],
        ['jenis_kendaraan' => $request->jenis_kendaraan]
    );

    // 5. SIMPAN DATA SESI PARKIR BARU (Lengkap dengan waktu_masuk)
    ParkirSession::create([
        'kendaraan_id' => $kendaraan->id,
        'slot_id' => $slotTersedia ? $slotTersedia->id : 1,
        'user_id' => auth()->id(),
        'status' => 'Aktif',
        'waktu_masuk' => now(), // Menambahkan waktu_masuk agar database tidak menolak lagi!
        'created_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Kendaraan berhasil didaftarkan masuk.');
}
    // LOGIKA TOMBOL SELESAI / BAYAR (PROSES CHECKOUT KELUAR)
    public function selesai($id)
    {
        // Cari sesi parkir aktif berdasarkan ID-nya
        $session = ParkirSession::findOrFail($id);

        // Ubah statusnya menjadi Lunas agar hilang dari tabel aktif
        $session->update([
            'status' => 'Lunas',
            'waktu_keluar' => now(),
        ]);

        return redirect()->back()->with('success', 'Transaksi pembayaran berhasil diselesaikan.');
    }
    // LOGIKA MENAMPILKAN HALAMAN RIWAYAT TRANSAKSI (KENDARAAN LUNAS)
    // LOGIKA MENAMPILKAN HALAMAN RIWAYAT TRANSAKSI (KENDARAAN LUNAS)
      // LOGIKA MENAMPILKAN HALAMAN RIWAYAT TRANSAKSI (KENDARAAN LUNAS)
    public function riwayat()
    {
        // 1. Ambil semua data sesi parkir yang statusnya sudah 'Lunas'
        // Nama variabel diubah menjadi $riwayatParkir agar cocok dengan file Blade Anda!
        $riwayatParkir = ParkirSession::with('kendaraan')
                            ->where('status', 'Lunas')
                            ->orderBy('updated_at', 'desc')
                            ->get();

        // 2. HITUNG TOTAL PENDAPATAN DARI TRANSAKSI LUNAS
        $totalPendapatan = ParkirSession::where('status', 'Lunas')->sum('biaya');

        // 3. Mengembalikan tampilan dengan membawa kedua variabel yang pas
        return view('riwayat', compact('riwayatParkir', 'totalPendapatan'));
    }
        // LOGIKA MENAMPILKAN HALAMAN CETAK STRUK PARKIR
    public function cetak($id)
    {
        // Ambil data sesi parkir berdasarkan ID yang dipilih
        $sesi = ParkirSession::with('kendaraan')->findOrFail($id);

        // Mengembalikan tampilan cetak struk dengan membawa data sesinya
        // (Sesuaikan 'cetak' jika nama file blade nota Anda berbeda, misal 'cetak-struk' atau 'nota')
        return view('cetak-struk', compact('sesi'));
    }

}
