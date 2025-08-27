<x-dashboard>

    <div class="d-flex justify-content-end align-items-center mb-3">
        <div class="col-3">
            <form action="{{ route('neraca-saldo') }}" method="POST">
                @csrf
                <input type="text" name="date-filter" class="form-control" value="{{ $date_filter ?? '' }}">
            </form>
        </div>

        <a href="{{ route('neraca-saldo.export') }}" class="btn btn-success m-1" target="_blank">Export</a>
    </div>
    
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">Neraca Saldo</h4>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
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
                            <tr>
                                <td class="text-bg-light"></td>
                                <td class="text-bg-light fw-bolder">Jumlah</td>
                                <td class="text-bg-light fw-bolder">{{ Number::currency($neraca_saldo->sum('debit'), 'IDR', 'id_ID') }}</td>
                                <td class="text-bg-light fw-bolder">{{ Number::currency($neraca_saldo->sum('kredit'), 'IDR', 'id_ID') }}</td>
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