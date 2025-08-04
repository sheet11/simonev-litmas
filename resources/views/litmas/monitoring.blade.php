@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Monitoring & Rekap Data Litmas</h3>

    <form method="GET" action="{{ route('litmas.monitoring') }}" class="mb-3 row g-2 align-items-end">
        <div class="col-md-2">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">Semua</option>
                @foreach($statuses as $opt)
                    <option value="{{ $opt }}" {{ ($status ?? '') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label>Prodi</label>
            <select name="prodi" class="form-control">
                <option value="">Semua</option>
                @foreach($prodis as $opt)
                    <option value="{{ $opt }}" {{ ($prodi ?? '') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label>Tahun</label>
            <select name="tahun" class="form-control">
                <option value="">Semua</option>
                @foreach($tahuns as $opt)
                    <option value="{{ $opt }}" {{ ($tahun ?? '') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-success">Filter</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Tahun</th>
                <th>Ketua</th>
                <th>Prodi</th>
                <th>Status</th>
                <th>Link/File Capaian</th>
                @if(auth()->user()->role === 'ppm')
                    <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($litmas as $item)
            <tr>
                <td>{{ $item->judul }}</td>
                <td>{{ $item->tahun }}</td>
                <td>{{ $item->ketua }}</td>
                <td>{{ $item->prodi }}</td>
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
                    @if($item->luaran_file)
                        <a href="{{ asset('storage/'.$item->luaran_file) }}" target="_blank">[File]</a>
                    @endif
                    @if($item->luaran_link)
                        <a href="{{ $item->luaran_link }}" target="_blank">[Link]</a>
                    @endif
                </td>
                @if(auth()->user()->role === 'ppm')
                <td>
                    @if($item->status !== 'Tercapai')
                        <form action="{{ route('litmas.verifikasi', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button name="action" value="Tercapai" class="btn btn-success btn-sm" onclick="return confirm('Setujui capaian ini?')">Setujui</button>
                            <button name="action" value="Revisi" class="btn btn-warning btn-sm" onclick="return confirm('Minta revisi?')">Revisi</button>
                            <button name="action" value="Ditolak" class="btn btn-danger btn-sm" onclick="return confirm('Tolak capaian ini?')">Tolak</button>
                        </form>
                    @else
                        <span class="text-success">Sudah Disetujui</span>
                    @endif
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
