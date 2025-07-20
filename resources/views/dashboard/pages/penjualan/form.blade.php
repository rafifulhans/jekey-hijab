<x-dashboard>

    <div class="card px-4 py-3 d-flex flex-row align-items-center gap-3">
        <a href="{{ route('penjualan') }}">
            <i class="ti ti-arrow-left fs-6 fw-bolder"></i>
        </a>
        <div>Back</div>
    </div>

    <x-form title="{{ $page_meta['title'] }}" action="{{ $page_meta['action'] }}" type="{{ $page_meta['type'] }}">
        @method($page_meta['method'])
        <div class="mb-3">
            <label for="marketplace" class="form-label">Marketplace</label>
            <select name="marketplace" id="marketplace" class="form-select">
                <option disabled selected>Pilih Marketplace</option>
                @foreach($marketplaces as $marketplace)
                    <option value="{{ $marketplace->id_marketplace }}" {{ (old('marketplace') ?? $penjualan->id_marketplace) == $marketplace->id_marketplace ? 'selected' : '' }}>{{ $marketplace->nama }}</option>
                @endforeach
            </select>
            @error('marketplace')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6 mb-3">
                <label for="no_resi" class="form-label">No. Resi</label>
                <input type="text" class="form-control" id="no_resi" name="no_resi" value="{{ old('no_resi') ?? $penjualan->nomor_resi }}">
                @error('no_resi')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6 col-lg-6 mb-3">
                <label for="ekspedisi" class="form-label">Ekspedisi</label>
                <select name="ekspedisi" id="ekspedisi" class="form-select">
                    <option disabled selected>Pilih Ekspedisi</option>
                    @foreach($ekspedisis as $ekspedisi)
                        <option value="{{ $ekspedisi->id_ekspedisi }}" {{ (old('ekspedisi') ?? $penjualan->id_ekspedisi) == $ekspedisi->id_ekspedisi ? 'selected' : '' }}>{{ $ekspedisi->nama }}</option>
                    @endforeach
                </select>
                @error('ekspedisi')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-5 col-lg-5 mb-3">
                <label for="produk" class="form-label">Nama Produk</label>
                <select name="produk" id="produk" class="form-select">
                    <option disabled selected>Pilih Produk</option>
                    @foreach($produks as $produk)
                        <option value="{{ $produk->id_produk }}" {{ (old('produk') ?? $penjualan->id_produk) == $produk->id_produk ? 'selected' : '' }}>{{ $produk->nama }}</option>
                    @endforeach
                </select>
                @error('produk')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-5 col-lg-5 mb-3">
                <label for="varian" class="form-label">Varian</label>
                <input type="text" class="form-control" id="varian" name="varian" value="{{ old('varian') ?? $penjualan->nama_varian }}">
                @error('varian')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-2 col-lg-2 mb-3">
                <label for="qty" class="form-label">QTY</label>
                <input type="number" class="form-control" id="qty" name="qty" value="{{ old('qty') ?? $penjualan->qty }}">
                @error('qty')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-3 mb-3">
                <label for="subtotal" class="form-label">Subtotal</label>
                <input type="number" class="form-control" id="subtotal" name="subtotal" value="{{ old('subtotal') ?? $penjualan->subtotal }}">
                @error('subtotal')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-3">
                <label for="diskon" class="form-label">Diskon</label>
                <input type="number" class="form-control" id="diskon" name="diskon" value="{{ old('diskon') ?? $penjualan->diskon }}">
                @error('diskon')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-3">
                <label for="ongkir" class="form-label">Ongkir</label>
                <input type="number" class="form-control" id="ongkir" name="ongkir" value="{{ old('ongkir') ?? $penjualan->ongkir }}">
                @error('ongkir')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-3">
                <label for="total" class="form-label">Total</label>
                <input type="number" class="form-control" id="total" name="total" value="{{ old('total') ?? $penjualan->total }}">
                @error('total')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6 mb-3">
                <label for="email_pembeli" class="form-label">Email Pembeli</label>
                <input type="email" class="form-control" id="email_pembeli" name="email_pembeli" value="{{ old('email_pembeli') ?? $penjualan->email_pembeli }}">
                @error('email_pembeli')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6 col-lg-6 mb-3">
                <label for="no_telp_pembeli" class="form-label">No. Telp Pembeli</label>
                <input type="number" class="form-control" id="no_telp_pembeli" name="no_telp_pembeli" value="{{ old('no_telp_pembeli') ?? $penjualan->nomor_telepon_pembeli }}">
                @error('no_telp_pembeli')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6 mb-3">
            <label for="alamat_pembeli" class="form-label">Alamat Pembeli</label>
            <textarea name="alamat_pembeli" id="alamat_pembeli" class="form-control">{{ old('alamat_pembeli') ?? $penjualan->alamat_pembeli }}</textarea>
            @error('alamat_pembeli')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-3 mb-3">
                <label for="status_order" class="form-label">Status Order</label>
                <select name="status_order" id="status_order" class="form-select">
                    <option disabled selected>Pilih Status Order</option>
                    @foreach(config('status.order') as $key => $value)
                        <option value="{{ $key }}" {{ (old('status_order') ?? $penjualan->status_order) == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                @error('status_order')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-3">
                <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                <select name="status_pembayaran" id="status_pembayaran" class="form-select">
                    <option disabled selected>Pilih Status Pembayaran</option>
                    @foreach(config('status.pembayaran') as $key => $value)
                        <option value="{{ $key }}" {{ (old('status_pembayaran') ?? $penjualan->status_pembayaran) == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                @error('status_pembayaran')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select name="metode_pembayaran" id="metode_pembayaran" class="form-select">
                    <option disabled selected>Pilih Metode Pembayaran</option>
                    @foreach($metodes as $metode)
                        <option value="{{ $metode->id_metode_pembayaran }}" {{ (old('metode_pembayaran') ?? $penjualan->id_metode_pembayaran) == $metode->id_metode_pembayaran ? 'selected' : '' }}>{{ $metode->nama }}</option>
                    @endforeach
                </select>
                @error('metode_pembayaran')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-3">
                <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
                <input type="date" class="form-control" id="tanggal_pembayaran" name="tanggal_pembayaran" value="{{ old('tanggal_pembayaran') ?? $penjualan->tanggal_pembayaran }}">
                @error('tanggal_pembayaran')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </x-form>

</x-dashboard>