<x-dashboard>

    <div class="d-flex justify-content-end align-items-center mb-3">
        <div class="col-3">
            <form action="{{ route('arus-kas') }}" method="POST">
                @csrf
                <input type="text" name="date-filter" class="form-control" value="{{ $date_filter ?? '' }}">
            </form>
        </div>

        <a href="{{ route('arus-kas.export') }}" class="btn btn-success m-1" target="_blank">Export</a>
    </div>

    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">Arus Kas</h4>
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
                                <td colspan="2" class="px-0 text-dark">Arus Kas dari Aktivitas Operasi</td>
                            </tr>
                            @foreach ($arus_kas['masuk'] as $ak)
                                <tr>
                                    @php
                                        if ($ak->jumlah > 1)
                                        {
                                            $nama_akun = $ak->nama_akun . ' (' . date('M') . ')';
                                        } else {
                                            $nama_akun = $ak->nama_akun . ' (' . App\Models\Ref::with('labaRugi')->where('id_ref', $ak->id_ref)->first()->kode . ')';
                                        }
                                    @endphp
                                    <td class="px-0">{{ $nama_akun }}</td>
                                    <td class="px-0 text-dark fw-medium text-end">{{ Number::currency($ak->total, 'IDR', 'id_ID') }}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <td class="px-0 text-dark">Total Pendapatan</td>
                                <td class="px-0 text-dark fw-medium text-end">{{ Number::currency($total_pendapatan ?? 0, 'IDR', 'id_ID') }}</td>
                            </tr>

                             <tr>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td colspan="2" class="px-0 text-dark">Beban-Beban</td>
                            </tr>
                            @foreach ($arus_kas['keluar'] as $ak)
                                <tr>
                                    @php
                                        if ($ak->jumlah > 1)
                                        {
                                            $nama_akun = $ak->nama_akun . ' (' . date('M') . ')';
                                        } else {
                                            $nama_akun = $ak->nama_akun . ' (' . App\Models\Ref::with('labaRugi')->where('id_ref', $ak->id_ref)->first()->kode . ')';
                                        }
                                    @endphp
                                    <td class="px-0">{{ $nama_akun }}</td>
                                    <td class="px-0 text-dark fw-medium text-end">{{ Number::currency($ak->total, 'IDR', 'id_ID') }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="px-0 text-dark">Total Beban:</td>
                                <td class="px-0 text-dark fw-medium text-end">{{ Number::currency($total_pengeluaran ?? 0, 'IDR', 'id_ID') }}</td>
                            </tr>

                            <tr>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td class="px-0 text-dark">Arus Kas Bersih dari Aktivitas Operasi</td>
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