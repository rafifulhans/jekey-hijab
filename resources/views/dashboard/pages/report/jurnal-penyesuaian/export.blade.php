<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            /* font-family: 'DejaVu Sans', sans-serif; */
            font-family: 'Courier New', Courier, monospace;
            padding: 1rem;
        }

        table {
            caption-side: bottom;
            border-collapse: collapse;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            --bs-table-color-type: initial;
            --bs-table-bg-type: initial;
            --bs-table-color-state: initial;
            --bs-table-bg-state: initial;
            --bs-table-color: #777e89;
            --bs-table-bg: var(--bs-body-bg);
            --bs-table-border-color: #ecf0f2;
            --bs-table-accent-bg: transparent;
            --bs-table-striped-color: #777e89;
            --bs-table-striped-bg: #ecf0f2;
            width: 100%;
            margin-bottom: 1rem;
            vertical-align: top;
            border-color: #ecf0f2;
            text-wrap: nowrap;
        }
        .table > :not(caption) > * > * {
            padding: 16px 16px;
            background-color: var(--bs-table-bg);
            border-bottom-width: var(--bs-border-width);
            box-shadow: inset 0 0 0 9999px var(--bs-table-bg-state, var(--bs-table-bg-type, var(--bs-table-accent-bg)));
        }
        .table > tbody {
            vertical-align: inherit;
        }
        .table > thead {
            text-align: left !important;
        }

        .table > thead > tr {
            background-color: #ecf0f2
        }

        table th {
            padding: .8rem 1rem!important;
            font-size: 0.675rem !important;
            text-align: left !important;
        }

        table td {
            padding: .8rem 1rem!important;
            font-size: 0.675rem !important;
        }

        table tr {
            border-bottom: 1px solid var(--bs-table-border-color);
            color: var(--bs-table-color);
        }

        header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 2rem;
            font-size: .775rem;
        }

        .title_report {
            margin: .5rem 0;
            text-transform: uppercase;
        }

        .subtitle_report {
            margin: .5rem 0;
        }

        .date_report {
            margin: .5rem 0;
            margin-top: 1.25rem;
        }

        .badge {
            --bs-badge-padding-x: 10px;
            --bs-badge-padding-y: 5px;
            --bs-badge-font-size: 0.875rem;
            --bs-badge-font-weight: 600;
            --bs-badge-color: #fff;
            --bs-badge-border-radius: 4px;
            display: inline-block;
            padding: var(--bs-badge-padding-y) var(--bs-badge-padding-x);
            font-weight: var(--bs-badge-font-weight);
            line-height: 1;
            color: var(--bs-badge-color);
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: var(--bs-badge-border-radius);
        }

        .badge-danger {
            color: #fc4b6c;
        }

        .badge-success {
            color: #20c997;
        }

        .text-bg-light {
            background-color: #ecf0f2 !important;
        }

        .fw-bolder {
            font-weight: bolder !important;
        }

        .text-dark {
            color: #777e89 !important;
        }
    </style>
</head>
<body>
    <header>
        <h3 class="title_report">Jurnal Penyesuaian</h3>
        <h3 class="subtitle_report">Jekey Hijab</h3>
        <p class="date_report">
          <b>Periode:</b> 
          {{ $periode }}
        </p>
    </header>

    <div class="table-responsive">
        <table class="table">
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
                                    <td>
                                    <span class="badge badge-success">{{ Number::currency($jup['total'], 'IDR', 'id_ID') }}</span>
                                    </td>
                                    <td>-</td>
                                    @break
                                @case(2)
                                    <td>-</td>
                                    <td>
                                    <span class="badge badge-danger">{{ Number::currency($jup['total'], 'IDR', 'id_ID') }}</span>
                                    </td>
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