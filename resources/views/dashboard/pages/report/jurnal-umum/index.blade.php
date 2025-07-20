<x-dashboard>

    <div class="d-flex justify-content-end align-items-center mb-3">
        <div class="col-3">
            <form action="{{ route('jurnal-umum') }}" method="POST">
                @csrf
                <input type="text" name="date-filter" class="form-control" value="{{ $date_filter ?? '' }}">
            </form>
        </div>

        <a href="{{ route('jurnal-umum.export') }}" class="btn btn-success m-1" target="_blank">Export</a>
    </div>

    
    
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">Jurnal Umum</h4>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
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
                             @php 
                                $year_listed = [];
                            @endphp
                            @foreach ($jurnal_umum as $year => $jur_umum)
                                @php
                                    $month_listed = $date_listed = [];
                                @endphp
                                @foreach ($jur_umum as $month => $jum)
                                    @if (is_numeric($month))
                                        @foreach ($jum as $key => $ju)    
                                            <tr>

                                                @if (count($jum) == 1)
                                                    <td>
                                                        {{ $year }}<i>{{ ' - '.date('F', strtotime($ju->tanggal)) }}</i>
                                                    </td>
                                                @else
                                                    @if (!in_array($year, $year_listed))
                                                        <td>{{ $year }}</td>
                                                        @php
                                                            $year_listed[] = $year;
                                                        @endphp
                                                    @else

                                                        @if (!in_array($month, $month_listed))
                                                            <td>
                                                                <i>{{ date('F', strtotime($ju->tanggal)) }}</i>
                                                            </td>
                                                            @php
                                                                $month_listed[] = $month;
                                                            @endphp
                                                        @else
                                                            <td></td>
                                                        @endif
                                                    @endif
                                                @endif

                                                @if (!in_array(date('j', strtotime($ju->tanggal)), $date_listed))
                                                    @php
                                                        $date_listed[] = date('j', strtotime($ju->tanggal));
                                                    @endphp
                                                    <td>{{ date('j', strtotime($ju->tanggal)) }}</td>
                                                @else
                                                    <td></td>
                                                @endif

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
                                    @endif
                                @endforeach

                                <tr>
                                    <td class="text-bg-light" colspan="2"></td>
                                    <td class="text-bg-light fw-bolder text-dark">Jumlah</td>
                                    <td class="text-bg-light"></td>
                                    <td class="text-bg-light fw-bolder text-dark">{{ Number::currency($jur_umum['total'][1] ?? 0, 'IDR', 'id_ID') }}</td>
                                    <td class="text-bg-light fw-bolder text-dark">{{ Number::currency($jur_umum['total'][2] ?? 0, 'IDR', 'id_ID') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script type="text/javascript">

            $(document).ready(function () {

                $('input[name="date-filter"]').daterangepicker();
                $('input[name="date-filter"]').on('apply.daterangepicker', function () {
                    $(this).closest('form').submit();
                })

                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }
            });

        </script>
    @endsection

</x-dashboard>