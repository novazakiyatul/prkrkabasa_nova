<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Transaksi Parkir</title>
    <!-- Kita pakai style dashboard Anda agar tampilannya serasi -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 25px; }
        .filter-form { display: flex; gap: 15px; align-items: flex-end; }
        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-group label { font-size: 12px; font-weight: bold; color: #333; }
        .form-group input { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-filter { background: #001f3f; color: #fff; padding: 9px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; }
        .btn-reset { color: red; text-decoration: none; font-size: 14px; margin-left: 10px; }
        .income-badge { float: right; background: #e2f0d9; color: #385723; padding: 10px 15px; border-radius: 6px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; font-weight: 600; }
        .badge-success { background-color: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Rekap Transaksi Selesai (Laporan Owner)</h2>

    <!-- INFO TOTAL PENDAPATAN -->
            <!-- INFO TOTAL PENDAPATAN & TOMBOL KEMBALI -->
        <div class="card">
            <div class="income-badge">
                Total Pendapatan Terfilter: Rp {{ number_format($totalPendapatan) }}
            </div>
            
            <div style="margin-top: 15px; margin-bottom: 5px;">
                <a href="/sesi-parkir" style="text-decoration: none; background-color: #6c757d; display: inline-block; padding: 8px 15px; border-radius: 4px; color: white; font-family: 'Inter', sans-serif; font-size: 14px; font-weight: bold;">
                    ← Kembali ke Sesi Parkir
                </a>
            </div>
        </div>

        <!-- FORM FILTER KALENDER (WAKTU YANG DIMINTA) -->
        <form action="{{ url('/riwayat') }}" method="GET" class="filter-form">
    <div class="form-group" style="display: inline-block; margin-right: 15px;">
        <label>Tanggal Mulai:</label>
        <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
    </div>

    <div class="form-group" style="display: inline-block; margin-right: 15px;">
        <label>Tanggal Selesai:</label>
        <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
    </div>

    <div style="display: inline-block; margin-top: 10px;">
        <button type="submit" class="btn-filter">Filter Rekap</button>
        
        @if(request('tanggal_mulai') || request('tanggal_selesai'))
            <a href="{{ url('/riwayat') }}" class="btn-reset" style="margin-left: 5px; text-decoration: none;">Reset</a>
        @endif
    </div>
</form>

    </div>

    <!-- TABEL DATA RIWAYAT -->
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Plat Nomor</th>
                    <th>Jenis Kendaraan</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Keluar</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatParkir as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->kendaraan->plat_nomor ?? '-' }}</td>
                    <td>{{ $row->kendaraan->jenis_kendaraan ?? '-' }}</td>
                    <td>{{ $row->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $row->updated_at->format('Y-m-d H:i') }}</td>
                    <td>Rp {{ number_format($row->biaya ?? 0, 0, ',', '.') }}</td>
                    <td><span class="badge-success">Lunas</span></td>
                    <td>
                        <a href="{{ url('/sesi-parkir/' . $row->id . '/cetak') }}" 
                             target="_blank" 
                        style="background-color: #0056b3; color: white; padding: 4px 8px; text-decoration: none; border-radius: 4px; font-size: 12px; display: inline-block;">
                            Cetak
                        </a>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #888;">Tidak ada data transaksi pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
