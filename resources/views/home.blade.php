@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Tombol Navigasi Utama -->
            <div class="mb-3">
                <a href="{{ url('/litmas') }}" class="btn btn-outline-primary me-2">
                    Daftar Litmas
                </a>
                <a href="{{ route('litmas.monitoring') }}" class="btn btn-outline-secondary me-2">
                    Monitoring Litmas
                </a>
                <a href="{{ route('litmas.dashboard') }}" class="btn btn-outline-info">
                    Dashboard Grafik Litmas
                </a>
            </div>

            <div class="card mb-4">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <h5>Selamat datang, {{ $user->name }}!</h5>
                    <p>Role Anda: <strong>{{ strtoupper($user->role) }}</strong></p>
                </div>
            </div>

            @if ($user->role === 'ppm')
                <div class="alert alert-info">Anda adalah <strong>Pusat PPM</strong>. Berikut fitur yang bisa diakses:</div>
                <ul>
                    <li>Input Data Litmas</li>
                    <li>Verifikasi Luaran</li>
                    <li>Monitoring Semua Prodi</li>
                    <li>Export Data</li>
                </ul>
            @elseif ($user->role === 'kaprodi')
                <div class="alert alert-success">Anda adalah <strong>Kaprodi</strong>. Berikut fitur yang bisa diakses:</div>
                <ul>
                    <li>Monitoring Luaran Prodi</li>
                    <li>Unduh Laporan</li>
                    <li>View Only</li>
                </ul>
            @elseif ($user->role === 'ketua_pelaksana')
                <div class="alert alert-warning">Anda adalah <strong>Ketua Pelaksana Litmas</strong>. Berikut fitur yang bisa diakses:</div>
                <ul>
                    <li>Input Capaian Luaran</li>
                    <li>Riwayat Luaran</li>
                    <li>Lihat Status Verifikasi</li>
                </ul>
            @else
                <div class="alert alert-danger">Role Anda belum diatur.</div>
            @endif

        </div>
    </div>
</div>
@endsection
