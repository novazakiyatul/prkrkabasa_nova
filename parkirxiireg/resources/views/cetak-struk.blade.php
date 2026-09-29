<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Parkir #{{ $sesi->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }
        
        /* Pembungkus luar untuk memaksa posisi di tengah layar & kertas cetak */
        .wrapper {
            padding: 40px 0;
            width: 100%;
        }

        /* Kontainer Utama Struk - Menggunakan margin auto agar aman dan estetik di tengah */
        .struk-box {
            width: 360px;
            margin: 0 auto; /* Trik utama agar pas di tengah-tengah secara horizontal */
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            border-top: 10px solid #0056b3; /* Aksen biru tema Kabasa */
            box-sizing: border-box;
        }

        /* Header Struk */
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px dashed #0056b3;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #0056b3;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 800;
        }
        .header p {
            font-size: 13px;
            margin: 6px 0 0 0;
            color: #666;
            line-height: 1.4;
        }

        /* Tabel Data Transaksi */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 8px 0;
            font-size: 15px;
            vertical-align: middle;
        }
        .label {
            color: #666;
            font-weight: 600;
            text-align: left;
        }
        .value {
            color: #111;
            font-weight: 700;
            text-align: right;
        }

        /* Bagian Total Bayar */
        .total-box {
            background-color: #e7f1ff;
            border: 1px solid #b8daff;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .total-label {
            font-size: 13px;
            color: #0056b3;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .total-amount {
            font-size: 28px;
            font-weight: 800;
            color: #0056b3;
            margin-top: 5px;
        }

        /* Footer Struk */
        .footer {
            text-align: center;
            font-size: 13px;
            color: #777;
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 15px;
            line-height: 1.4;
        }

        /* Pengaturan Khusus Printer (Pasti Stabil & Tidak Berantakan) */
        @media print {
            body {
                background-color: #fff;
            }
            .wrapper {
                padding: 50px 0 0 0; /* Memberi sedikit jarak manis dari batas atas kertas */
            }
            .struk-box {
                box-shadow: none;
                border: 1px solid #ddd;
                border-top: 10px solid #0056b3;
                margin: 0 auto !important; /* Paksa tetap di tengah halaman kertas */
            }
            .total-box {
                background-color: #e7f1ff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .header h1, .total-amount, .total-label {
                color: #0056b3 !important;
            }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="struk-box">
        <div class="header">
            <h1>KABASA PARKIR</h1>
            <p>Sistem Manajemen Parkir Digital<br>Malang, Jawa Timur</p>
        </div>

        <!-- Menggunakan tabel murni agar baris data di printer dijamin lurus & rapi -->
        <table class="info-table">
            <tr>
                <td class="label">ID Sesi:</td>
                <td class="value">#{{ $sesi->id }}</td>
            </tr>
            <tr>
                <td class="label">Plat Nomor:</td>
                <td class="value" style="font-size: 18px; color: #0056b3;">{{ $sesi->kendaraan->plat_nomor ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kendaraan:</td>
                <td class="value">{{ $sesi->kendaraan->jenis_kendaraan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Waktu Masuk:</td>
                <td class="value">{{ \Carbon\Carbon::parse($sesi->waktu_masuk)->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <td class="label">Status:</td>
                <td class="value" style="color: #28a745;">{{ ucfirst($sesi->status) }}</td>
            </tr>
        </table>

@if(strtolower($sesi->status) == 'lunas')
    <div class="total-box">
        <div class="total-label">Total Bayar</div>
        <div class="total-amount">Rp {{ number_format($sesi->biaya ?? 0, 0, ',', '.') }}</div>
    </div>
@else
    <div class="total-box" style="background-color: #fff3cd; border-color: #ffeeba;">
        <div class="total-label" style="color: #856404;">PENGINGAT</div>
        <div style="font-size: 13px; color: #856404; font-weight: bold; margin-top: 5px;">
            Jangan meninggalkan karcis ini di dalam kendaraan Anda!
        </div>
    </div>
@endif

        <div class="footer">
            <p>Selamat Datang Di KABASA Parkir<br>Harap Simpan Struk Ini</p>
        </div>
    </div>
</div>

<script>
    window.print();
</script>

</body>
</html>
