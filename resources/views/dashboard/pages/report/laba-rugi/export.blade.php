<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
    </style>
</head>
<body>
    <h3>Laba / Rugi</h3>
    <table border="1" cellspacing="0" cellpadding="4" width="100%">
        <thead>
            <tr>
                <th>Keterangan</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pendapatan:</td>
                <td></td>
            </tr>
            @foreach ($laba_rugi['pendapatan'] as $lb)
                @php
                    if ($lb->jumlah > 1) {
                        $nama_akun = $lb->nama_akun . ' (' . date('M') . ')';
                    } else {
                        $nama_akun = $lb->nama_akun . ' (' . App\Models\Ref::with('labaRugi')->where('id_ref', $lb->id_ref)->first()->kode . ')';
                    }
                @endphp
                <tr>
                    <td>{{ $nama_akun }}</td>
                    <td>{{ Number::currency($lb->total, 'IDR', 'id_ID') }}</td>
                </tr>
            @endforeach

            <tr>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Beban-Beban:</td>
                <td></td>
            </tr>
            @foreach ($laba_rugi['beban'] as $rg)
                @php
                    if ($rg->jumlah > 1) {
                        $rg->nama_akun = $rg->nama_akun . ' (' . date('M') . ')';
                    }
                @endphp
                <tr>
                    <td>{{ $rg->nama_akun }}</td>
                    <td>{{ Number::currency($rg->total, 'IDR', 'id_ID') }}</td>
                </tr>
            @endforeach

            <tr>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Laba Bersih</td>
                <td><strong>{{ Number::currency($total_bersih ?? 0, 'IDR', 'id_ID') }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>