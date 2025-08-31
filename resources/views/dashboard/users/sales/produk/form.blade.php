<x-dashboard>
    @include('sweetalert::alert')

    <div class="card px-4 py-3 d-flex flex-row align-items-center gap-3">
        <a href="{{ route('produk') }}">
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
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="{{ old('nama') ?? $produk->nama }}">
                                @error('nama')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="text" class="form-control" id="harga" name="harga"
                                    value="{{ old('harga') ?? $produk->harga }}">
                                @error('harga')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" id="deskripsi" cols="30"
                                    rows="5">{{ old('deskripsi') ?? $produk->deskripsi }}</textarea>
                                @error('deskripsi')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                @if (!empty($produk->image))
                                    <div class="img-preview">
                                        <img src="{{ asset('uploads/produk/' . $produk->image) }}" alt="image" width="100"
                                            height="100">
                                    </div>
                                @endif
                                <input type="file" class="form-control" id="gambar" name="gambar"
                                    accept=".jpg, .jpeg, .png">
                                @error('gambar')
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