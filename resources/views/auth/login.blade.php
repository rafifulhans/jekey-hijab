<x-auth>
    <a href="{{ route('home') }}" class="text-nowrap logo-img text-center d-block py-3 w-100">
        <img src="{{ Vite::asset('resources/assets/images/jekey-hijab.jpg') }}" alt="" width="150">
    </a>
    {{ auth()->user() }}
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
            @error('username')
                <div class="alert alert-danger" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            @error('password')
                <div class="alert alert-danger" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <!-- <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                <label class="form-check-label text-dark" for="flexCheckChecked">
                    Remeber this Device
                </label>
            </div>
            <a class="text-primary fw-bold" href="./index.html">Forgot Password ?</a>
        </div> -->
        <button class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Log-In</button>
        <!-- <div class="d-flex align-items-center justify-content-center">
            <p class="fs-4 mb-0 fw-bold">New to MaterialM?</p>
            <a class="text-primary fw-bold ms-2" href="./authentication-register.html">Create an account</a>
        </div> -->
    </form>
</x-auth>