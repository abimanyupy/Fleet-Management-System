@extends('layouts.app')

@section('content')
<div class="container mx-auto pt-8 px-4 sm:px-8 flex justify-center items-center min-h-full">
    <div class="w-full max-w-md">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">Add Truck Service</h1>

        <form action="{{ route('truck-service.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <!-- Dropdown untuk memilih truk -->
            <div class="mb-4">
                <label for="truck_id" class="block text-sm font-medium text-gray-700">Truck</label>
                <div class="relative">
                    <!-- Tombol untuk membuka dropdown -->
                    <button type="button" onclick="toggleDropdown()" class="bg-white border border-gray-300 rounded-md px-4 py-2 w-full text-left flex items-center justify-between">
                        <span id="selectedTruck">Pilih Truk</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="dropdownMenu" class="absolute hidden mt-2 w-full bg-white border border-gray-300 rounded-md shadow-lg z-10">
                        <!-- Input Search -->
                        <input type="text" id="searchInput" placeholder="Cari truk..." class="w-full px-4 py-2 border-b border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <!-- Daftar Truk -->
                        <div id="truckList" class="max-h-48 overflow-y-auto">
                            @foreach ($trucks as $truck)
                                <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer" data-truck-id="{{ $truck->id }}" onclick="selectTruck('{{ $truck->id }}', '{{ $truck->number_plate }}')">
                                    {{ $truck->number_plate }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Input hidden untuk menyimpan truck_id -->
                <input type="hidden" name="truck_id" id="truck_id" required>
            </div>

            <!-- Input Service Description -->
            <div class="mb-4">
                <label for="service_description" class="block text-sm font-medium text-gray-700">Service Description</label>
                <input type="text" name="service_description" id="service_description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>

            <div class="mt-6 flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                    Save
                </button>
                <a href="{{ route('truck-service.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded w-full text-center no-underline">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk membuka/menutup dropdown
    function toggleDropdown() {
        const dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.classList.toggle('hidden');
    }

    // Fungsi untuk memfilter daftar truk
    document.getElementById('searchInput').addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();
        const truckList = document.getElementById('truckList').children;

        for (let i = 0; i < truckList.length; i++) {
            const truck = truckList[i];
            const truckText = truck.textContent.toLowerCase();
            const regex = new RegExp(`^${searchValue}`);

            if (truckText.includes(searchValue)) {
                truck.style.display = 'block';
            } else {
                truck.style.display = 'none';
            }
        }
    });

    // Fungsi untuk memilih truk
    function selectTruck(truckId, truckNumberPlate) {
        document.getElementById('truck_id').value = truckId; // Set nilai truck_id
        document.getElementById('selectedTruck').textContent = truckNumberPlate; // Tampilkan nomor plat yang dipilih
        toggleDropdown(); // Tutup dropdown
    }

    // Tutup dropdown saat klik di luar dropdown
    document.addEventListener('click', function (event) {
        const dropdownMenu = document.getElementById('dropdownMenu');
        const button = document.querySelector('button[onclick="toggleDropdown()"]');

        if (!dropdownMenu.contains(event.target) && !button.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>
@endsection
