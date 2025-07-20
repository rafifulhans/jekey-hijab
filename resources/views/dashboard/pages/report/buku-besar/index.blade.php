<x-dashboard>

    <div class="d-flex justify-content-end align-items-center mb-3">
        <div class="col-3">
            <form action="{{ route('buku-besar') }}" method="POST">
                @csrf
                <input type="text" name="date-filter" class="form-control" value="{{ $date_filter ?? '' }}">
            </form>
        </div>

        <a href="{{ route('buku-besar.export') }}" class="btn btn-success m-1" target="_blank">Export</a>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">
                            <span>Buku Besar</span>
                            <span class="fs-3 fw-light text-muted">
                                <i>(Grouped)</i>
                            </span>
                        </h4>
                    </div>
                </div>
                @foreach ($buku_besar_grouped as $group => $bukbes_grouped)
                    <table class="table mb-0 text-nowrap varient-table align-middle">
                        <thead>
                            <tr>
                                <th colspan="8" class="text-bg-light">
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
                                        <th class="text-dark">
                                            {{ App\Models\Ref::with('bukuBesar')->where('kode', $ref)->first()->nama_akun }}
                                        </th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>{{ $ref }}</th>
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
                                    @php
                                        $year_listed = [];
                                    @endphp
                                    @foreach ($bukb_group as $year => $buk_group)
                                        @php
                                            $month_listed = $date_listed  = [];
                                        @endphp
                                        @foreach ($buk_group as $month => $bkg)
                                            @php
                                                $saldo = 0;
                                            @endphp
                                            @foreach ($bkg as $key => $bg)
                                                @php
                                                    $saldo += $bg->debit - $bg->kredit;
                                                @endphp
                                                <tr>

                                                    @if (count($buk_group) == 1)
                                                        <td>
                                                            {{ $year }}<i>{{ ' - '.date('F', strtotime($bg->tanggal)) }}</i>
                                                        </td>
                                                    @else
                                                        @if (!in_array($year, $year_listed))
                                                            @if (count($bkg) == 1)
                                                                <td>
                                                                    {{ $year }}<i>{{ ' - '.date('F', strtotime($bg->tanggal)) }}</i>
                                                                </td>
                                                            @else
                                                                <td>{{ $year }}</td>
                                                            @endif
                                                            @php
                                                                $year_listed[] = $year;
                                                            @endphp
                                                        @else

                                                            @if (!in_array($month, $month_listed))
                                                                <td>
                                                                    <i>{{ date('F', strtotime($bg->tanggal)) }}</i>
                                                                </td>
                                                                @php
                                                                    $month_listed[] = $month;
                                                                @endphp
                                                            @else
                                                                <td></td>
                                                            @endif
                                                        @endif
                                                    @endif

                                                    @if (!in_array(date('j', strtotime($bg->tanggal)), $date_listed))
                                                        @php
                                                            $date_listed[] = date('j', strtotime($bg->tanggal));
                                                        @endphp
                                                        <td>{{ date('j', strtotime($bg->tanggal)) }}</td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    
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

            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">
                            <span>Buku Besar</span>
                            <span class="fs-3 fw-light text-muted">
                                <i>(Ungroup)</i>
                            </span>
                        </h4>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                                <th>Acton</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($buku_besar_ungrouped as $bukbes_ungrouped)
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime($bukbes_ungrouped->tanggal)) }}</td>
                                    <td>{{ Number::currency($bukbes_ungrouped->debit, 'IDR', 'id_ID') }}</td>
                                    <td>{{ Number::currency($bukbes_ungrouped->kredit, 'IDR', 'id_ID') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm add-group-btn"
                                            data-id="{{ $bukbes_ungrouped->id_buku_besar }}">Add Group</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addGroupModal" tabindex="-1" aria-labelledby="addGroupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addGroupForm" method="POST" action="{{ route('buku-besar.add-group') }}">
                @csrf
                <input type="hidden" name="id_buku_besar" id="modal_id_buku_besar">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addGroupModalLabel">Tambah Group</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="group" class="form-label">Nama Group</label>
                            <input type="text" class="form-control" id="group" name="group" required>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
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
                
                $('.add-group-btn').on('click', function () {
                    var id = $(this).data('id');
                    $('#modal_id_buku_besar').val(id);
                    $('#addGroupModal').modal('show');
                });
            });
        </script>
    @endsection
</x-dashboard>