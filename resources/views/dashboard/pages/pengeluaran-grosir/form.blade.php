<x-dashboard>

    <div class="card px-4 py-3 d-flex flex-row align-items-center gap-3">
        <a href="{{ route('pengeluaran-grosir') }}">
            <i class="ti ti-arrow-left fs-6 fw-bolder"></i>
        </a>
        <div>Back</div>
    </div>

    <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">{{ $page_meta['title'] }}</h5>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ $page_meta['action'] }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method($page_meta['method'])
                            <div class="mb-3">
                                <label for="nominal" class="form-label">Nominal</label>
                                <input type="number" class="form-control" id="nominal" name="nominal"
                                    value="{{ old('nominal') ?? $pengeluaran_grosir->nominal }}">
                                @error('nominal')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tujuan" class="form-label">Tujuan Pengeluaran</label>
                                <textarea name="tujuan" class="form-control"
                                    id="tujuan">{{ old('tujuan') ?? $pengeluaran_grosir->tujuan }}</textarea>
                                @error('tujuan')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="dokumen" class="form-label">Dokumen Pendukung</label>
                                @if (!empty($pengeluaran_grosir->dokumen))
                                    <div class="img-preview">
                                        <img src="{{ asset('uploads/'.$pengeluaran_grosir->dokumen) }}" alt="dokumen" width="100" height="100">
                                    </div>
                                @endif
                                <input type="file" class="form-control" id="dokumen" name="dokumen" accept="image/png, image/jpeg">
                                @error('dokumen')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="sumber_dana" class="form-label">Sumber Dana</label>
                                <input type="text" class="form-control" id="sumber_dana" name="sumber_dana"
                                    value="{{ old('sumber_dana') ?? $pengeluaran_grosir->sumber_dana }}">
                                @error('sumber_dana')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            @if ($page_meta['type'] === 'create')
                                <hr>
                                <button type="submit" class="btn btn-primary float-end">Tambah</button>
                            @else
                                <button type="submit" class="btn btn-warning">Simpan</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-dashboard>