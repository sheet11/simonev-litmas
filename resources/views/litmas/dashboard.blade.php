@extends('layouts.app')

@section('content')
<div class="container">
    @include('litmas._nav') <!-- INI BARIS MENU UTAMA -->

    <h3>Dashboard Statistik Litmas</h3>
    <div class="row">
        <div class="col-md-6 mb-4">
            <canvas id="statusChart"></canvas>
        </div>
        <div class="col-md-6 mb-4">
            <canvas id="prodiChart"></canvas>
        </div>
        <div class="col-md-12 mb-4">
            <canvas id="tahunChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const rekapStatus = @json($rekapStatus);
const rekapProdi = @json($rekapProdi);
const rekapTahun = @json($rekapTahun);

new Chart(document.getElementById('statusChart'), {
    type: 'pie',
    data: {
        labels: Object.keys(rekapStatus),
        datasets: [{
            data: Object.values(rekapStatus),
            backgroundColor: ['#3cba54', '#f4c242', '#db3236', '#007bff', '#6c757d'],
        }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});

new Chart(document.getElementById('prodiChart'), {
    type: 'bar',
    data: {
        labels: Object.keys(rekapProdi),
        datasets: [{
            label: 'Jumlah Litmas',
            data: Object.values(rekapProdi),
            backgroundColor: '#007bff',
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
});

new Chart(document.getElementById('tahunChart'), {
    type: 'line',
    data: {
        labels: Object.keys(rekapTahun),
        datasets: [{
            label: 'Litmas per Tahun',
            data: Object.values(rekapTahun),
            backgroundColor: 'rgba(60,186,84,0.2)',
            borderColor: '#3cba54',
            fill: true,
        }]
    },
    options: { responsive: true }
});
</script>
@endsection
