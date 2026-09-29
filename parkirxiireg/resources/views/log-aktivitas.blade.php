<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Log Aktivitas Sistem - Admin</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 1000px; margin: 0 auto; }
        .header-box { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header-buttons { display: flex; gap: 10px; align-items: center; }
        .btn-kembali { background: #6c757d; color: #fff; padding: 10px 15px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; text-decoration: none; font-size: 14px; display: inline-block; }
        .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; }
        .badge-user { background: #001f3f; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .time-text { color: #8695A0; font-size: 13px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header-box">
        <h2>Riwayat & Log Aktivitas Sistem (Admin)</h2>
        <div class="header-buttons">
            <a href="{{ route('dashboard') }}" class="btn-kembali">← Kembali ke Dashboard</a>
        </div>
    </div>
    
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pengguna</th>
                    <th>Aksi / Aktivitas</th>
                    <th>Waktu Kejadian</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge-user">{{ $log->user->name ?? 'Sistem' }}</span></td>
                    <td><strong>{{ $log->aktivitas ?? $log->activity }}</strong></td>
                    <td class="time-text">{{ $log->created_at ? $log->created_at->format('d M Y - H:i:s') : '-' }} WIB</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #8695A0;">Belum ada catatan aktivitas tercatat. Semua sistem berjalan normal.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
