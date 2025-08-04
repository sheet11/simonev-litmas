@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Lapor Capaian Luaran: {{ $litmas->judul }}</h3>
    <form method="POST" action="{{ route('litmas.updateLuaran', $litmas->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Upload Dokumen Publikasi (PDF, JPG, PNG, max 2MB):</label>
            <input type="file" name="luaran_file" class="form-control">
            @if($litmas->luaran_file)
                <p class="mt-2">File sebelumnya: <a href="{{ asset('storage/' . $litmas->luaran_file) }}" target="_blank">Lihat File</a></p>
            @endif
        </div>
        <div class="mb-3">
            <label>Link Publikasi (URL)</label>
            <input type="text" name="luaran_link" class="form-control" value="{{ $litmas->luaran_link }}">
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('litmas.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
