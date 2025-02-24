@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Dashboard</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Logout
            </button>
        </form>
    </div>

    <!-- Informasi Pengguna -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-semibold mb-4">Selamat Datang, {{ Auth::user()->name }}!</h2>
        {{-- <p class="text-gray-600">Terakhir login: {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'N/A' }}</p> --}}
    </div>

    {{-- <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold">Jumlah Truk</h3>
            <p class="text-2xl font-bold">{{ $totalTrucks }}</p>
        </div>
        <div class="bg-green-500 text-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold">Jumlah Perangkat GPS</h3>
            <p class="text-2xl font-bold">{{ $totalGpsDevices }}</p>
        </div>
        <div class="bg-purple-500 text-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold">Cuaca Terkini</h3>
            <p class="text-2xl font-bold">{{ $weatherData['current']['temp_c'] ?? 'N/A' }}°C</p>
            <p class="text-sm">{{ $weatherData['current']['condition']['text'] ?? 'N/A' }}</p>
        </div>
    </div> --}}

    {{-- <!-- Grafik -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-semibold mb-4">Aktivitas Truk</h2>
        <canvas id="truckActivityChart" class="w-full h-64"></canvas>
    </div> --}}

    <!-- Tombol CTA -->
    {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="{{ route('trucks.index') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white p-6 rounded-lg shadow-md text-center">
            <i class="fas fa-truck text-3xl mb-2"></i>
            <p class="text-lg font-semibold">Kelola Truk</p>
        </a>
        <a href="{{ route('gps.index') }}" class="bg-teal-500 hover:bg-teal-700 text-white p-6 rounded-lg shadow-md text-center">
            <i class="fas fa-map-marker-alt text-3xl mb-2"></i>
            <p class="text-lg font-semibold">Kelola GPS</p>
        </a> --}}
        {{-- <a href="{{ route('reports.index') }}" class="bg-orange-500 hover:bg-orange-700 text-white p-6 rounded-lg shadow-md text-center">
            <i class="fas fa-chart-bar text-3xl mb-2"></i>
            <p class="text-lg font-semibold">Laporan</p>
        </a>
        <a href="{{ route('settings.index') }}" class="bg-pink-500 hover:bg-pink-700 text-white p-6 rounded-lg shadow-md text-center">
            <i class="fas fa-cog text-3xl mb-2"></i>
            <p class="text-lg font-semibold">Pengaturan</p>
        </a> --}}
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('truckActivityChart').getContext('2d');
    const truckActivityChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Aktivitas Truk',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2
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
