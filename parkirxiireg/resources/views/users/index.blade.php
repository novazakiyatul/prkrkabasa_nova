<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pengguna - Admin</title>
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
        .form-group input, .form-group select { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-simpan { background: #001f3f; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%; }
        .btn-batal { background: #6c757d; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; width: 100%; margin-top: 5px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header-box">
        <h2>Kelola Pengguna / User (Admin)</h2>
        <div class="header-buttons">
            <button onclick="bukaModalTambah()" class="btn-tambah">+ Tambah User Baru</button>
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
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Peran / Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $u->name }}</strong></td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->peran }}</td>
                    <td>
                        <button onclick="bukaModalEdit('{{ $u->id }}', '{{ $u->name }}', '{{ $u->email }}', '{{ $u->peran }}')" class="btn-edit">Edit</button>

                        <form action="{{ route('users.destroy', $u->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin hapus user ini?')" class="btn-hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Data user masih kosong.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah User -->
<div id="modalTambah" class="modal">
    <div class="modal-content">
        <h3>Tambah User Baru</h3>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap:</label>
                <input type="text" name="name" required placeholder="Contoh: Budi Santoso">
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required placeholder="Contoh: budi@gmail.com">
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter">
            </div>
            <div class="form-group">
                <label>Peran / Role:</label>
                <select name="peran" required>
                    <option value="Admin">Admin</option>
                    <option value="Operator Lapangan">Operator Lapangan</option>
                </select>
            </div>
            <button type="submit" class="btn-simpan">Simpan</button>
            <button type="button" onclick="tutupModalTambah()" class="btn-batal">Batal</button>
        </form>
    </div>
</div>

<!-- Modal Edit User -->
<div id="modalEdit" class="modal">
    <div class="modal-content">
        <h3>Edit User</h3>
        <form id="formEdit" action="" method="POST">
            @csrf 
            @method('PUT')
            
            <div class="form-group">
                <label>Nama Lengkap:</label>
                <input type="text" id="edit_name" name="name" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" id="edit_email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password (Kosongkan jika tidak diubah):</label>
                <input type="password" name="password" placeholder="Isi hanya jika ganti password">
            </div>
            <div class="form-group">
                <label>Peran / Role:</label>
                <select id="edit_peran" name="peran" required>
                    <option value="Admin">Admin</option>
                    <option value="Operator Lapangan">Operator Lapangan</option>
                </select>
            </div>
            
            <button type="submit" class="btn-simpan">Simpan Perubahan</button>
            <button type="button" onclick="tutupModalEdit()" class="btn-batal">Batal</button>
        </form>
    </div>
</div>

<script>
    function bukaModalTambah() { document.getElementById('modalTambah').style.display = 'flex'; }
    function tutupModalTambah() { document.getElementById('modalTambah').style.display = 'none'; }
    function bukaModalEdit(id, name, email, peran) { 
        document.getElementById('formEdit').action = "/users/" + id; 
        document.getElementById('edit_name').value = name; 
        document.getElementById('edit_email').value = email; 
        document.getElementById('edit_peran').value = peran; 
        document.getElementById('modalEdit').style.display = 'flex'; 
    }
    function tutupModalEdit() { document.getElementById('modalEdit').style.display = 'none'; }
</script>
</body>
</html>
