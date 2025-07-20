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
    <div class="d-md-flex align-items-center">
                    <div>
                        <h4>Jurnal Penyesuaian</h4>
                    </div>
                </div>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Ref</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jurnal_penyesuaian as $date => $jurp)
                                @foreach ($jurp as $jup)
                                    <tr>
                                        <td>{{ $date }}</td>
                                        <td>{{ $jup['nama_akun'] }}</td>
                                        <td>{{ \App\Models\Ref::with('jurnalPenyesuaian')->where('id_ref', $jup['id_ref'])->first()->kode }}</td>
                                        @switch($jup['type'])
                                            @case(1)
                                                <td>{{ Number::currency($jup['total'], 'IDR', 'id_ID') }}</td>
                                                <td>-</td>
                                                @break
                                            @case(2)
                                                <td>-</td>
                                                <td>{{ Number::currency($jup['total'], 'IDR', 'id_ID') }}</td>
                                                @break
                                        @endswitch
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
</body>
</html>