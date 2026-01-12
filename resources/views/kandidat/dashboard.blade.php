@extends('layouts.kandidat')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body text-center">

            <h5 class="mb-3">Siap Memulai Tes?</h5>
            <p class="text-muted">
                Tes hanya bisa dikerjakan satu kali. Waktu akan berjalan setelah tombol ditekan.
            </p>
            <a href="{{ route('candidate.test.start', $category->id) }}" class="btn btn-primary btn-lg px-5">
                Mulai Tes
            </a>

        </div>
    @endsection
