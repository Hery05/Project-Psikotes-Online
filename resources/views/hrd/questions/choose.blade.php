@extends('layouts.hrd')

@section('title','Pilih Tipe Soal')

@section('content')

<div class="container">

    <div class="text-center mb-5">
        <h4 class="font-weight-bold">
            <i class="fas fa-layer-group text-primary mr-2"></i>
            Pilih Tipe Soal
        </h4>
        <p class="text-muted">
            Kategori: <strong>{{ $category->name }}</strong>
        </p>
    </div>

    <div class="row justify-content-center">

        {{-- PILIHAN GANDA --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body">
                    <i class="fas fa-list-ol fa-3x text-primary mb-3"></i>
                    <h5 class="font-weight-bold">Pilihan Ganda</h5>
                    <p class="text-muted small">
                        Soal dengan opsi A sampai E
                    </p>
                    <a href="{{ route('hrd.questions.createChoice',$category) }}"
                       class="btn btn-primary btn-sm">
                        Pilih
                    </a>
                </div>
            </div>
        </div>

        {{-- URAIAN --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body">
                    <i class="fas fa-pen fa-3x text-warning mb-3"></i>
                    <h5 class="font-weight-bold">Uraian</h5>
                    <p class="text-muted small">
                        Jawaban berbentuk teks bebas
                    </p>
                    <a href="{{ route('hrd.questions.createEssay',$category) }}"
                       class="btn btn-warning btn-sm">
                        Pilih
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-4 text-center">
        <a href="{{ route('hrd.questions.index',$category) }}"
           class="btn btn-light btn-sm">
            ← Kembali
        </a>
    </div>

</div>

@endsection
