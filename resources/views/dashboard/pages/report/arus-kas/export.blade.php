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
    <h3>Arus Kas</h3>
    <table border="1" cellspacing="0" cellpadding="4" width="100%">
        <thead>
            <tr>
                <th>Keterangan</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Arus Kas dari Operasi:</td>
                <td></td>
            </tr>
            @foreach ($arus_kas['masuk'] as $ak)
                @php
                    if ($ak->jumlah > 1) {
                        $nama_akun = $ak->nama_akun . ' (' . date('M') . ')';
                    } else {
                        $nama_akun = $ak->nama_akun . ' (' . App\Models\Ref::with('labaRugi')->where('id_ref', $ak->id_ref)->first()->kode . ')';
                    }
                @endphp
                <tr>
                    <td>{{ $nama_akun }}</td>
                    <td>{{ Number::currency($ak->total, 'IDR', 'id_ID') }}</td>
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
            @foreach ($arus_kas['keluar'] as $ak)
                @php
                    if ($ak->jumlah > 1) {
                        $ak->nama_akun = $ak->nama_akun . ' (' . date('M') . ')';
                    }
                @endphp
                <tr>
                    <td>{{ $ak->nama_akun }}</td>
                    <td>{{ Number::currency($ak->total, 'IDR', 'id_ID') }}</td>
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