<x-dashboard>

    @include('sweetalert::alert')

    @if (auth()->user()->role == 3)
        <div class="d-flex justify-content-end align-items-center mb-3">
            <a href="{{ route('piutang.tambah') }}" class="btn btn-primary m-1">Tambah</a>
        </div>
    @endif

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">Piutang</h4>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                        <thead>
                            <tr>
                                <th class="text-start">Kode Piutang</th>
                                <th>Tanggal Transaksi</th>
                                <th>Nama Pelanggan</th>
                                <th>Jumlah Piutang</th>
                                <th>Jatuh Tempo</th>
                                <th>Status Pembayaran</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($piutang as $piu)
                                <tr>
                                    <td>
                                        <h6 class="mb-0">{{ $piu->kode }}</h6>
                                    </td>
                                    <td>{{ date('d-m-Y', strtotime($piu->tanggal)) }}</td>
                                    <td>{{ $piu->nama_pelanggan }}</td>
                                    <td>{{ Number::currency($piu->jumlah, 'IDR', 'id_ID') }}</td>
                                    <td>{{ date('d-m-Y', strtotime($piu->jatuh_tempo)) }}</td>
                                    <td>{{ $piu->status_pembayaran }}</td>
                                    <td>
                                        @if (auth()->user()->role == 3)
                                            <a href="{{ route('piutang.edit', $piu->id_piutang) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('piutang.hapus', $piu->id_piutang) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                                            </form>
                                        @else
                                            {{ '-' }}
                                        @endif
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