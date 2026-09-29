<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. Ambil data user dari database dan tampilkan di view
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users')); // sesuaikan jika nama filenya resources/views/user.blade.php menjadi 'user'
    }

    // 2. Tambah data user baru beserta enkripsi password
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'peran' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'peran' => $request->peran,
        ]);

        return redirect()->route('users.index')->with('success', 'User baru berhasil ditambahkan!');
    }

    // 3. Edit data user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'peran' => 'required',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->peran = $request->peran;

                // Update password jika diisi di modal edit
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // 📝 KODE BARU: Catat aksi edit ke tabel log aktivitas
        \App\Models\LogAktivitas::create([
            'user_id' => auth()->user()->id,
            'aktivitas' => 'Mengubah data pengguna: ' . $user->name . ' (' . $user->email . ')',
        ]);

                return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui!');
    }


    // 4. Hapus data user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}
