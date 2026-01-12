@extends('layouts.hrd')

@section('title','Edit Kategori')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header bg-white">
        <h5 class="mb-0 font-weight-bold">
            <i class="fas fa-edit text-warning mr-2"></i>
            Edit Kategori Soal
        </h5>
    </div>

    <form method="POST"
          action="{{ route('hrd.categories.update',$category->id) }}">
        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="name"
                       class="form-control"
                       value="{{ $category->name }}" required>
            </div>

            <div class="form-group">
                <label>Durasi (menit)</label>
                <input type="number" name="duration"
                       class="form-control"
                       value="{{ $category->duration }}" required>
            </div>

            <div class="form-group">
                <label>Nilai Kelulusan</label>
                <input type="number" name="passing_score"
                       class="form-control"
                       value="{{ $category->passing_score }}" required>
            </div>

            <div class="form-group">
                <label>Bobot Kategori (%)</label>
                <input type="number" name="weight"
                       class="form-control"
                       value="{{ $category->weight }}" required>
            </div>

        </div>

        <div class="card-footer bg-white d-flex justify-content-between">
            <a href="{{ route('hrd.categories.index') }}" class="btn btn-light">
                ← Kembali
            </a>
            <button class="btn btn-warning">
                <i class="fas fa-save mr-1"></i> Update
            </button>
        </div>
    </form>
</div>

@endsection
