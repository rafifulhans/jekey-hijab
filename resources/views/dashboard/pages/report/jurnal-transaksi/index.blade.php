<x-dashboard>
    
    @include('sweetalert::alert')
        
    <div class="d-flex align-items-center justify-content-end mb-3">
        <div class="col-3">
            <form action="{{ route('jurnal-transaksi') }}" method="POST">
                @csrf
                <input type="text" name="date-filter" class="form-control" value="{{ $date_filter ?? '' }}">
            </form>
        </div>

        @if (auth()->user()->role == 3)
            <a href="{{ route('jurnal-transaksi.tambah') }}" class="btn btn-primary m-1">Tambah</a>
        @endif

        <a href="{{ route('jurnal-transaksi.export') }}" class="btn btn-success m-1" target="_blank">Export</a>
    </div>


    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">Jurnal Tranksaksi</h4>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Keterangan</th>
                                <th>Ref</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                                <th>Tanggal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jurnal_transaksi as $jt)
                                <tr>
                                    <td>{{ $jt->id_jurnal_transaksi }}</td>
                                    <td>{{ $jt->nama_akun }}</td>
                                    <td>{{ $jt->kode }}</td>
                                    @switch($jt->type)
                                        @case(1)
                                            <td>{{ Number::currency($jt->total, 'IDR', 'id_ID') }}</td>
                                            <td>-</td>
                                            @break
                                        @case(2)
                                            <td>-</td>
                                            <td>{{ Number::currency($jt->total, 'IDR', 'id_ID') }}</td>
                                            @break
                                    @endswitch
                                    <td>{{ date('d-m-Y', strtotime($jt->tanggal)) }}</td>
                                    <td>
                                        <a href="{{ route('jurnal-transaksi.edit', $jt->id_jurnal_transaksi) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('jurnal-transaksi.hapus', $jt->id_jurnal_transaksi) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                                        </form>
                                    </td>
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

                $('.btn-delete').on('click', function (e) {
                    e.preventDefault();
                    var form = $(this).closest('form');
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    })
                });
            });
        </script>
    @endsection


</x-dashboard>