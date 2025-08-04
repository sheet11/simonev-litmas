@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Data Litmas</h3>
    <form method="POST" action="{{ route('litmas.store') }}">
        @csrf
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tahun</label>
            <input type="number" name="tahun" class="form-control" min="2000" max="2100" required>
        </div>
        <div class="mb-3">
            <label>Ketua</label>
            <input type="text" name="ketua" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Prodi</label>
            <input type="text" name="prodi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Luaran Wajib</label>
            <textarea name="luaran_wajib" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Luaran Tambahan</label>
            <textarea name="luaran_tambahan" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('litmas.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
