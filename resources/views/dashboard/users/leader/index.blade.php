<x-dashboard>

    <div class="row">
        <div class="col-lg-4">
            <div class="card w-100">
                <div class="card-body">
                    <h4 class="card-title">Total Penjualan</h4>
                    <div class="text-bg-primary p-2 mt-4 fs-6 rounded fw-bold text-center">
                        <span>{{ $total_penjualan }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card w-100">
                <div class="card-body">
                    <h4 class="card-title">Total Revenue</h4>
                    <div class="text-bg-primary p-2 mt-4 fs-6 rounded fw-bold text-center">
                        <span>{{ $total_revenue }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-dashboard>