<x-dashboard>

@include('sweetalert::alert')

    <div class="d-flex justify-content-end align-items-center mb-3">
        <a href="{{ route('invoice.tambah') }}" class="btn btn-primary m-1">Tambah</a>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">INVOICE</h4>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                        <thead>
                            <tr>
                                <th scope="col" class="text-start">No</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Nama Customer</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Total Barang</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">Diskon</th>
                                <th scope="col">Total</th>
                                <th scope="col" class="text-end">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td class="text-center">
                                        <h6 class="mb-0">{{ $invoice->invoice }}</h6>
                                    </td>
                                    <td>{{ date('d-m-Y', strtotime($invoice->tanggal)) }}</td>
                                    <td>{{ $invoice->nama_customer }}</td>
                                    <td>{{ $invoice->alamat_customer }}</td>
                                    <td>{{ $invoice->total_barang }}</td>
                                    <td>{{ Number::currency($invoice->subtotal, 'IDR', 'id_ID') }}</td>
                                    <td>{{ $invoice->metode_pembayaran }}</td>
                                    <td>{{ Number::currency($invoice->total, 'IDR', 'id_ID') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('invoice.detail', $invoice->id_invoice) }}" class="btn btn-secondary">
                                            <i class="ti ti-eye fs-5"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-dashboard>