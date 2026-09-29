<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KABASA - Sesi Parkir</title>
    
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #24405f;
            --sky: #a9c4de;
            --ink: #23303b;
            --muted: #8695a0;
            --line: #e4e9ee;
            --green: #28a745;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; color: var(--ink); background-color: #f4f7f9; }
        a { color: inherit; text-decoration: none; }

        .app { display: grid; grid-template-columns: 240px 1fr; min-height: 100vh; }

        /* Sidebar Navigasi */
        .sidebar { background: var(--navy); color: #eaf0f6; padding: 26px; display: flex; flex-direction: column; }
        .brand { display: flex; align-items: center; gap: 11px; padding-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 30px; }
        .p-badge { width: 34px; height: 34px; border-radius: 50%; background: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: bold; color: var(--navy); border: 2px solid #e8b93c; flex-shrink: 0; }
        .brand-name { font-family: 'Fraunces', serif; font-size: 15px; line-height: 1.4; color: #ffffff; }

        nav.primary-nav { display: flex; flex-direction: column; gap: 2px; flex-grow: 1; }
        .nav-item { display: flex; align-items: center; padding: 12px; color: #a9c4de; font-size: 14px; font-weight: 500; }
        .nav-item:hover { color: #fff; }
        .nav-item.active { 
            color: #fff; 
            font-weight: 600; 
            background: rgba(255, 255, 255, 0.05); 
            border-left: 4px solid #e8b93c; 
            padding-left: 8px; 
        }

        /* Konten Utama */
        .main-content { padding: 40px; }
        .header-box { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .header-title { font-family: 'Fraunces', serif; font-size: 24px; font-weight: 700; color: var(--navy); }
        
        .btn-tambah { background: var(--green); color: #fff; padding: 10px 16px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 14px; }
        .btn-logout { background: #dc3545; color: #fff; padding: 10px 16px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 14px; }

        .table-container { background: white; padding: 24px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid var(--line); }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 16px 20px; color: #64748b; font-size: 12px; font-weight: 700; border-bottom: 2px solid var(--line); text-transform: uppercase; letter-spacing: 0.05em; font-family: 'Inter', sans-serif; }
        td { padding: 16px 20px; font-size: 14px; font-weight: 500; border-bottom: 1px solid var(--line); color: #23303b; line-height: 1.5; font-family: 'Inter', sans-serif; }
        td strong { font-weight: 700; color: #24405f; font-size: 15px; font-family: monospace; background: #f8f9fa; padding: 4px 8px; border: 1px solid #ddd; }
        tr:last-child td { border-bottom: none; }

        .badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; }
        .badge.active { background: #e6f4ea; color: #4c8b6b; }
        .badge.warning { background: #fef7e0; color: #e8b93c; }

        /* Modal Popup Gaya KABASA */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 9999; }
        .modal-content { background: #fff; padding: 25px; border-radius: 8px; width: 380px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .modal-content h3 { font-family: 'Fraunces', serif; margin-bottom: 20px; color: var(--navy); }
        .form-group { margin-bottom: 15px; display: flex; flex-direction: column; gap: 5px; text-align: left; }
        .form-group label { font-size: 13px; font-weight: 600; color: var(--ink); }
        .form-group input, .form-group select { padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-family: 'Inter', sans-serif; font-size: 14px; }
        .btn-simpan { background: var(--navy); color: white; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%; font-size: 14px; margin-top: 10px; }
        .btn-batal { background: #6c757d; color: white; padding: 12px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 14px; margin-top: 8px; }
    </style>
</head>
<body>

    <div class="app">
        <!-- SIDEBAR NAVIGASI OPERATOR -->
<aside class="sidebar" style="display: flex; flex-direction: column; justify-content: space-between; height: 100vh;">
                   <!-- Pembungkus Menu Bagian Atas -->
        <div>
            <div class="brand">
                <div class="p-badge">P</div>
                <div class="brand-name"><strong>KABASA</strong></div>
            </div>

            <nav class="primary-nav">
                <a href="{{ url('/sesi-parkir') }}" class="nav-item active">Sesi Parkir</a>
                <a href="{{ url('/riwayat') }}" class="nav-item">Riwayat Transaksi</a>
                 <!-- GANTI KODE TOMBOL KELUAR DI HALAMAN PETUGAS DENGAN INI -->
                <form action="{{ url('/logout') }}" method="POST" style="margin-top: 15px; padding: 0 15px;">
                    @csrf
                        <button type="submit" class="nav-item" style="background-color: #d9534f; color: white; border: none; width: 100%; text-align: left; border-radius: 5px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-door-open"></i> 🚪Keluar (Logout)
                        </button>
                </form>

               </nav>
        </div>

<!-- Bagian Profil Petugas & Form Logout -->
<div style="padding-top: 15px; border-top: 1px solid #444; margin-top: 15px;">

            <div style="display: flex; align-items: center; gap: 12px; padding: 0 10px; margin-bottom: 15px;">
                <div style="width: 38px; height: 38px; rounded-radius: 50%; border-radius: 50%; bg-color: #f59e0b; background-color: #f59e0b; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #1e293b; font-size: 14px;">
                    PT
                </div>
                <div style="display: flex; flex-direction: column;">
                    <span style="font-size: 14px; font-weight: 600; color: #ffffff; line-height: 1.2;">Petugas Parkir</span>
                    <span style="font-size: 12px; color: #94a3b8;">petugas</span>
                </div>
            </div>

            <!-- Form Logout Resmi Petugas -->
            
        </div>

        </aside>

        <!-- KONTEN UTAMA -->
        <main class="main-content">
        <!-- KOTAK JUDUL DAN TOMBOL -->
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 25px;">
            
            <!-- Judul di sebelah kiri -->
            <h1 class="header-title" style="margin: 0; font-size: 24px; font-weight: bold; color: #1e293b;">Daftar Sesi Parkir Aktif</h1>
            
            <!-- Kumpulan tombol di sebelah kanan -->
            <div style="display: flex; gap: 12px; align-items: center;">
                <button onclick="bukaModalSesi()" class="btn-tambah" style="margin: 0;">+ Kendaraan Masuk Baru</button>
                

            </div>

        </div>


            @if(session('success')) 
                <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px; font-size: 14px;">
                    {{ session('success') }}
                </div> 
            @endif
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Plat Nomor</th>
                            <th>Jenis Kendaraan</th>
                            <th>Waktu Masuk</th>
                            <th>Biaya Saat Ini</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($parkirSessions as $sesi)
                        <tr>
                            <td>{{ strtoupper($sesi->kendaraan->plat_nomor ?? '-') }}</td>
                            <td>{{ $sesi->kendaraan->jenis_kendaraan ?? '-' }}</td>

                            <td>{{ $sesi->created_at ? $sesi->created_at->format('H:i') : '-' }} WIB</td>
                            <td class="biaya-live" data-masuk="{{ $sesi->created_at }}">
                            Rp {{ number_format($sesi->biaya_saat_ini, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="badge {{ $sesi->status == 'Aktif' ? 'active' : 'success' }}">{{ $sesi->status }}</span>
                            </td>
                            <td>
                                <!-- Tombol Selesai/Bayar -->
                                <form action="{{ url('/sesi-parkir/' . $sesi->id . '/selesai') }}" method="POST" style="display: inline-block; margin-right: 5px;">
                                @csrf
                                @method('PUT')
    
                                <!-- Input hidden untuk menampung biaya dari JavaScript -->
                                <input type="hidden" name="total_biaya" class="input-total-biaya">
    
                                <button type="submit" onclick="ambilBiayaAkhir(this); return confirm('Apakah Anda yakin kendaraan ini selesai parkir?')" style="background-color: #28a745; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-weight: bold;">
                                    Selesai / Bayar
                                </button>
                            </form>


                                <!-- Tombol Cetak Struk -->
                                <a href="{{ url('/sesi-parkir/'.$sesi->id.'/cetak') }}" target="_blank" style="background-color: #007bff; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: bold; margin-left: 5px; display: inline-block;">
                                    Cetak
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #8695a0; padding: 30px 0;">Belum ada kendaraan terparkir. Klik tombol di kanan atas untuk menginput!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- PENAMBAHAN KUNCI: Modal Pop-up Form Input Kendaraan Masuk Baru -->
    <div id="modalSesiParkir" class="modal">
        <div class="modal-content">
            <h3>Input Kendaraan Masuk</h3>
            <!-- Sesuai rute web.php Anda, diarahkan ke store/proses input -->
            <form action="{{ url('/sesi-parkir') }}" method="POST">
                @csrf
                <input type="hidden" name="slot_id" value="{{ \App\Models\Area::first()->id ?? 1 }}">
                <div class="form-group">
                    <label>Plat Nomor Kendaraan:</label>
                    <input type="text" name="plat_nomor" required placeholder="Contoh: N 1234 ABC" style="text-transform: uppercase;">
                    <label>Jenis Kendaraan:</label>
                    <select name="jenis_kendaraan" required>
                        <option value="Motor">Motor</option>
                        <option value="Mobil">Mobil</option>
                        <option value="Truk">Truk / Bus</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-simpan">Daftarkan Masuk</button>
                <button type="button" onclick="tutupModalSesi()" class="btn-batal">Batal</button>
            </form>
        </div>
    </div>

    <script>
    // 1. FUNGSI UNTUK MODAL KENDARAAN MASUK
    function bukaModalSesi() {
        var modal = document.getElementById('modalSesiParkir');
        if(modal) modal.style.display = 'block';
    }
    
    function tutupModalSesi() {
        var modal = document.getElementById('modalSesiParkir');
        if(modal) modal.style.display = 'none';
    }

    // 2. FUNGSI UNTUK HITUNG BIAYA PARKIR SECARA LIVE & AKURAT
    function hitungBiayaLive() {
        const barisBiaya = document.querySelectorAll('.biaya-live');
        const sekarang = new Date();

        barisBiaya.forEach(td => {
            const waktuMasukStr = td.getAttribute('data-masuk');
            const jenis = td.getAttribute('data-jenis');

            // Validasi data awal
            if (!waktuMasukStr || !jenis) return;

            // Parsing waktu masuk ke objek Date
            const waktuMasuk = new Date(waktuMasukStr);
            if (isNaN(waktuMasuk.getTime())) return;

            // Hitung selisih waktu
            let selisihMilidetik = sekarang.getTime() - waktuMasuk.getTime();
            if (selisihMilidetik < 0) selisihMilidetik = 0;

            // Konversi milidetik ke menit, lalu ke jam (pembulatan ke atas)
            const totalMenit = Math.floor(selisihMilidetik / (1000 * 60));
            const totalJam = Math.ceil(totalMenit / 60);

            // Ketentuan Tarif: Mobil/Truk Rp 5.000, Kendaraan lain (Motor) Rp 2.000
            const tarifPerJam = (jenis.toLowerCase() === 'mobil' || jenis.toLowerCase() === 'truk') ? 5000 : 2000;
            
            // Minimal bayar 1 jam pertama
            const totalBiaya = (totalJam > 0 ? totalJam : 1) * tarifPerJam;

            // Tampilkan ke dalam tabel dengan format Rupiah
            td.innerText = 'Rp ' + totalBiaya.toLocaleString('id-ID');
        });
    }
    function ambilBiayaAkhir(button) {
    // 1. Cari baris tabel <tr> tempat tombol ini berada
    const row = button.closest('tr');
    
    // 2. Ambil teks biaya dari kolom .biaya-live di baris tersebut
    const biayaText = row.querySelector('.biaya-live').innerText;
    
    // 3. Bersihkan teks agar menyisakan ANGKA MURNI saja (0-9)
    const biayaAngka = parseInt(biayaText.replace(/[^0-9]/g, '')) || 0;
    
    // 4. Masukkan angka bersih tersebut ke dalam input hidden milik form di baris itu
    row.querySelector('.input-total-biaya').value = biayaAngka;
}

    // 3. MENJALANKAN FUNGSI
    // Jalankan pertama kali saat halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', function() {
        hitungBiayaLive();
        // Update otomatis setiap 15 detik agar langsung kelihatan perubahannya
        setInterval(hitungBiayaLive, 15000);
    });
</script>


</body>
</html>
