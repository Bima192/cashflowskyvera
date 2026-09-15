<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #344054; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        .sub { font-size: 11px; color: #667085; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th { background: #f8f9fc; padding: 8px 10px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #eaecf0; }
        td { padding: 8px 10px; border-bottom: 1px solid #eaecf0; }
        .summary { margin-top: 20px; padding: 14px; background: #f8f9fc; border-radius: 6px; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 6px; }
        .text-success { color: #12b76a; }
        .text-danger { color: #f04438; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h1>Laporan Keuangan Tahunan</h1>
    <div class="sub">Tahun {{ $tahun }}</div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Jenis</th>
                <th class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $trx)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</td>
                    <td>{{ $trx->kategori }}</td>
                    <td class="{{ $trx->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                        {{ ucfirst($trx->jenis) }}
                    </td>
                    <td class="text-right {{ $trx->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                        {{ $trx->jenis == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($trx->nominal, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center; color:#667085;">Tidak ada transaksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-row"><span>Total Pemasukan</span> <strong class="text-success">Rp {{ number_format($pendapatan, 0, ',', '.') }}</strong></div>
        <div class="summary-row"><span>Total Pengeluaran</span> <strong class="text-danger">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</strong></div>
        <div class="summary-row" style="border-top: 1px solid #eaecf0; padding-top:6px; margin-top:6px;">
            <span><strong>Saldo Akhir</strong></span>
            <strong>Rp {{ number_format($saldo, 0, ',', '.') }}</strong>
        </div>
    </div>

    <div style="margin-top: 30px; font-size: 10px; color: #667085; text-align: right;">
        Dicetak: {{ now()->format('d M Y H:i') }}
    </div>
</body>
</html>

