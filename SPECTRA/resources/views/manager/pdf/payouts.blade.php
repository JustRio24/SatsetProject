<!DOCTYPE html>
<html>
<head>
    <title>Rekap Gaji & Bagi Hasil Area</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #3b82f6; color: #fff; padding: 8px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #eee; }
        .footer { margin-top: 30px; font-size: 9px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REKAP GAJI & BAGI HASIL - AREA {{ strtoupper($user->area) }}</h1>
        <p>PT. SATSET MERAHPUTIH INDONESIA</p>
        <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Penerima</th>
                <th>Role</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payouts as $payout)
            <tr>
                <td>{{ $payout->recipient_name }}</td>
                <td>{{ strtoupper($payout->recipient_role) }}</td>
                <td>Rp {{ number_format($payout->amount, 0, ',', '.') }}</td>
                <td>{{ strtoupper($payout->type) }}</td>
                <td>{{ $payout->realized_at ? 'SUDAH DIBAYAR' : 'PENDING' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh Manager Area: {{ $user->name }} <br>
        Dokumen ini merupakan lampiran resmi untuk pengajuan pencairan dana ke Departemen Keuangan.
    </div>
</body>
</html>
