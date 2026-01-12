@extends('layouts.hrd')

@section('title','Tambah Kategori')

@section('content')

<h4 class="mb-3 font-weight-bold">
    Tambah Kategori Tes
</h4>

<form method="POST" action="{{ route('hrd.categories.store') }}">
@csrf

<div class="form-group">
    <label>Nama Kategori</label>
    <input type="text" name="name"
           class="form-control"
           required>
</div>

<div class="form-group">
    <label>Durasi (menit)</label>
    <input type="number" name="duration"
           class="form-control"
           required>
</div>

<div class="form-group">
    <label>Nilai Kelulusan</label>
    <input type="number" name="passing_score"
           class="form-control"
           value="70"
           required>
</div>

<div class="form-group">
    <label>Bobot Nilai (%)</label>
    <input type="number" name="weight"
           class="form-control"
           placeholder="Contoh: 30"
           required>
</div>

<button class="btn btn-primary">
    Simpan Kategori
</button>

</form>
@endsection
