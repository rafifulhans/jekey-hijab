<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">{{ $title }}</h5>
        <div class="card">
            <div class="card-body">
                <form action="{{ $action }}" method="POST">
                    @csrf
                    {{ $slot }}

                    @if ($type === 'create') 
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