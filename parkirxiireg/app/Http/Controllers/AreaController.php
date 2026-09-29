<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    // 1. Menampilkan Halaman Utama Area
    public function index()
    {
        $areas = Area::all();
        return view('area.index', compact('areas'));
    }

    // 2. Menyimpan Data Area Baru dari Modal Tambah
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'slot' => 'required|integer|min:1',
        ]);

        Area::create([
            'nama_area' => $request->nama,
            'total_slot' => $request->slot,
        ]);

        return redirect()->route('area.index')->with('success', 'Area baru berhasil ditambahkan!');
    }

    // 3. Memperbarui Data Area dari Modal Edit (SUDAH DIPERBAIKI)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'slot' => 'required|integer|min:1',
        ]);

        $area = Area::findOrFail($id);
        
        $area->update([
            'nama_area' => $request->nama,
            'total_slot' => $request->slot,
        ]);

        return redirect()->route('area.index')->with('success', 'Data area berhasil diperbarui!');
    }

    // 4. Menghapus Data Area
    public function destroy($id)
    {
        $area = Area::findOrFail($id);
        $area->delete();

        return redirect()->route('area.index')->with('success', 'Area berhasil dihapus!');
    }
}
