
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
    <h3>Jurnal Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th>Keterangan</th>
                <th>Ref</th>
                <th>Debet</th>
                <th>Kredit</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jurnal_transaksi as $jt)
                <tr>
                    <td>{{ $jt->nama_akun }}</td>
                    <td>{{ $jt->kode }}</td>
                    @switch($jt->type)
                        @case(1)
                            <td>{{ Number::currency($jt->total, 'IDR', 'id_ID') }}</td>
                            <td>-</td>
                            @break
                        @case(2)
                            <td>-</td>
                            <td>{{ Number::currency($jt->total, 'IDR', 'id_ID') }}</td>
                            @break
                    @endswitch
                    <td>{{ date('d-m-Y', strtotime($jt->tanggal)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>