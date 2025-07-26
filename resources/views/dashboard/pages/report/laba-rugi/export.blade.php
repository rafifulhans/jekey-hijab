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
            padding: var(--bs-badge-padding-y) var(--bs-badge-padding-x);
            font-weight: var(--bs-badge-font-weight);
            line-height: 1;
            color: var(--bs-badge-color);
            text-align: right;
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

        .fw-bold {
            font-weight: bold !important;
        }

        .text-dark {
            color: #818692ff !important;
        }
    </style>
</head>
<body>
    <header>
        <h3 class="title_report">Laba / Rugi</h3>
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
                    <th>Keterangan</th>
                    <th style="text-align: right!important;">Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-dark fw-bold">Pendapatan:</td>
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
                        <td class="badge badge-success" style="text-align: right;">{{ Number::currency($lb->total, 'IDR', 'id_ID') }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td class="text-dark fw-bold">Beban-Beban:</td>
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
                        <td  class="badge badge-danger" style="text-align: right;">{{ Number::currency($rg->total, 'IDR', 'id_ID') }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td class="text-dark fw-bold">Laba Bersih</td>
                    <td  style="text-align: right;"><strong>{{ Number::currency($total_bersih ?? 0, 'IDR', 'id_ID') }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>