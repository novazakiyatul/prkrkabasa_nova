<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tarif Parkir - Admin</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f6f9; padding: 20px; color: #333; }
        .container { max-width: 1000px; margin: 0 auto; }
        .header-box { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-tambah { background: #28a745; color: #fff; padding: 10px 15px; border: none; border-radius: 4px; text-decoration: none; font-weight: bold; font-size: 14px; cursor: pointer; }
        .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; font-weight: 600; }
        .btn-edit { background: #ffc107; color: #000; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: bold; margin-right: 5px; cursor: pointer; }
        .btn-hapus { background: #dc3545; color: #fff; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: bold; }
        .alert-success { background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px; font-size: 14px; }
        
        /* CSS Modal Popup Form */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; }
        .modal-content { background: #fff; padding: 25px; border-radius: 8px; width: 400px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; display: flex; flex-direction: column; gap: 5px; }
        .form-group label { font-size: 12px; font-weight: bold; }
        .form-group input { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-simpan { background: #001f3f; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%; }
        .btn-batal { background: #6c757d; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%; margin-top: 5px; }
    </style>
</head>
<body>

<div class="container">
       <div class="header-box">
        <h2>Kelola Tarif Parkir (Admin)</h2>
        <div class="header-buttons" style="display: flex; gap: 10px; align-items: center;">
            <button onclick="bukaModalTambah()" class="btn-tambah">+ Tambah Tarif Baru</button>
            <a href="{{ route('dashboard') }}" class="btn-kembali" style="background: #6c757d; color: #fff; padding: 10px 15px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; text-decoration: none; font-size: 14px; display: inline-block;">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>


    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Kendaraan</th>
                    <th>Tarif Per Jam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tarifs as $tarif)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $tarif->jenis_kendaraan }}</strong></td>
                    <td>Rp {{ number_format($tarif->tarif_per_jam, 0, ',', '.') }}</td>
                    <td>
                        <button onclick="bukaModalEdit('{{ $tarif->id }}', '{{ $tarif->jenis_kendaraan }}', '{{ $tarif->tarif_per_jam }}')" class="btn-edit">Edit</button>
                        <form action="{{ route('tarif.destroy', $tarif->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tarif ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #888;">Belum ada data tarif parkir. Silakan tambahkan baru!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL POPUP TAMBAH DATA -->
<div id="modalTambah" class="modal">
    <div class="modal-content">
        <h3>Tambah Tarif Parkir</h3>
        <form action="{{ route('tarif.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Jenis Kendaraan:</label>
                <input type="text" name="jenis_kendaraan" required placeholder="Contoh: Mobil, Motor, Truk">
            </div>
            <div class="form-group">
                <label>Tarif Per Jam (Rp):</label>
                <input type="number" name="tarif_per_jam" required placeholder="Contoh: 3000">
            </div>
            <button type="submit" class="btn-simpan">Simpan Data</button>
            <button type="button" onclick="tutupModalTambah()" class="btn-batal">Batal</button>
        </form>
    </div>
</div>

<!-- MODAL POPUP EDIT DATA -->
<div id="modalEdit" class="modal">
    <div class="modal-content">
        <h3>Edit Tarif Parkir</h3>
        <form id="formEdit" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Jenis Kendaraan:</label>
                <input type="text" id="edit_jenis_kendaraan" name="jenis_kendaraan" required>
            </div>
            <div class="form-group">
                <label>Tarif Per Jam (Rp):</label>
                <input type="number" id="edit_tarif_per_jam" name="tarif_per_jam" required>
            </div>
            <button type="submit" class="btn-simpan">Simpan Perubahan</button>
            <button type="button" onclick="tutupModalEdit()" class="btn-batal">Batal</button>
        </form>
    </div>
</div>

<script>
    function bukaModalTambah() { document.getElementById('modalTambah').style.display = 'flex'; }
    function tutupModalTambah() { document.getElementById('modalTambah').style.display = 'none'; }
    
    function bukaModalEdit(id, jenis, tarif) {
        document.getElementById('formEdit').action = "/tarif/" + id;
        document.getElementById('edit_jenis_kendaraan').value = jenis;
        document.getElementById('edit_tarif_per_jam').value = tarif;
        document.getElementById('modalEdit').style.display = 'flex';
    }
    function tutupModalEdit() { document.getElementById('modalEdit').style.display = 'none'; }
</script>

</body>
</html>
