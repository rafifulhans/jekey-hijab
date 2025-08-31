<x-dashboard>
    @include('sweetalert::alert')

    <div class="d-flex justify-content-end align-items-center mb-3">
        <a href="{{ route('ref.tambah') }}" class="btn btn-primary m-1">Tambah</a>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">REF</h4>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                        <thead>
                            <tr>
                                <th scope="col" class="text-start">ID</th>
                                <th scope="col">Nama Akun</th>
                                <th scope="col">Kode</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($refs as $ref)
                                <tr>
                                    <td>{{ $ref->id_ref }}</td>
                                    <td>{{ $ref->nama_akun }}</td>
                                    <td>{{ $ref->kode }}</td>
                                    <td class="d-flex gap-2 text-end justify-content-end">
                                        <a href="{{ route('ref.edit', $ref->id_ref) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('ref.hapus', $ref->id_ref) }}" method="post">
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