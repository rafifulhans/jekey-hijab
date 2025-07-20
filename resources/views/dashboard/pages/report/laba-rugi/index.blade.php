<x-dashboard>

    <div class="d-flex justify-content-end align-items-center mb-3">
        <div class="col-3">
            <form action="{{ route('laba-rugi') }}" method="POST">
                @csrf
                <input type="text" name="date-filter" class="form-control" value="{{ $date_filter ?? '' }}">
            </form>
        </div>

        <a href="{{ route('laba-rugi.export') }}" class="btn btn-success m-1" target="_blank">Export</a>
    </div>

    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">Laba / Rugi</h4>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                        <thead>
                            <tr>
                                <th scope="col" class="px-0 text-muted">Keterangan</th>
                                <th scope="col" class="px-0 text-muted text-end">Total (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-0 text-dark">Pendapatan:</td>
                            </tr>
                            @foreach ($laba_rugi['pendapatan'] as $lb)
                                <tr>
                                    @php
                                        if ($lb->jumlah > 1)
                                        {
                                            $nama_akun = $lb->nama_akun . ' (' . date('M') . ')';
                                        } else {
                                            $nama_akun = $lb->nama_akun . ' (' . App\Models\Ref::with('labaRugi')->where('id_ref', $lb->id_ref)->first()->kode . ')';
                                        }
                                    @endphp
                                    <td class="px-0">{{ $nama_akun }}</td>
                                    <td class="px-0 text-dark fw-medium text-end">{{ Number::currency($lb->total, 'IDR', 'id_ID') }}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td class="px-0 text-dark">Beban-Beban:</td>
                            </tr>
                            @foreach ($laba_rugi['beban'] as $rg)
                                <tr>
                                    @php
                                        if ($rg->jumlah > 1)
                                        {
                                            $nama_akun = $rg->nama_akun . ' (' . date('M') . ')';
                                        } else {
                                            $nama_akun = $lb->nama_akun . ' (' . App\Models\Ref::with('labaRugi')->where('id_ref', $lb->id_ref)->first()->kode . ')';
                                        }
                                    @endphp
                                    <td class="px-0">{{ $nama_akun }}</td>
                                    <td class="px-0 text-dark fw-medium text-end">{{ Number::currency($rg->total, 'IDR', 'id_ID') }}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td class="px-0 text-dark">Laba Bersih</td>
                                <td class="px-0 text-dark fw-bolder text-end">{{ Number::currency($total_bersih ?? 0, 'IDR', 'id_ID') }}</td>
                            </tr>
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