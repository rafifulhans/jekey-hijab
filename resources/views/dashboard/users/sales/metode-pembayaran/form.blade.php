<x-dashboard>
    @include('sweetalert::alert')
    
    <div class="card px-4 py-3 d-flex flex-row align-items-center gap-3">
        <a href="{{ route('metode-pembayaran') }}">
            <i class="ti ti-arrow-left fs-6 fw-bolder"></i>
        </a>
        <div>Back</div>
    </div>

    <div class="col-12 col-md-6 col-lg-6">
        <x-form title="{{ $page_meta['title'] }}" action="{{ $page_meta['action'] }}" type="{{ $page_meta['type'] }}">
            @method($page_meta['method'])
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') ?? $metode->nama }}">
                @error('nama')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </x-form>
    </div>

</x-dashboard>