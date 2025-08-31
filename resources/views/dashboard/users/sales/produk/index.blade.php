<x-dashboard>
    @include('sweetalert::alert')

    <div class="d-flex justify-content-end align-items-center mb-3">
        <a href="{{ route('produk.tambah') }}" class="btn btn-primary m-1">Tambah</a>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">Produk</h4>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                        <thead>
                            <tr>
                                <th scope="col" class="text-start">ID</th>
                                <th scope="col">Nama Produk</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Gambar</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produks as $prod)
                                <tr>
                                    <td>{{ $prod->id_produk }}</td>
                                    <td>{{ $prod->nama }}</td>
                                    <td>
                                        <i>{{ Number::currency($prod->harga, 'IDR', 'id_ID') }}</i>
                                    </td>
                                    <td>{{ $prod->deskripsi }}</td>
                                    <td>
                                        @if (empty($prod->image))
                                            <span class="text-muted text-center"><i>-</i></span>
                                        @else
                                            <img src="{{ asset('uploads/produk/' . $prod->image) }}" alt="Thumbnail Image Produk" class="cursor-pointer" width="100" height="100"style="object-fit:cover;">
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('produk.edit', $prod->id_produk) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('produk.hapus', $prod->id_produk) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-delete btn-sm">Hapus</button>
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
    <script>
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
    </script>
    @endsection

</x-dashboard>