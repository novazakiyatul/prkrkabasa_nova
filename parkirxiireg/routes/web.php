<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Models\ParkirSession;
use App\Http\Controllers\ParkirSessionController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\AreaController; // Controller area parkir yang dipakai
use App\Http\Controllers\UserController;

// 1. Halaman Utama Langsung Diarahkan ke Login
Route::get('/', function () {
    return view('login');
});

// 2. Tampilan Halaman Login
Route::get('/login', function () {
    return view('login');
})->name('login');

// 3. Proses Validasi Login Akun (Multi-role)
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        // Cek peran dan alihkan ke halaman yang sesuai
        if (Auth::user()->peran === 'Operator Lapangan') {
            return redirect()->intended('/sesi-parkir');
        }
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau kata sandi yang Anda masukkan salah.',
    ])->withInput($request->only('email'));
});

// 4. Jalur Dashboard Utama
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// // 5. Jalur Halaman Sesi Parkir Aktif
Route::get('/sesi-parkir', function () {
    $parkirSessions = \App\Models\ParkirSession::with(['kendaraan', 'slot'])
                        ->where('status', '!=', 'Lunas')
                        ->get();

    foreach ($parkirSessions as $sesi) {
        if ($sesi->kendaraan) {
            $dataTarif = \App\Models\Tarif::where('jenis_kendaraan', $sesi->kendaraan->jenis_kendaraan)->first();
            $tarifPerJam = $dataTarif ? $dataTarif->tarif_per_jam : 2000;

            $waktuMasuk = \Carbon\Carbon::parse($sesi->created_at);
            $waktuSekarang = \Carbon\Carbon::now();
            
            $durasiJam = ceil($waktuMasuk->diffInMinutes($waktuSekarang) / 60);
            if ($durasiJam < 1) {
                $durasiJam = 1;
            }

            $sesi->biaya_saat_ini = $durasiJam * $tarifPerJam;
        } else {
            $sesi->biaya_saat_ini = 0;
        }
    }

    return view('sesi-parkir', compact('parkirSessions'));
})->middleware('auth');

Route::post('/sesi-parkir', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'plat_nomor' => 'required|string',
        'jenis_kendaraan' => 'required|string',
    ]);

    $isAktif = \App\Models\ParkirSession::where('status', '!=', 'Lunas')
        ->whereHas('kendaraan', function($query) use ($request) {
            $query->where('plat_nomor', $request->plat_nomor);
        })->exists();

    if ($isAktif) {
        return redirect()->back()->with('error', 'Kendaraan dengan plat nomor ini sudah berada di dalam area parkir!');
    }

    $slotTersedia = \App\Models\Slot::first();

    $kendaraan = \App\Models\Kendaraan::firstOrCreate(
        ['plat_nomor' => $request->plat_nomor],
        ['jenis_kendaraan' => $request->jenis_kendaraan]
    );

    \App\Models\ParkirSession::create([
        'kendaraan_id' => $kendaraan->id,
        'slot_id' => $slotTersedia ? $slotTersedia->id : 1,
        'status' => 'Aktif',
        'created_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Kendaraan berhasil didaftarkan masuk.');
})->middleware('auth');





Route::post('/sesi-parkir', [\App\Http\Controllers\ParkirSessionController::class, 'store'])->middleware('auth');


// 6. Jalur Halaman Kelola Kendaraan Resmi (Sudah Terhubung ke Controller)
Route::get('/kendaraan', [\App\Http\Controllers\KendaraanController::class, 'index'])->name('kendaraan.index')->middleware('auth');
Route::delete('/kendaraan/{id}', [\App\Http\Controllers\KendaraanController::class, 'destroy'])->middleware('auth');


// 7. Fitur Transaksi & Cetak Struk
Route::get('/riwayat', [ParkirSessionController::class, 'riwayat'])->middleware('auth');
Route::post('/sesi-parkir/{id}/checkout', [ParkirSessionController::class, 'checkout'])->middleware('auth');
Route::get('/sesi-parkir/{id}/cetak', [ParkirSessionController::class, 'cetak'])->middleware('auth');

// 8. Rute CRUD Tarif Parkir
Route::resource('tarif', TarifController::class)->middleware('auth');

// 9. Rute CRUD Kelola Area Parkir (Sudah lengkap untuk Tambah, Edit, Hapus)
Route::get('/area', [AreaController::class, 'index'])->name('area.index');
Route::post('/area', [AreaController::class, 'store'])->name('area.store');
Route::put('/area/{id}', [AreaController::class, 'update'])->name('area.update');
Route::delete('/area/{id}', [AreaController::class, 'destroy'])->name('area.destroy');

// 10. Rute Log Aktivitas
Route::get('/log-aktivitas', function() {
    $logs = \App\Models\LogAktivitas::with('user')->latest()->get();
    return view('log-aktivitas', compact('logs'));
})->middleware('auth');

// 11. Rute CRUD Kelola User (Sudah lengkap untuk Tambah, Edit, Hapus)
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// 12. Rute Proses Logout (Mendukung tombol form maupun link biasa)
Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout.get');

Route::put('/sesi-parkir/{id}/selesai', [\App\Http\Controllers\ParkirSessionController::class, 'selesai']);
