<x-dashboard>

    <div class="card px-4 py-3 d-flex flex-row align-items-center gap-3">
        <a href="{{ route('piutang') }}">
            <i class="ti ti-arrow-left fs-6 fw-bolder"></i>
        </a>
        <div>Back</div>
    </div>

    <div class="col-12 col-md-6 col-lg-6">
        <x-form title="{{ $page_meta['title'] }}" action="{{ $page_meta['action'] }}" type="{{ $page_meta['type'] }}">
            @method($page_meta['method'])
            <div class="mb-3">
                <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value="{{ old('nama_pelanggan') ?? $piutang->nama_pelanggan }}">
                @error('nama_pelanggan')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal') ?? $piutang->tanggal }}" {{ $piutang->id_jurnal_transaksi  ? 'disabled' : '' }}>
                @error('tanggal')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jatuh_tempo" class="form-label">Jatuh Tempo</label>
                <input type="date" class="form-control" id="jatuh_tempo" name="jatuh_tempo" value="{{ old('jatuh_tempo') ?? $piutang->jatuh_tempo }}" {{ $piutang->id_jurnal_transaksi  ? 'disabled' : '' }}>
                @error('jatuh_tempo')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah') ?? $piutang->jumlah }}">
                @error('jumlah')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status Pembayaran</label>
                <select class="form-control" id="status" name="status">
                    <option value="0" {{ $piutang->status == 0 ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="1" {{ $piutang->status == 1 ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>
        </x-form>
    </div>

</x-dashboard>