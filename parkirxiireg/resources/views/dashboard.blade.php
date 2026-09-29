<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KABASA - Dashboard Parkir</title>
</head>
<style>
  :root{
    --sky: #A9C4DE; --sky-light: #DCE9F2; --navy: #24405C; --navy-deep: #1B2F44;
    --yellow: #E8B93C; --green: #4C8B6B; --red: #B5563F; --ivory: #FBFAF6;
    --ink: #23303B; --muted: #8695A0; --line: #E4E9EE;
  }
  *{ box-sizing: border-box; margin:0; padding:0; }
  body{ font-family:'Inter', sans-serif; color:var(--ink); background:var(--sky-light); min-height:100vh; }
  a{ color:inherit; text-decoration: none; }
  .app{ display:grid; grid-template-columns: 240px 1fr; min-height:100vh; }
  .sidebar{ background:var(--navy); color:#EAF0F6; padding:26px 18px; display:flex; flex-direction:column; }
  .brand{ display:flex; align-items:center; gap:11px; padding:0 6px 26px; margin-bottom:20px; border-bottom:1px solid rgba(255,255,255,0.12); }
  .p-badge{ width:34px; height:34px; border-radius:50%; background:var(--ivory); color:var(--navy); display:flex; align-items:center; justify-content:center; font-family:'Fraunces', serif; font-weight:600; font-size:17px; border:2px solid var(--yellow); flex-shrink:0; }
  .brand-name{ font-family:'Fraunces', serif; font-size:15px; letter-spacing:0.02em; }
  nav.primary-nav{ display:flex; flex-direction:column; gap:2px; }
  .nav-item{ display:flex; align-items:center; gap:11px; padding:10px 12px; border-radius:2px; font-size:14px; color:#C7D4E0; text-decoration:none; border-left:3px solid transparent; }
  .nav-item svg{ width:17px; height:17px; flex-shrink:0; opacity:0.9; }
  .nav-item.active{ background:rgba(255,255,255,0.08); color:#fff; border-left-color:var(--yellow); font-weight:500; }
  .sidebar-foot{ margin-top:auto; padding-top:20px; border-top:1px solid rgba(255,255,255,0.12); }
  .user-chip{ display:flex; align-items:center; gap:10px; padding:8px 6px; }
  .avatar{ width:32px; height:32px; border-radius:50%; background:var(--yellow); color:var(--navy-deep); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; flex-shrink:0; }
  .user-chip .who{ font-size:13px; }
  .user-chip .who .name{ color:#fff; font-weight:500; }
  .user-chip .who .role{ color:#9FB1C2; font-size:12px; }
  main{ padding:32px 36px 60px; }
  .topbar{ display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:16px; margin-bottom:28px; }
  .topbar h1{ font-family:'Fraunces', serif; font-weight:500; font-size:26px; color:var(--ink); }
  .topbar .date{ color:var(--muted); font-size:13.5px; margin-top:4px; }
  .search{ display:flex; align-items:center; gap:8px; background:#fff; border:1.5px solid var(--line); border-radius:2px; padding:9px 12px; min-width:240px; }
  .search svg{ width:15px; height:15px; color:var(--muted); flex-shrink:0; }
  .search input{ border:none; outline:none; font-family:'Inter',sans-serif; font-size:13.5px; width:100%; background:transparent; }
  .stats{ display:grid; grid-template-columns:repeat(3, 1fr); gap:16px; margin-bottom:28px; }
  .stat{ background:#fff; border:1px solid var(--line); border-top:3px solid var(--accent, var(--navy)); padding:18px 18px 16px; }
  .stat .label{ font-size:12.5px; color:var(--muted); margin-bottom:10px; }
  .stat .value{ font-family:'Fraunces', serif; font-size:30px; font-weight:500; color:var(--ink); line-height:1; margin-bottom:8px; }
  .stat .delta{ font-size:12.5px; color:var(--green); }
  .content-grid{ display:grid; grid-template-columns: 1.05fr 1.4fr; gap:20px; align-items:start; }
  .panel{ background:#fff; border:1px solid var(--line); padding:24px; }
  .panel h2{ font-family:'Fraunces', serif; font-weight:500; font-size:17px; margin-bottom:4px; }
  .panel .panel-sub{ font-size:12.5px; color:var(--muted); margin-bottom:20px; }
  .occupancy{ display:flex; flex-direction:column; align-items:center; gap:18px; }
  .donut{ width:168px; height:168px; border-radius:50%; display:flex; align-items:center; justify-content:center; position:relative; }
  .donut::before{ content:''; position:absolute; width:120px; height:120px; border-radius:50%; background:#fff; }
  .donut-label{ position:relative; text-align:center; }
  .donut-label .num{ font-family:'Fraunces', serif; font-size:26px; color:var(--ink); }
  .donut-label .txt{ font-size:11.5px; color:var(--muted); }
  .legend{ display:flex; gap:20px; font-size:13px; }
  .legend .dot{ width:9px; height:9px; border-radius:50%; display:inline-block; margin-right:6px; }
  .legend .terisi .dot{ background:var(--navy); }
  .legend .kosong .dot{ background:var(--sky-light); border:1px solid var(--line); }
  .quick-action{ margin-top:22px; width:100%; display:flex; align-items:center; justify-content:center; gap:9px; background:var(--navy); color:#fff; border:none; padding:12px; font-family:'Inter', sans-serif; font-size:14px; font-weight:600; cursor:pointer; }
  .session-list{ display:flex; flex-direction:column; }
  .session{ display:flex; align-items:center; justify-content:space-between; gap:14px; padding:14px 0; border-bottom:1px dashed var(--line); }
  .session .plate{ font-family:'Inter', sans-serif; font-weight:700; font-size:14.5px; background:var(--ivory); border:1px solid var(--line); padding:5px 9px; border-radius:2px; }
  .session .meta{ flex:1; min-width:0; }
  .session .meta .slot{ font-size:13.5px; color:var(--ink); font-weight:500; }
  .session .meta .time{ font-size:12px; color:var(--muted); margin-top:2px; }
  .session .tariff{ font-size:13.5px; font-weight:600; color:var(--navy); }
  .session .tiket-status{ font-size:11px; padding:3px 8px; border-radius:2px; white-space:nowrap; font-weight:600; }
  .session .tiket-status.active{ background:#E9F3EE; color:var(--green); }
  .session .tiket-status.soon{ background:#FBF0DA; color:#8A6416; }
  .see-all{ display:block; text-align:center; margin-top:18px; font-size:13px; color:var(--navy); text-decoration:none; border-top:1px solid var(--line); padding-top:14px; }
</style>
<body>
<div class="app">
  <aside class="sidebar">
    <div class="brand"><div class="p-badge">P</div><div class="brand-name"><strong>KABASA</strong><div style="font-size:11px; color:#9FB1C2;">Sistem Parkir</div></div></div>
    
    <nav class="primary-nav">
       <a href="{{ route('dashboard') }}" class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">📊 Dashboard</a>

        {{-- PERBAIKAN: Ditambahkan Str::lower agar tidak sensitif huruf besar/kecil --}}
        @if(strtolower(auth()->user()->peran) == 'admin')
            <a href="{{ url('/users') }}" class="nav-item">👥 Kelola User</a>
            <a href="{{ url('/tarif') }}" class="nav-item">💵 Kelola Tarif Parkir</a>
            <a href="{{ url('/area') }}" class="nav-item">📍 Kelola Area Parkir</a>
            <a href="{{ url('/kendaraan') }}" class="nav-item">🚗 Kendaraan</a>
            <a href="{{ url('/log-aktivitas') }}" class="nav-item">📜 Log Aktivitas</a>
        @endif

        @if(strtolower(auth()->user()->peran) == 'operator lapangan')
            <a href="{{ url('/sesi-parkir') }}" class="nav-item">⏱️ Sesi Parkir</a>
            <a href="{{ url('/riwayat') }}" class="nav-item">📜 Riwayat</a>
        @endif

        @if(strtolower(auth()->user()->peran) == 'owner')
            <a href="{{ url('/riwayat') }}" class="nav-item">📈 Rekap Transaksi</a>
        @endif
    </nav>
    
    <form action="{{ route('logout') }}" method="POST" style="padding: 10px 15px; margin-top: 15px;">
        @csrf
        <button type="submit" style="background-color: #dc3545; color: white; border: none; padding: 10px; border-radius: 6px; cursor: pointer; width: 100%; text-align: left; font-weight: bold;">
            🚪 Keluar (Logout)
        </button>
    </form>

    <div class="sidebar-foot">
        <div class="user-chip">
            <div class="avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <div class="who">
                <div class="name">{{ Auth::user()->name }}</div>
                <div class="role">{{ Auth::user()->peran }}</div>
            </div>
        </div>
    </div>
  </aside>

  <main>
    <div class="topbar">
      <div>
        <h1>Ringkasan Parkir</h1>
        <div class="date">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</div>
      </div>
      <div class="search">
         <input type="text" placeholder="Cari kendaraan atau slot...">
      </div>
    </div>

    <div class="stats">
      <div class="stat">
        <div class="label">Slot Terisi</div>
        <div class="value">{{ $slotTerisi }}</div>
        <div class="delta">Kendaraan aktif</div>
      </div>
      <div class="stat">
        <div class="label">Slot Tersedia</div>
       <div class="value">{{ $totalKapasitasAsli - $slotTerisi }}</div>
        <div class="delta">Total: {{ $totalKapasitasAsli }} slot</div>
      </div>
      <div class="stat">
        <div class="label">Pendapatan Hari Ini</div>
        <div class="value">Rp {{ number_format($pendapatanHariIni ?? 0, 0, ',', '.') }}</div>
        <div class="delta">Transaksi lunas</div>
      </div>
    </div>
<div class="content-grid" style="display: flex; gap: 20px; align-items: flex-start; margin-top: 20px;">
    
    <!-- PANEL KIRI: GRAFIK LINGKARAN -->
    <div class="panel" style="flex: 1; min-width: 280px; box-sizing: border-box;">
        <h2>Okupansi Area</h2>
        <div class="panel-sub">Persentase keterisian slot</div>
        
        <div class="occupancy" style="display: flex; justify-content: center; margin: 20px 0;">
           @php
              $persentase = $totalKapasitasAsli > 0 ? round(($slotTerisi / $totalKapasitasAsli) * 100) : 0;
          @endphp

            <div class="donut" style="background: conic-gradient(#0056b3 {{ $persentase }}%, #e7f1ff 0); width: 150px; height: 150px; border-radius: 50%; display: flex; justify-content: center; align-items: center; position: relative;">
                <div class="donut-label" style="background: white; width: 110px; height: 110px; border-radius: 50%; display: flex; flex-direction: column; justify-content: center; align-items: center; box-shadow: inset 0 0 8px rgba(0,0,0,0.05);">
                    <div class="num" style="font-size: 24px; font-weight: bold; color: #0056b3;">{{ $persentase }}%</div>
                    <div class="txt" style="font-size: 12px; color: #666;">Terisi</div>
                </div>
            </div>
        </div>

        <!-- Teks Legenda Tunggal (Sudah dibersihkan dari duplikat) -->
        <div class="legend" style="display: flex; justify-content: space-around; font-size: 13px; margin-top: 15px; border-top: 1px solid #eee; padding-top: 15px;">
            <span class="terisi" style="font-weight: 600;"><span class="dot" style="display: inline-block; width: 10px; height: 10px; background-color: #0056b3; border-radius: 50%; margin-right: 5px;"></span>Terisi ({{ $slotTerisi }})</span>
            <span class="kosong" style="font-weight: 600;"><span class="dot" style="display: inline-block; width: 10px; height: 10px; background-color: #e7f1ff; border-radius: 50%; margin-right: 5px;"></span>Kosong ({{ $totalKapasitasAsli - $slotTerisi }})</span>
        </div>
    </div>

    <!-- PANEL KANAN: TABEL SESI AKTIF UTAMA (SEJAJAR DI SAMPING GRAFIK) -->
    <div class="panel" style="flex: 2; min-width: 450px; box-sizing: border-box;">
        <h2>Sesi Parkir Aktif Utama</h2>
        <div class="panel-sub">Daftar kendaraan yang sedang parkir di dalam area</div>
        
        <div class="table-responsive" style="margin-top: 15px; max-height: 250px; overflow-y: auto;">
            <table class="table" style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead>
                    <tr style="border-bottom: 2px solid #e7f1ff; text-align: left; color: #666; font-weight: bold;">
                        <th style="padding: 10px 8px;">Plat Nomor</th>
                        <th style="padding: 10px 8px;">Jenis</th>
                        <th style="padding: 10px 8px;">Waktu Masuk</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sesiAktif as $row)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 10px 8px; font-weight: bold; color: #0056b3;">
                                {{ $row->kendaraan->plat_nomor ?? '-' }}
                            </td>
                            <td style="padding: 10px 8px;">
                                <span style="background-color: #e7f1ff; color: #0056b3; padding: 2px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                    {{ $row->kendaraan->jenis_kendaraan ?? '-' }}
                                </span>
                            </td>
                            <td style="padding: 10px 8px; color: #666;">
                                {{ \Carbon\Carbon::parse($row->waktu_masuk)->format('H:i') }} WIB
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="padding: 20px; text-align: center; color: #999; font-style: italic;">
                                Tidak ada kendaraan aktif di dalam area parkir.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div> <!-- Penutup Akhir content-grid -->
