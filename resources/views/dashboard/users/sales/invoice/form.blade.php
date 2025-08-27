<x-dashboard>

    <div class="card px-4 py-3 d-flex flex-row align-items-center gap-3">
        <a href="{{ route('invoice') }}">
            <i class="ti ti-arrow-left fs-6 fw-bolder"></i>
        </a>
        <div>Back</div>
    </div>

    <div class="col-12 col-md-12 col-lg-10">
        <x-form title="{{ $page_meta['title'] }}" action="{{ $page_meta['action'] }}" type="{{ $page_meta['type'] }}">
            @method($page_meta['method'])
            <div class="col-12 col-md-6 col-lg-12 mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal"
                    value="{{ old('tanggal') ?? $invoice->tanggal }}">
                @error('tanggal')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6 col-lg-12 mb-3">
                <label for="nama_customer" class="form-label">Nama Customer</label>
                <input type="text" class="form-control" id="nama_customer" name="nama_customer"
                    value="{{ old('nama_customer') ?? $invoice->nama_customer }}">
                @error('nama_customer')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6 col-lg-12 mb-3">
                <label for="alamat_customer" class="form-label">Alamat Customer</label>
                <textarea name="alamat_customer" id="alamat_customer" class="form-control">{{ old('alamat_customer') ?? $invoice->alamat_customer }}</textarea>
                @error('alamat_customer')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6 col-lg-12 mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select name="metode_pembayaran" id="metode_pembayaran" class="form-select">
                    <option disabled selected>Pilih Metode Pembayaran</option>
                    @foreach ($metodes as $metode)
                        <option value="{{ $metode->id_metode_pembayaran }}" {{ old('metode_pembayaran') == $metode->id_metode_pembayaran ? 'selected' : '' }}>{{ $metode->nama }}</option>
                    @endforeach
                </select>
                @error('metode_pembayaran')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6 col-lg-12">
                <label for="barang" class="form-label">Rincian Barang</label>
                <div class="rincian_barang">
                    <div class="rincian_barang_list">
                        @php
                            $rincian_barang = old('nama_barang', $invoice->nama_barang ?? [0]);
                        @endphp
                        @foreach ($rincian_barang as $index => $barang)
                        <div class="group_barang row mb-2">
                            <div class="col-12 col-md-4 col-lg-4">
                                <select name="nama_barang[]" class="form-select rincian_nama_barang_input">
                                    <option disabled {{ old("nama_barang.$index") == null && empty($invoice->nama_barang[$index]) ? 'selected' : '' }}>Pilih Barang</option>
                                    @foreach ($produks as $item)
                                        <option value="{{ $item->id_produk }}"
                                            {{ (old("nama_barang.$index") ?? ($invoice->nama_barang[$index] ?? null)) == $item->id_produk ? 'selected' : '' }}>
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error("nama_barang.$index")
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <input type="number" class="form-control rincian_qty_barang_input" name="qty[]" value="{{ old("qty.$index") ?? $invoice->qty[0] ?? '' }}" placeholder="QTY">
                                @error("qty.$index")
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <input type="number" class="form-control rincian_harga_barang_input" name="harga[]" value="{{ old("harga.$index") ?? $invoice->harga[0] ?? '' }}" placeholder="Harga">
                                @error("harga.$index")
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button id="add_rincian_barang" class="btn btn-success mt-3">
                        <i class="ti ti-plus fw-bolder fs-3"></i>
                    </button>
                </div>
            </div>
        </x-form>
    </div>

    @section('scripts')

    <script type="text/javascript">

        $(document).ready(function() {
            $('#add_rincian_barang').click(function(e) {
                e.preventDefault();
                $('.rincian_barang_list').append(`
                    <div class="group_barang row mt-2">
                        <div class="col-12 col-md-4 col-lg-4">
                            <select name="nama_barang[]" class="form-select rincian_nama_barang_input">
                                <option disabled selected>Pilih Barang</option>
                                @foreach ($produks as $item)
                                    <option value="{{ $item->id_produk }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <input type="number" class="form-control rincian_qty_barang_input" name="qty[]" placeholder="QTY">
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <input type="number" class="form-control rincian_harga_barang_input" name="harga[]" placeholder="Harga">
                        </div>
                    </div>
                `);
            });
        });

    </script>
    
    @endsection

</x-dashboard>