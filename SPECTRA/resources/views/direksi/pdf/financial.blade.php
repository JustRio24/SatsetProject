<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan Konsolidasi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 20px; text-transform: uppercase; }
        .header p { margin: 5px 0; font-size: 10px; color: #666; }
        .section-title { font-size: 14px; font-weight: bold; margin-top: 20px; border-left: 4px solid #ef4444; padding-left: 10px; background: #f9fafb; padding-top: 5px; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #1e293b; color: #fff; padding: 10px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 10px; border-bottom: 1px solid #e5e7eb; }
        .total-row { font-weight: bold; background: #f3f4f6; }
        .summary-box { margin-top: 30px; width: 300px; margin-left: auto; border: 1px solid #e5e7eb; padding: 15px; border-radius: 8px; }
        .summary-item { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .profit { color: #059669; font-weight: bold; font-size: 14px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PT. SATSET MERAHPUTIH INDONESIA</h1>
        <p>Gedung SatSet Center, Lantai 42, Jakarta Selatan | Telp: (021) 555-SATSET</p>
        <p>LAPORAN LABA RUGI KONSOLIDASI (DRAFT)</p>
        <p>Periode: {{ now()->format('F Y') }}</p>
    </div>

    <div class="section-title">Ringkasan Pendapatan per Proyek</div>
    <table>
        <thead>
            <tr>
                <th>Nama Klien / Proyek</th>
                <th>Area</th>
                <th>Lini Bisnis</th>
                <th>Nilai Kontrak</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
            <tr>
                <td>{{ $project->client_name }}</td>
                <td>{{ $project->area }}</td>
                <td>{{ $project->service_type }}</td>
                <td>Rp {{ number_format($project->contract_value, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3" style="text-align: right;">TOTAL PENDAPATAN</td>
                <td>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Analisis Pengeluaran & Laba</div>
    <table>
        <tr>
            <td width="70%">Total Gaji & Bagi Hasil (Pekerja & Korlap)</td>
            <td>(Rp {{ number_format($salaries, 0, ',', '.') }})</td>
        </tr>
        <tr>
            <td>Biaya Operasional (10% Estimasi)</td>
            <td>(Rp {{ number_format($operational, 0, ',', '.') }})</td>
        </tr>
        <tr>
            <td>Estimasi Pajak (11%)</td>
            <td>(Rp {{ number_format($tax, 0, ',', '.') }})</td>
        </tr>
        <tr>
            <td>Biaya Lain-lain (Admin & Marketing)</td>
            <td>(Rp {{ number_format($totalOtherExpenses, 0, ',', '.') }})</td>
        </tr>
        <tr class="total-row">
            <td style="text-align: right; color: #059669;">LABA BERSIH (EBITDA)</td>
            <td class="profit">Rp {{ number_format($netProfit, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div style="margin-top: 50px;">
        <table style="border: none;">
            <tr>
                <td style="border: none; text-align: center;" width="50%">
                    Disiapkan Oleh,<br><br><br><br>
                    <strong>( Admin Keuangan )</strong>
                </td>
                <td style="border: none; text-align: center;" width="50%">
                    Disetujui Oleh,<br><br><br><br>
                    <strong>( Direktur Utama )</strong>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Dokumen ini dihasilkan secara otomatis oleh <strong>SPECTRA (System for Project, Earnings, & Comprehensive Task Reporting Analysis)</strong> pada {{ now()->format('d/m/Y H:i:s') }}. <br>
        Seluruh data bersifat rahasia dan milik PT. SatSet MerahPutih Indonesia.
    </div>
</body>
</html>
