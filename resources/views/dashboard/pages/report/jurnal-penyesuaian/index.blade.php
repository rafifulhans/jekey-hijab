<x-dashboard>
    
    @include('sweetalert::alert')

    @if (!empty($jurnal_transaksi))
        <div class="d-flex justify-content-end align-items-center mb-3">
        @if (auth()->user()->role == 3)
            <a href="{{ route('jurnal-penyesuaian.tambah') }}" class="btn btn-primary m-1">Tambah</a>
        @endif

            <a href="{{ route('jurnal-penyesuaian.export') }}" class="btn btn-success m-1" target="_blank">Export</a>
        </div>
    @else
        <div class="alert alert-warning">
            <i class="fw-bolder ti ti-help"></i>
            Mohon input jurnal transaksi terlebih dahulu!
        </div>
    @endif

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">Jurnal Penyesuaian</h4>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Ref</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                                @if (auth()->user()->role == 3)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if (empty($jurnal_transaksi))
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <i class="text-muted">Belum Ada Data</i>
                                    </td>
                                </tr>
                            @else
                                @foreach ($jurnal_penyesuaian as $date => $jurp)
                                    @foreach ($jurp as $jup)
                                        <tr>
                                            <td>{{ $date }}</td>
                                            <td>{{ $jup['nama_akun'] }}</td>
                                            <td>{{ \App\Models\Ref::with('jurnalPenyesuaian')->where('id_ref', $jup['id_ref'])->first()->kode }}</td>
                                            @switch($jup['type'])
                                                @case(1)
                                                    <td>{{ Number::currency($jup['total'], 'IDR', 'id_ID') }}</td>
                                                    <td>-</td>
                                                    @break
                                                @case(2)
                                                    <td>-</td>
                                                    <td>{{ Number::currency($jup['total'], 'IDR', 'id_ID') }}</td>
                                                    @break
                                            @endswitch
                                            <td>
                                                @if (auth()->user()->role == 3)
                                                    <a href="{{ route('jurnal-penyesuaian.edit', $jup['id_jurnal_penyesuaian']) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    <form action="{{ route('jurnal-penyesuaian.hapus', $jup['id_jurnal_penyesuaian']) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>

            $(document).ready(function () {

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