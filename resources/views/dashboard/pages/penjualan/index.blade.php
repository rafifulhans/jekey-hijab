<x-dashboard>

    @include('sweetalert::alert')

    @if (auth()->user()->role == 2)
        <div class="d-flex justify-content-end align-items-center mb-3">
            <a href="{{ route('penjualan.tambah') }}" class="btn btn-primary m-1">Tambah</a>
        </div>
    @endif

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">Penjualan</h4>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                        <thead>
                            <tr>
                                <th scope="col" class="text-start">ID Transaksi</th>
                                <th scope="col" class="text-center">Marketplace</th>
                                <th scope="col" class="text-center">Nomor Resi</th>
                                <th scope="col" class="text-center">Nama Produk</th>
                                <th scope="col" class="text-center">Nama Varian</th>
                                <th scope="col" class="text-center">QTY</th>
                                <th scope="col" class="text-center">Subtotal</th>
                                <th scope="col" class="text-center">Diskon</th>
                                <th scope="col" class="text-center">Ongkos Kirim</th>
                                <th scope="col" class="text-center">Total</th>
                                <th scope="col" class="text-center">Alamat Pembeli</th>
                                <th scope="col" class="text-center">Email Pembeli</th>
                                <th scope="col" class="text-center">Nomor Telepon Pembeli</th>
                                <th scope="col" class="text-center">Status Order</th>
                                <th scope="col" class="text-center">Status Pembayaran</th>
                                <th scope="col" class="text-center">Metode Pembayaran</th>
                                <th scope="col" class="text-center">Tanggal Pembayaran</th>
                                <th scope="col" class="text-end">Status Persetujuan</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualans as $penjualan)
                                <tr>
                                    <td class="text-center">
                                        <h6 class="mb-0">{{ $penjualan->id_penjualan }}</h6>
                                    </td>
                                    <td>{{ $penjualan->nama_marketplace }}</td>
                                    <td>{{ $penjualan->nomor_resi }}</td>
                                    <td>{{ $penjualan->nama_produk }}</td>
                                    <td>{{ $penjualan->nama_varian ?? '-' }}</td>
                                    <td>{{ $penjualan->qty }}</td>
                                    <td>{{ $penjualan->subtotal }}</td>
                                    <td>{{ $penjualan->diskon }}</td>
                                    <td>{{ $penjualan->ongkir }}</td>
                                    <td>{{ $penjualan->total }}</td>
                                    <td>{{ $penjualan->alamat_pembeli }}</td>
                                    <td>{{ $penjualan->email_pembeli }}</td>
                                    <td>{{ $penjualan->nomor_telepon_pembeli }}</td>
                                    <td>{{ config('status.order')[$penjualan->status_order] }}</td>
                                    <td>{{ config('status.pembayaran')[$penjualan->status_pembayaran] }}</td>
                                    <td>{{ $penjualan->metode_pembayaran }}</td>
                                    <td>{{ \Carbon\Carbon::parse($penjualan->tanggal_pembayaran)->translatedFormat('d-m-Y') }}</td>
                                    <td>{{ config('status.persetujuan')[$penjualan->status_persetujuan] }}</td>
                                    <td>
                                        @if (auth()->user()->role == 2)
                                            @if ($penjualan->status_persetujuan == 2 || $penjualan->status_persetujuan == 0)
                                                <a href="{{ route('penjualan.edit', $penjualan->id_penjualan) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('penjualan.hapus', $penjualan->id_penjualan) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                                                </form>
                                                @else
                                                {{ '-' }}
                                            @endif
                                        @elseif (auth()->user()->role == 3)
                                            @if ($penjualan->status_persetujuan == 0)
                                                <form action="{{ route('penjualan.approve', $penjualan->id_penjualan) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-success btn-sm btn-approve">Approve</button>
                                                </form>
                                                <form action="{{ route('penjualan.koreksi', $penjualan->id_penjualan) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-warning btn-sm btn-koreksi">Koreksi</button>
                                                </form>
                                                <form action="{{ route('penjualan.reject', $penjualan->id_penjualan) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-danger btn-sm btn-tolak">Tolak</button>
                                                </form>
                                            @else
                                                {{ '-' }}
                                            @endif
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

                $('.btn-approve').on('click', function (e) {
                    e.preventDefault();
                    var form = $(this).closest('form');
                    Swal.fire({
                        title: 'Yakin ingin menyetujui?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, setuju!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    })
                });

                $('.btn-koreksi').on('click', function (e) {
                    e.preventDefault();
                    var form = $(this).closest('form');
                    Swal.fire({
                        title: 'Yakin ingin mengkoreksi?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, koreksi!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    })
                });

                $('.btn-tolak').on('click', function (e) {
                    e.preventDefault();
                    var form = $(this).closest('form');
                    Swal.fire({
                        title: 'Yakin ingin menolak?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, tolak!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    })
                })

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