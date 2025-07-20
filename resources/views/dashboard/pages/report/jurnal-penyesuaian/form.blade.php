<x-dashboard>

    <div class="card px-4 py-3 d-flex flex-row align-items-center gap-3">
        <a href="{{ route('jurnal-transaksi') }}">
            <i class="ti ti-arrow-left fs-6 fw-bolder"></i>
        </a>
        <div>Back</div>
    </div>

    <div class="col-12 col-md-6 col-lg-6">
        <x-form title="{{ $page_meta['title'] }}" action="{{ $page_meta['action'] }}" type="{{ $page_meta['type'] }}">
            @method($page_meta['method'])
            <div class="mb-3">
                <label for="ref" class="form-label">Akun</label>
                <select name="ref" id="ref" class="form-select" {{ $jurnal_penyesuaian->id_jurnal_penyesuaian ? 'disabled' : '' }}>
                    <option disabled selected>Pilih Akun</option>
                    @foreach($refs as $rf)
                        <option value="{{ $rf->id_ref }}" {{ (old('ref') ?? $jurnal_penyesuaian->id_ref) == $rf->id_ref ? 'selected' : '' }}>
                            {{ $rf->nama_akun . ' (' . $rf->kode . ')' }}
                        </option>
                    @endforeach
                </select>
                @error('ref')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="form-control">{{ old('keterangan') ?? $jurnal_penyesuaian->keterangan }}</textarea>
                @error('keterangan')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal') ?? $jurnal_penyesuaian->tanggal }}" {{ $jurnal_penyesuaian->id_jurnal_penyesuaian ? 'disabled' : '' }}>
                @error('tanggal')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="total" class="form-label">Total</label>
                <input type="number" class="form-control" id="total" name="total" value="{{ old('total') ?? $jurnal_penyesuaian->total }}">
                @error('total')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label mb-2">Kategori Laporan</label>
                <div class="d-flex gap-3">
                    <div class="form-group">
                        <input type="radio" name="type" id="debet" value="1" class="form-radio" {{ (old('type') ?? $jurnal_penyesuaian->type) == 1 ? 'checked' : '' }} {{ $jurnal_penyesuaian->id_jurnal_penyesuaian ? 'disabled' : '' }}>
                        <label for="debet">Debet</label>
                    </div>
                    <div class="form-group">
                        <input type="radio" name="type" id="kredit" value="2" {{ (old('type') ?? $jurnal_penyesuaian->type) == 2 ? 'checked' : '' }} {{ $jurnal_penyesuaian->id_jurnal_penyesuaian ? 'disabled' : '' }}>
                        <label for="kredit">Kredit</label>
                    </div>
                </div>
                @error('type')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </x-form>
    </div>

</x-dashboard>