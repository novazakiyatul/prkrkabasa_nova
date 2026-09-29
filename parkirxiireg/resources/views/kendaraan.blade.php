<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Data Kendaraan - Admin</title>
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
        .btn-hapus { background: #dc3545; color: #fff; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: bold; }
        .badge-status { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .status-aktif { background: #d4edda; color: #155724; }
        .status-keluar { background: #e2e3e5; color: #383d41; }
    </style>
</head>
<body>
<div class="container">
    <div class="header-box">
        <h2>Monitoring Data Kendaraan (Admin)</h2>
        <div class="header-buttons">
            <a href="{{ route('dashboard') }}" class="btn-kembali">← Kembali ke Dashboard</a>
        </div>
    </div>
    
    @if(session('success')) 
        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
            {{ session('success') }}
        </div> 
    @endif
    
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Plat Nomor</th>
                    <th>Jenis Kendaraan</th>
                    <th>Waktu Masuk</th>
                    <th>Status Parkir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kendaraans as $k)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $k->kendaraan->plat_nomor ?? '-' }}</td>
                    <td>{{ $k->kendaraan->jenis_kendaraan ?? '-' }}</td>
                    <td>{{ $k->created_at ? $k->created_at->format('d M Y - H:i') : '-' }} WIB</td>
                    <td>
                        @if(($k->status ?? 'Aktif') == 'Aktif')
                            <span class="badge-status status-aktif">Parkir Aktif</span>
                        @else
                            <span class="badge-status status-keluar">Sudah Keluar</span>
                        @endif
                    </td>
                    <td>
                        <form action="/kendaraan/{{ $k->id }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus riwayat kendaraan ini?')" class="btn-hapus">Hapus Log</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #8695A0;">Belum ada data kendaraan terdaftar di sistem.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
