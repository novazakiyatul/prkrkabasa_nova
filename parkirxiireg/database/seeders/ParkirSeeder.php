<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Slot;
use App\Models\Kendaraan;
use App\Models\ParkirSession;
use Illuminate\Support\Facades\Hash;

class ParkirSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Operator Lapangan (Sesuai Menu Pengaturan)
        $user = User::updateOrCreate(
            ['email' => 'nova@email.com'],
            [
                'name' => 'nova_zakiyawirda',
                'password' => Hash::make('password123'),
                'peran' => 'Operator Lapangan',
                'notifikasi_sesi_habis' => true,
            ]
        );

        // TAMBAHKAN KODE INI DI BAWAHNYA:

        // 2. Buat Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@email.com'],
            [
                'name' => 'Admin Utama Kabasa',
                'password' => Hash::make('password123'),
                'peran' => 'admin',
                'notifikasi_sesi_habis' => false,
            ]
        );

        // 3. Buat Akun Owner
        User::updateOrCreate(
            ['email' => 'owner@email.com'],
            [
                'name' => 'Owner Kabasa',
                'password' => Hash::make('password123'),
                'peran' => 'owner',
                'notifikasi_sesi_habis' => false,
            ]
        );

        // 2. Buat Contoh Slot Parkir
        $slot1 = Slot::create(['zona' => 'Zona A', 'nama_slot' => 'Slot A-12', 'status' => 'Terisi']);
        $slot2 = Slot::create(['zona' => 'Zona A', 'nama_slot' => 'Slot A-04', 'status' => 'Terisi']);
        $slot3 = Slot::create(['zona' => 'Zona B', 'nama_slot' => 'Slot B-21', 'status' => 'Terisi']);
        $slot4 = Slot::create(['zona' => 'Zona C', 'nama_slot' => 'Slot C-07', 'status' => 'Terisi']);
        $slot5 = Slot::create(['zona' => 'Zona B', 'nama_slot' => 'Slot B-09', 'status' => 'Terisi']);
        $slot6 = Slot::create(['zona' => 'Zona C', 'nama_slot' => 'Slot C-15', 'status' => 'Terisi']);
        
        // Slot Tambahan yang Kosong/Tersedia
        for ($i = 1; $i <= 5; $i++) {
            Slot::create(['zona' => 'Zona A', 'nama_slot' => 'Slot A-0' . $i, 'status' => 'Tersedia']);
        }

        // 3. Buat Data Kendaraan (Sesuai Menu Kendaraan)
        $k1 = Kendaraan::create(['plat_nomor' => 'B 1924 KZP', 'jenis_kendaraan' => 'Motor', 'total_kunjungan' => 12, 'terakhir_masuk' => now()]);
        $k2 = Kendaraan::create(['plat_nomor' => 'D 7710 QW', 'jenis_kendaraan' => 'Mobil', 'total_kunjungan' => 4, 'terakhir_masuk' => now()]);
        $k3 = Kendaraan::create(['plat_nomor' => 'B 3352 FYE', 'jenis_kendaraan' => 'Mobil', 'total_kunjungan' => 21, 'terakhir_masuk' => now()]);
        $k4 = Kendaraan::create(['plat_nomor' => 'Z 5521 LR', 'jenis_kendaraan' => 'Motor', 'total_kunjungan' => 2, 'terakhir_masuk' => now()]);
        $k5 = Kendaraan::create(['plat_nomor' => 'B 6631 NM', 'jenis_kendaraan' => 'Mobil', 'total_kunjungan' => 5, 'terakhir_masuk' => now()]);
        $k6 = Kendaraan::create(['plat_nomor' => 'F 2210 AB', 'jenis_kendaraan' => 'Mobil', 'total_kunjungan' => 8, 'terakhir_masuk' => now()]);
        
        // Kendaraan yang sudah keluar (Riwayat Tiket)
        $k7 = Kendaraan::create(['plat_nomor' => 'E 9012 GH', 'jenis_kendaraan' => 'Mobil', 'total_kunjungan' => 1, 'terakhir_masuk' => now()->subHours(2)]);
        $k8 = Kendaraan::create(['plat_nomor' => 'B 6120 IJ', 'jenis_kendaraan' => 'Motor', 'total_kunjungan' => 3, 'terakhir_masuk' => now()->subHours(3)]);

        // 4. Buat Sesi Parkir (Sesuai Menu Sesi Aktif & Riwayat)
        // Sesi Aktif
        ParkirSession::create(['kendaraan_id' => $k1->id, 'slot_id' => $slot1->id, 'user_id' => $user->id, 'waktu_masuk' => now()->subMinutes(92), 'biaya' => 12000, 'status' => 'Aktif']);
        ParkirSession::create(['kendaraan_id' => $k2->id, 'slot_id' => $slot2->id, 'user_id' => $user->id, 'waktu_masuk' => now()->subMinutes(68), 'biaya' => 9000, 'status' => 'Aktif']);
        ParkirSession::create(['kendaraan_id' => $k3->id, 'slot_id' => $slot3->id, 'user_id' => $user->id, 'waktu_masuk' => now()->subMinutes(135), 'biaya' => 18000, 'status' => 'Segera habis']);
        ParkirSession::create(['kendaraan_id' => $k4->id, 'slot_id' => $slot4->id, 'user_id' => $user->id, 'waktu_masuk' => now()->subMinutes(51), 'biaya' => 7000, 'status' => 'Aktif']);
        ParkirSession::create(['kendaraan_id' => $k5->id, 'slot_id' => $slot5->id, 'user_id' => $user->id, 'waktu_masuk' => now()->subMinutes(121), 'biaya' => 15000, 'status' => 'Segera habis']);
        ParkirSession::create(['kendaraan_id' => $k6->id, 'slot_id' => $slot6->id, 'user_id' => $user->id, 'waktu_masuk' => now()->subMinutes(163), 'biaya' => 22000, 'status' => 'Segera habis']);

        // Sesi Lunas (Riwayat Tiket)
        ParkirSession::create(['kendaraan_id' => $k7->id, 'slot_id' => $slot1->id, 'user_id' => $user->id, 'waktu_masuk' => now()->subMinutes(125), 'waktu_keluar' => now()->subMinutes(20), 'durasi_menit' => 105, 'biaya' => 8000, 'status' => 'Lunas']);
        ParkirSession::create(['kendaraan_id' => $k8->id, 'slot_id' => $slot4->id, 'user_id' => $user->id, 'waktu_masuk' => now()->subMinutes(220), 'waktu_keluar' => now()->subMinutes(60), 'durasi_menit' => 160, 'biaya' => 21000, 'status' => 'Lunas']);
    }
}
