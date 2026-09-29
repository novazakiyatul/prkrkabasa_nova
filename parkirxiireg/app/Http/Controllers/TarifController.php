<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarif;

class TarifController extends Controller
{
    // 1. Menampilkan Halaman Daftar Tarif Parkir
    public function index()
    {
        $tarifs = Tarif::latest()->get();
        return view('tarif.index', compact('tarifs'));
    }

    // 2. Menampilkan Form Tambah Tarif
    public function create()
    {
        return view('tarif.create');
    }

    // 3. Menyimpan Data Tarif Baru ke Database
    public function store(Request $request)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|string|unique:tarifs,jenis_kendaraan',
            'tarif_per_jam' => 'required|numeric|min:0',
        ]);

        Tarif::create([
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'tarif_per_jam' => $request->tarif_per_jam,
        ]);

        return redirect()->route('tarif.index')->with('success', 'Tarif parkir baru berhasil ditambahkan!');
    }

    // 4. Menampilkan Form Edit Tarif
    public function edit($id)
    {
        $tarif = Tarif::findOrFail($id);
        return view('tarif.edit', compact('tarif'));
    }

    // 5. Memperbarui Data Tarif di Database
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|string|unique:tarifs,jenis_kendaraan,'.$id,
            'tarif_per_jam' => 'required|numeric|min:0',
        ]);

        $tarif = Tarif::findOrFail($id);
        $tarif->update([
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'tarif_per_jam' => $request->tarif_per_jam,
        ]);

        return redirect()->route('tarif.index')->with('success', 'Data tarif parkir berhasil diperbarui!');
    }

    // 6. Menghapus Data Tarif dari Database
    public function destroy($id)
    {
        $tarif = Tarif::findOrFail($id);
        $tarif->delete();

        return redirect()->route('tarif.index')->with('success', 'Tarif parkir berhasil dihapus!');
    }
}
