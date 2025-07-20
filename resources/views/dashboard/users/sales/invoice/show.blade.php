<x-dashboard>
    <div class="card px-4 py-3 d-flex flex-row align-items-center gap-3">
        <a href="{{ route('invoice') }}">
            <i class="ti ti-arrow-left fs-6 fw-bolder"></i>
        </a>
        <div>Back</div>
    </div>
    <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-body d-flex flex-column gap-2">
                <h2 class="card-title fw-bolder fs-5 mb-0">INVOICE</h2>
                <hr>
                <h5 class="d-flex justify-content-between fs-4">
                    <span>No:</span>
                    <span class="text-muted">{{ $invoice->invoice }}</span>
                </h5>
                <h5 class="d-flex justify-content-between fs-4">
                    <span>Tanggal:</span>
                    <span class="text-muted">{{ $invoice->tanggal }}</span>
                </h5>
                <h5 class="d-flex flex-column fs-4">
                    <span>Kepada:</span>
                </h5>
                <p class="text-muted mb-0 fs-4">{{ $invoice->nama_customer }}</p>
                <p class="text-muted mb-0 fs-4">{{ $invoice->alamat_customer }}</p>
                <hr>
                <h5 class="fs-4">
                    <span class="mb-2">Rincian</span>
                </h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>QTY</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice_barang as $ivb)
                            <tr>
                                <td>{{ $ivb->nama_barang }}</td>
                                <td>{{ $ivb->qty }}</td>
                                <td>{{ $ivb->harga }}</td>
                                <td>{{ $ivb->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-7">
                    <h5 class="row fs-4">
                        <span class="col-4">Subtotal:</span>
                        <span class="col-8 text-muted">{{ Number::currency($invoice->subtotal, 'IDR', 'id_ID') }}</span>
                    </h5>
                    <h5 class="row fs-4">
                        <span class="col-4">Total:</span>
                        <span class="col-8 text-muted">{{ Number::currency($invoice->total, 'IDR', 'id_ID') }}</span>
                    </h5>
                </div>
                <hr>
                <div class="col-7">
                    <h5 class="d-flex fs-4 flex-column gap-2">
                        <span class="col-4">Pembayaran:</span>
                        <span class="col-8 text-muted">{{ $invoice->metode_pembayaran }}</span>
                    </h5>
                </div>
            </div>
        </div>
    </div>

</x-dashboard>