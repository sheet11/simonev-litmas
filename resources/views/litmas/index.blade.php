@extends('layouts.app')
@section('content')
<div class="container">
    @include('litmas._nav')
    <!-- ...lanjutan tabel daftar litmas... -->

    <h3>Daftar Data Litmas</h3>
    {{-- Tabel, tombol tambah, dll --}}
    <a href="{{ route('litmas.create') }}" class="btn btn-primary mb-3">Tambah Data Litmas</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Tahun</th>
                <th>Ketua</th>
                <th>Prodi</th>
                <th>Luaran Wajib</th>
                <th>Luaran Tambahan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($litmas as $item)
            <tr>
                <td>{{ $item->judul }}</td>
                <td>{{ $item->tahun }}</td>
                <td>{{ $item->ketua }}</td>
                <td>{{ $item->prodi }}</td>
                <td>{{ $item->luaran_wajib }}</td>
                <td>{{ $item->luaran_tambahan }}</td>
                <td>
                    @if($item->status === 'Tercapai')
                        <span class="badge bg-success">{{ $item->status }}</span>
                    @elseif($item->status === 'Revisi')
                        <span class="badge bg-warning text-dark">{{ $item->status }}</span>
                    @elseif($item->status === 'Ditolak')
                        <span class="badge bg-danger">{{ $item->status }}</span>
                    @else
                        <span class="badge bg-secondary">{{ $item->status }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('litmas.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('litmas.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus data ini?')" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Belum ada data Litmas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
