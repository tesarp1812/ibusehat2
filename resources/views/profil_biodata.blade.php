@extends('layout.app')
@section('content')
    <div class="card-footer text-muted">
        <a href="/biodata" class="btn btn-primary">Kembali</a>
    </div>
    <div class="card text-center">
        <div class="card-header bg-info">
            Biodata Pasien
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-sm-6 ">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-header bg-info">Pasien</h5>
                            <div class="card-body">
                                <h5 class="card-title">Nama : {{ $biodata->nama }} </h5>
                                <h5 class="card-title">Umur : {{ $biodata->umur }} </h5>
                                <h5 class="card-title">Agama : {{ $biodata->agama }} </h5>
                                <h5 class="card-title">pendidikan : {{ $biodata->pendidikan }} </h5>
                                <h5 class="card-title">pekerjaan : {{ $biodata->pekerjaan }} </h5>
                                <h5 class="card-title">alamat : {{ $biodata->alamat }} </h5>
                                <h5 class="card-title">nomer telpon : {{ $biodata->nomer_tlpn }} </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-header bg-info">Suami</h5>
                            <div class="card-body">
                                <h5 class="card-title">Nama : {{ $biodata->nama_suami }} </h5>
                                <h5 class="card-title">Umur : {{ $biodata->umur_suami }} </h5>
                                <h5 class="card-title">Agama : {{ $biodata->agama_suami }} </h5>
                                <h5 class="card-title">pendidikan : {{ $biodata->pendidikan_suami }} </h5>
                                <h5 class="card-title">pekerjaan : {{ $biodata->pekerjaan_suami }} </h5>
                                <h5 class="card-title">alamat : {{ $biodata->alamat_suami }} </h5>
                                <h5 class="card-title">nomer telpon : {{ $biodata->nomer_suami }} </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card text-center">
        <div class="card-header bg-info">
            Data Pasien
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-sm-6">
                    <h3>HPHT</h3>
                    <h4>{{ $biodata->subjektif->HPHT }}</h3>
                        <h3>HPL</h3>
                        <h4>{{ $biodata->subjektif->hpl }}</h4>

                </div>
                <div class="col-sm-6">
                    <!-- Tambahkan elemen canvas untuk menampilkan grafik -->
                    <canvas id="beratBadanChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="card-footer text-muted">
            <a href="/biodata" class="btn btn-primary">Kembali</a>
        </div>
    </div>

    <!-- Tambahkan script untuk menggambar grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Ambil data checkup berat badan dan tanggal
        const checkupData = @json($checkupData);
        const beratData = checkupData.map(data => data.berat);
        const tanggalData = checkupData.map(data => data.tanggal);

        // Buat grafik berat badan menggunakan Chart.js
        const ctx = document.getElementById('beratBadanChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: tanggalData,
                datasets: [{
                    label: 'Berat Badan',
                    data: beratData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
