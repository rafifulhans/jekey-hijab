<x-dashboard>

    @include('sweetalert::alert')

    @if (auth()->user()->role == 3)
        <div class="d-flex justify-content-end align-items-center mb-3">
            <a href="{{ route('pengeluaran-grosir.tambah') }}" class="btn btn-primary m-1">Tambah</a>
        </div>
    @endif

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">Pengeluaran Grosir</h4>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                        <thead>
                            <tr>
                                <th>Tujuan Pengeluaran</th>
                                <th>Dokumen Pendukung</th>
                                <th>Sumber Dana</th>
                                <th>Catatan By Pemimpin</th>
                                <th>Nominal</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Tanggal Respon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengeluaran_grosir as $pgr)
                                <tr>
                                    <td>{{ $pgr->tujuan }}</td>
                                    <td>
                                        @if (empty($pgr->dokumen))
                                            <span class="text-muted text-center"><i>-</i></span>
                                        @else
                                            <img src="{{ asset('uploads/' . $pgr->dokumen) }}" alt="Thumbnail Dokumen Pendukung"
                                                class="cursor-pointer dokumen-img" width="100" height="100"
                                                style="object-fit:cover;">
                                        @endif
                                    </td>
                                    <td>{{ $pgr->sumber_dana }}</td>
                                    <td>
                                        @if ($pgr->catatan_pemimpin == null)
                                            <span class="text-muted"><i>- Belum Ada -</i></span>
                                        @else
                                            {{ $pgr->catatan_pemimpin ?? '-' }}
                                        @endif
                                    </td>
                                    <td>
                                        <h6 class="mb-0">{{ Number::currency($pgr->nominal, 'IDR', 'id_ID') }}</h6>
                                    </td>
                                    <td>{{ date('d-m-Y H:i:s', strtotime($pgr->created_at)) }}</td>
                                    <td>{{ date('d-m-Y H:i:s', strtotime($pgr->updated_at)) }}</td>
                                    <td>
                                        @if (auth()->user()->role == 3)
                                            @if (!in_array($pgr->status_persetujuan, [1, 2]))
                                            <a href="{{ route('pengeluaran-grosir.edit', $pgr->id_persetujuan_pengeluaran_grosir) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <form
                                                action="{{ route('pengeluaran-grosir.hapus', $pgr->id_persetujuan_pengeluaran_grosir) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                                            </form>
                                            @else
                                            @switch($pgr->status_persetujuan)
                                                    @case(1)
                                                        <span class="badge bg-success">Disetujui</span>
                                                        @break
                                                    @case(2)
                                                        <span class="badge bg-danger">Ditolak</span>
                                                        @break
                                                @endswitch
                                            @endif
                                            
                                        @elseif (auth()->user()->role == 1)
                                            @if (!in_array($pgr->status_persetujuan, [1, 2]))
                                                <form
                                                    action="{{ route('pengeluaran-grosir.approve', $pgr->id_persetujuan_pengeluaran_grosir) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit"
                                                        class="btn btn-success btn-sm btn-approve">Setujui</button>
                                                </form>
                                                <a href="#" class="btn btn-info btn-sm btn-note"
                                                    data-id="{{ $pgr->id_persetujuan_pengeluaran_grosir }}"
                                                    data-catatan="{{ $pgr->catatan_pemimpin }}">Beri Catatan</a>
                                                <form
                                                    action="{{ route('pengeluaran-grosir.reject', $pgr->id_persetujuan_pengeluaran_grosir) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-danger btn-sm btn-tolak">Tolak</button>
                                                </form>
                                            @else
                                                @switch($pgr->status_persetujuan)
                                                    @case(1)
                                                        <span class="badge bg-success">Disetujui</span>
                                                        @break
                                                    @case(2)
                                                        <span class="badge bg-danger">Ditolak</span>
                                                        @break
                                                @endswitch
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

    @if (auth()->user()->role == 1)
        <div class="modal fade" id="catatanModal" tabindex="-1" aria-labelledby="catatanModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="catatanForm" method="POST" action="{{ route('pengeluaran-grosir.catatan') }}">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id_pengeluaran_grosir" id="modal_id_pengeluara_grosir">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="catatanModalLabel">Beri Catatan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <textarea name="catatan_pemimpin" id="catatan_pemimpin" class="form-control" rows="4"
                                required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif


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

                $('.dokumen-img').on('click', function () {
                    var imgSrc = $(this).attr('src');
                    var popup = `
                            <div id="img-popup-overlay" style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.7);z-index:9999;display:flex;align-items:center;justify-content:center;">
                                <img src="`+ imgSrc + `" style="max-width:90vw;max-height:90vh;border:8px solid #fff;border-radius:8px;">
                            </div>
                        `;
                    $('body').append(popup);
                });

                // Tutup popup jika overlay diklik
                $(document).on('click', '#img-popup-overlay', function () {
                    $(this).remove();
                });

                $('.btn-note').on('click', function (e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    var catatan = $(this).data('catatan') || '';
                    $('#modal_id_pengeluara_grosir').val(id);
                    $('#catatan_pemimpin').val(catatan);
                    $('#catatanModal').modal('show');
                });
            });
        </script>
    @endsection

</x-dashboard>