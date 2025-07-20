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
    <h3>Jurnal Umum</h3>
    <table>
        <thead>
            <tr>
                <th colspan="2">Tanggal</th>
                <th>Keterangan</th>
                <th>Ref</th>
                <th>Debet</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jurnal_umum as $year => $jur_umum)
                @php $year_listed = []; @endphp
                @foreach ($jur_umum as $jum)
                @foreach ($jum as $key => $ju)
                <tr>
                    @if (!in_array($year, $year_listed))
                        <td>{{ $year }}</td>
                        @php $year_listed[] = $year; @endphp
                    @else
                        @if ($key > 0 && $key < 2)
                            <td>{{ date('F', strtotime($ju->tanggal)) }}</td>
                        @else
                            <td></td>
                        @endif
                    @endif
                    <td>{{ date('j', strtotime($ju->tanggal)) }}</td>
                    <td>{{ $ju->nama_akun }}</td>
                    <td>{{ (\App\Models\Ref::where('id_ref', $ju->id_ref)->first()->kode ?? '') }}</td>
                    @switch($ju->type)
                        @case(1)
                            <td>{{ Number::currency($ju->total, 'IDR', 'id_ID') }}</td>
                            <td>-</td>
                            @break
                        @case(2)
                            <td>-</td>
                            <td>{{ Number::currency($ju->total, 'IDR', 'id_ID') }}</td>
                            @break
                    @endswitch
                </tr>
                @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>