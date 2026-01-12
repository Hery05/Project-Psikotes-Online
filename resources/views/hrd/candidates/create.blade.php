@extends('layouts.hrd')

@section('title', 'Tambah Kandidat')

@section('content')
<div class="container-fluid">

    <div class="mb-3">
        <h4>
            <i class="fas fa-user-plus"></i> Tambah Kandidat
        </h4>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('hrd.candidates.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Kandidat</label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           required>

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           required>

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required>

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('hrd.candidates.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button class="btn btn-primary">
                        Simpan Kandidat
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
