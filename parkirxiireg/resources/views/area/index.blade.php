<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Area Parkir - Admin</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 1000px; margin: 0 auto; }
        .header-box { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header-buttons { display: flex; gap: 10px; align-items: center; }
        .btn-tambah { background: #28a745; color: #fff; padding: 10px 15px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; }
        .btn-kembali { background: #6c757d; color: #fff; padding: 10px 15px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; text-decoration: none; font-size: 14px; }
        .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; }
        .btn-edit { background: #ffc107; color: #000; padding: 5px 10px; border-radius: 4px; border: none; font-size: 12px; font-weight: bold; cursor: pointer; margin-right: 5px; }
        .btn-hapus { background: #dc3545; color: #fff; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: bold; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; }
        .modal-content { background: #fff; padding: 25px; border-radius: 8px; width: 350px; }
        .form-group { margin-bottom: 15px; display: flex; flex-direction: column; gap: 5px; }
        .form-group input { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-simpan { background: #001f3f; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%; }
        .btn-batal { background: #6c757d; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; width: 100%; margin-top: 5px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header-box">
        <h2>Kelola Area Parkir (Admin)</h2>
        <div class="header-buttons">
            <!-- 1. Tombol Tambah Data -->
            <button onclick="bukaModalTambah()" class="btn-tambah">+ Tambah Area Baru</button>
            
            <!-- PERBAIKAN: Tombol merah keluar diganti tombol kembali ke Halaman Gambar 1 -->
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
                    <th>Nama Area / Blok</th>
                    <th>Total Slot</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($areas as $area)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $area->nama_area }}</strong></td>
                    <td>{{ $area->total_slot }} Slot</td>
                    <td>
                        <button onclick="bukaModalEdit('{{ $area->id }}', '{{ $area->nama_area }}', '{{ $area->total_slot }}')" class="btn-edit">Edit</button>

                        <form action="{{ route('area.destroy', $area->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin hapus area ini?')" class="btn-hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Data area masih kosong.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Data Area -->
<div id="modalTambah" class="modal">
    <div class="modal-content">
        <h3>Tambah Area</h3>
        <form action="{{ route('area.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Area:</label>
                <input type="text" name="nama" required placeholder="Contoh: Zona A">
            </div>
            <div class="form-group">
                <label>Total Slot:</label>
                <input type="number" name="slot" required placeholder="Contoh: 15">
            </div>
            <button type="submit" class="btn-simpan">Simpan</button>
            <button type="button" onclick="tutupModalTambah()" class="btn-batal">Batal</button>
        </form>
    </div>
</div>

<!-- Modal Edit Data Area -->
<div id="modalEdit" class="modal">
    <div class="modal-content">
        <h3>Edit Area</h3>
        <form id="formEdit" action="" method="POST">
            @csrf 
            @method('PUT')
            
            <div class="form-group">
                <label>Nama Area:</label>
                <!-- PERBAIKAN KUNCI: Atribut name diganti menjadi 'nama' agar dibaca oleh Controller -->
                <input type="text" id="edit_nama_area" name="nama" required>
            </div>
            <div class="form-group">
                <label>Total Slot:</label>
                <!-- PERBAIKAN KUNCI: Atribut name diganti menjadi 'slot' agar dibaca oleh Controller -->
                <input type="number" id="edit_total_slot" name="slot" required>
            </div>
            
            <button type="submit" class="btn-simpan">Simpan Perubahan</button>
            <button type="button" onclick="tutupModalEdit()" class="btn-batal">Batal</button>
        </form>
    </div>
</div>

<script>
    function bukaModalTambah() { document.getElementById('modalTambah').style.display = 'flex'; }
    function tutupModalTambah() { document.getElementById('modalTambah').style.display = 'none'; }
    function bukaModalEdit(id, nama, slot) { document.getElementById('formEdit').action = "/area/" + id; document.getElementById('edit_nama_area').value = nama; document.getElementById('edit_total_slot').value = slot; document.getElementById('modalEdit').style.display = 'flex'; }
    function tutupModalEdit() { document.getElementById('modalEdit').style.display = 'none'; }
</script>
</body>
</html>
