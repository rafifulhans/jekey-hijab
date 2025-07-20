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
    <h3>Neraca Saldo</h3>
    <table border="1" cellspacing="0" cellpadding="4" width="100%">
        <thead>
            <tr>
                <th>Ref</th>
                <th>Akun</th>
                <th>Debet</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($neraca_saldo as $bukbes)
                <tr>
                    <td>{{ (\App\Models\Ref::where('id_ref', $bukbes->id_ref)->first()->kode ?? '') }}</td>
                    <td>{{ $bukbes->nama_akun }}</td>
                    <td>{{ Number::currency($bukbes->debit, 'IDR', 'id_ID') }}</td>
                    <td>{{ Number::currency($bukbes->kredit, 'IDR', 'id_ID') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>