@extends('layouts.app')

@section('content')
    <div class="container mx-auto pt-8 px-4 sm:px-8 flex justify-center items-center min-h-full">
        <div class="w-full max-w-md">
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Create Truck Assignment</h1>

            <form action="{{ route('truck-assignment.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf

                <!-- Dropdown untuk memilih Truck -->
                <div class="mb-4">
                    <label for="truck_id" class="block text-sm font-medium text-gray-700">Truck</label>
                    <div class="relative">
                        <!-- Tombol untuk membuka dropdown -->
                        <button type="button" onclick="toggleTruckDropdown()"
                            class="bg-white border border-gray-300 rounded-md px-4 py-2 w-full text-left flex items-center justify-between">
                            <span id="selectedTruck">Pilih Truk</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="TruckDropdown"
                            class="absolute hidden mt-2 w-full bg-white border border-gray-300 rounded-md shadow-lg z-10">
                            <!-- Input Search -->
                            <input type="text" id="searchTruckInput" placeholder="Cari truk..."
                                class="w-full px-4 py-2 border-b border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <!-- Daftar Truk -->
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
                    <!-- Input hidden untuk menyimpan truck_id -->
                    <input type="hidden" name="truck_id" id="truck_id" required>
                </div>

                <!-- Dropdown untuk memilih Driver -->
                <div class="mb-4">
                    <label for="driver_id" class="block text-sm font-medium text-gray-700">Driver</label>
                    <div class="relative">
                        <!-- Tombol untuk membuka dropdown -->
                        <button type="button" onclick="toggleDriverDropdown()"
                            class="bg-white border border-gray-300 rounded-md px-4 py-2 w-full text-left flex items-center justify-between">
                            <span id="selectedDriver">Pilih Driver</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="DriverDropdown"
                            class="absolute hidden mt-2 w-full bg-white border border-gray-300 rounded-md shadow-lg z-10">
                            <!-- Input Search -->
                            <input type="text" id="searchDriverInput" placeholder="Cari driver..."
                                class="w-full px-4 py-2 border-b border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <!-- Daftar Driver -->
                            <div id="driverList" class="max-h-48 overflow-y-auto">
                                @foreach ($drivers as $driver)
                                    <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                        data-driver-id="{{ $driver->id }}"
                                        onclick="selectDriver('{{ $driver->id }}', '{{ $driver->name }}')">
                                        {{ $driver->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- Input hidden untuk menyimpan driver_id -->
                    <input type="hidden" name="driver_id" id="driver_id" required>
                </div>

                <!-- Dropdown untuk memilih Route -->
                <div class="mb-4">
                    <label for="hauling_route_id" class="block text-sm font-medium text-gray-700">Route</label>
                    <select name="hauling_route_id" id="hauling_route_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach ($haullingRoutes as $route)
                            <option value="{{ $route->id }}">{{ $route->route_name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Total Load -->
                <div class="mb-4">
                    <label for="total_load" class="block text-sm font-medium text-gray-700">Total Load (ton)</label>
                    <input type="text" name="total_load" id="total_load" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                {{-- <!-- Notes -->
                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" id="notes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="4"></textarea>
                </div> --}}

                <!-- Submit and Cancel Buttons -->
                <div class="mt-6 flex space-x-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                        Save
                    </button>
                    <a href="{{ route('truck-assignment.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded w-full text-center no-underline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Fungsi untuk membuka/menutup dropdown Truck
        function toggleTruckDropdown() {
            const TruckDropdown = document.getElementById('TruckDropdown');
            TruckDropdown.classList.toggle('hidden');
        }

        // Fungsi untuk memfilter daftar Truck
        document.getElementById('searchTruckInput').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const truckList = document.getElementById('truckList').children;

            for (let i = 0; i < truckList.length; i++) {
                const truck = truckList[i];
                const truckText = truck.textContent.toLowerCase();

                if (truckText.includes(searchValue)) {
                    truck.style.display = 'block';
                } else {
                    truck.style.display = 'none';
                }
            }
        });

        // Fungsi untuk memilih Truck
        function selectTruck(truckId, truckNumberPlate) {
            document.getElementById('truck_id').value = truckId; // Set nilai truck_id
            document.getElementById('selectedTruck').textContent = truckNumberPlate; // Tampilkan nomor plat yang dipilih
            toggleTruckDropdown(); // Tutup dropdown
        }

        // Tutup dropdown Truck saat klik di luar dropdown
        document.addEventListener('click', function(event) {
            const TruckDropdown = document.getElementById('TruckDropdown');
            const button = document.querySelector('button[onclick="toggleTruckDropdown()"]');

            if (!TruckDropdown.contains(event.target) && !button.contains(event.target)) {
                TruckDropdown.classList.add('hidden');
            }
        });

        // Fungsi untuk membuka/menutup dropdown Driver
        function toggleDriverDropdown() {
            const DriverDropdown = document.getElementById('DriverDropdown');
            DriverDropdown.classList.toggle('hidden');
        }

        // Fungsi untuk memfilter daftar Driver
        document.getElementById('searchDriverInput').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const driverList = document.getElementById('driverList').children;

            for (let i = 0; i < driverList.length; i++) {
                const driver = driverList[i];
                const driverText = driver.textContent.toLowerCase();

                if (driverText.includes(searchValue)) {
                    driver.style.display = 'block';
                } else {
                    driver.style.display = 'none';
                }
            }
        });

        // Fungsi untuk memilih Driver
        function selectDriver(driverId, driverName) {
            document.getElementById('driver_id').value = driverId; // Set nilai driver_id
            document.getElementById('selectedDriver').textContent = driverName; // Tampilkan nama driver yang dipilih
            toggleDriverDropdown(); // Tutup dropdown
        }

        // Tutup dropdown Driver saat klik di luar dropdown
        document.addEventListener('click', function(event) {
            const DriverDropdown = document.getElementById('DriverDropdown');
            const button = document.querySelector('button[onclick="toggleDriverDropdown()"]');

            if (!DriverDropdown.contains(event.target) && !button.contains(event.target)) {
                DriverDropdown.classList.add('hidden');
            }
        });
    </script>
@endsection
