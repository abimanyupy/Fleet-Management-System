@extends('layouts.app')

@section('content')
    <div class="container mx-auto pt-8 px-4 sm:px-8 flex justify-center items-center min-h-full">
        <div class="w-full max-w-md">
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Edit GPS</h1>

            <form action="{{ route('gps.update', $gps->id) }}" method="POST"
                class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="truck_id" class="block text-sm font-medium text-gray-700">Truck</label>
                    <div class="relative">
                        <button type="button" onclick="toggleTruckDropdown()"
                            class="bg-white border border-gray-300 rounded-md px-4 py-2 w-full text-left flex items-center justify-between">
                            <span id="selectedTruck">{{ $gps->trucks->number_plate ?? 'Pilih Truk' }}</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        <div id="TruckDropdown"
                            class="absolute hidden mt-2 w-full bg-white border border-gray-300 rounded-md shadow-lg z-10">
                            <input type="text" id="searchTrukInput" placeholder="Cari truk..."
                                class="w-full px-4 py-2 border-b border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <div id="truckList" class="max-h-48 overflow-y-auto">
                                @foreach ($trucks as $truck)
                                    <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                        data-truck-id="{{ $truck->id }}"
                                        onclick="selectTruck('{{ $truck->id }}', '{{ $truck->number_plate }}')">
                                        {{ $truck->number_plate }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="truck_id" id="truck_id" value="{{ $gps->truck_id }}" required>
                </div>

                <div class="mb-4">
                    <label for="device_id" class="block text-sm font-medium text-gray-700">Device ID</label>
                    <input type="text" name="device_id" id="device_id" value="{{ $gps->device_id }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                    <input type="text" name="latitude" id="latitude" value="{{ $gps->latitude }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                    <input type="text" name="longitude" id="longitude" value="{{ $gps->longitude }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                </div>

                <div class="mt-6 flex space-x-4">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                        Save
                    </button>
                    <a href="{{ route('gps.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded w-full text-center no-underline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Fungsi untuk membuka/menutup dropdown
        function toggleTruckDropdown() {
            const TruckDropdown = document.getElementById('TruckDropdown');
            TruckDropdown.classList.toggle('hidden');
        }

        // Fungsi untuk memfilter daftar truk
        document.getElementById('searchTrukInput').addEventListener('input', function() {
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
            toggleTruckDropdown(); // Tutup dropdown
        }

        // Tutup dropdown saat klik di luar dropdown
        document.addEventListener('click', function(event) {
            const TruckDropdown = document.getElementById('TruckDropdown');
            const button = document.querySelector('button[onclick="toggleTruckDropdown()"]');

            if (!TruckDropdown.contains(event.target) && !button.contains(event.target)) {
                TruckDropdown.classList.add('hidden');
            }
        });
    </script>
@endsection
