<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    // Tampilkan data kendaraan dari database
    public function index()
    {
        // Mengambil data sesi parkir terbaru untuk dipantau admin
        $kendaraans = \App\Models\ParkirSession::with('kendaraan')->latest()->get();
        return view('kendaraan', compact('kendaraans'));
    }

    // Hapus log data kendaraan jika diperlukan
    public function destroy($id)
    {
        $session = \App\Models\ParkirSession::findOrFail($id);
        $session->delete();

        return redirect('/kendaraan')->with('success', 'Log data kendaraan berhasil dibersihkan!');
    }
}
