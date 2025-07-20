<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="d-md-flex align-items-center">
        <div>
            <h4 class="card-title">
                <span>Buku Besar</span>
            </h4>
        </div>
    </div>
    @foreach ($buku_besar_grouped as $group => $bukbes_grouped)
        <table class="table mb-0 text-nowrap varient-table align-middle">
            <thead>
                <tr>
                    <th colspan="8" style="background-color: lightgray;">
                        {{ strtoupper($group) }}
                    </th>
                </tr>
            </thead>
        </table>
        @foreach ($bukbes_grouped as $ref => $bukb_group)

            <div class="table-responsive mt-4 mb-5">
                <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                    <thead>
                        <tr>
                            <th colspan="8">
                                {{ App\Models\Ref::with('bukuBesar')->where('kode', $ref)->first()->nama_akun }}
                                ({{ $ref }})
                            </th>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <th></th>
                            <th>Keterangan</th>
                            <th>Ref</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                            <th colspan="2">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2">
                            <td>Debit</td>
                            <td>Kredit</td>
                            </td>
                        </tr>
                        @foreach ($bukb_group as $buk_group)
                            @foreach ($buk_group as $bkg)
                                @php
                                    $year_listed = [];
                                    $saldo = 0;
                                @endphp
                                @foreach ($bkg as $key => $bg)
                                    @php
                                        $saldo += $bg->debit - $bg->kredit;
                                    @endphp
                                    <tr>
                                        @if (!in_array(date('Y', strtotime($bg->tanggal)), $year_listed))
                                            <td>{{ date('Y', strtotime($bg->tanggal)) }}</td>
                                            @php
                                                $year_listed[] = date('Y', strtotime($bg->tanggal));
                                            @endphp
                                        @else
                                            @if ($key > 0 && $key < 2)
                                                <td>{{ date('F', strtotime($bg->tanggal)) }}</td>
                                            @else
                                                <td></td>
                                            @endif
                                        @endif
                                        <td>{{ date('j', strtotime($bg->tanggal)) }}</td>
                                        <td>{{ $bg->keterangan }}</td>
                                        <td>{{ $bg->group }}</td>
                                        <td>{{ $bg->debit != 0 ? Number::currency($bg->debit, 'IDR', 'id_ID') : '-' }}</td>
                                        <td>{{ $bg->kredit != 0 ? Number::currency($bg->kredit, 'IDR', 'id_ID') : '-' }}</td>
                                        @if ($bg->debit != 0)
                                            <td>{{ Number::currency(abs($saldo), 'IDR', 'id_ID') }}</td>
                                            <td>{{ Number::currency(0, 'IDR', 'id_ID') }}</td>
                                        @else
                                            <td>{{ Number::currency(0, 'IDR', 'id_ID') }}</td>
                                            <td>{{ Number::currency(abs($saldo), 'IDR', 'id_ID') }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach

    @endforeach
</body>

</html>