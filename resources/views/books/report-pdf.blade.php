<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Buku</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px 8px;
        }

        th {
            background: #f2f2f2;
            text-transform: uppercase;
            font-size: 10px;
        }

        .mono {
            font-family: monospace;
            font-size: 10px;
        }

        .right {
            text-align: right;
        }

        .small {
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>
    <h3>Laporan Buku Perpustakaan</h3>
    <div class="small">Dicetak: {{ $printed }}</div>
    <br>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Kode Aset YPT</th>
                <th>Judul/Nama</th>
                <th>Tahun</th>
                <th>Lokasi</th>
                <th>PIC</th>
                <th>Status</th>
                <th class="right">Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $i => $b)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="mono">{{ $b['asset_code_ypt'] }}</td>
                    <td>{{ $b['name'] }}</td>
                    <td>{{ $b['purchase_year'] }}</td>
                    <td>{{ $b['building'] }} / {{ $b['room'] }}</td>
                    <td>{{ $b['person_in_charge'] }}</td>
                    <td>{{ $b['status'] }}</td>
                    <td class="right">{{ number_format((float) $b['purchase_cost'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="right">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
