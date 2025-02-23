<!-- resources/views/layouts/navbar.blade.php -->
<nav class="py-2 fixed top-0 z-10 w-full bg-white shadow-md">
    <div class="container mx-auto px-4 sm:px-8 flex justify-between items-center h-16">
        <!-- Logo atau Judul Aplikasi -->
        <div class="flex-shrink-0">
            <a href="{{ route('dashboard') }}" class="text-xl font-semibold text-gray-900 no-underline">
                Fleet Management
            </a>
        </div>

        <!-- Menu Navigasi -->
        <div class="hidden md:flex space-x-12">
            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 no-underline">Dashboard</a>

            <!-- Dropdown Truck -->
            <div class="relative">
                <button onclick="toggleDropdown('truck-dropdown-desktop')"
                    class="text-gray-700 hover:text-indigo-600 no-underline focus:outline-none">
                    Truck
                    <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="truck-dropdown-desktop" class="absolute hidden bg-white shadow-md rounded-md mt-2 w-48">
                    <a href="{{ route('trucks.index') }}"
                        class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 no-underline">Truck
                        Info</a>
                    <a href="{{ route('truck-service.index') }}"
                        class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 no-underline">Truck
                        Service</a>
                    <a href="{{ route('fuel-logs.index') }}"
                        class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 no-underline">Fuel
                        Logs
                    </a>
                    <a href="{{ route('gps.index') }}"
                        class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 no-underline">GPS
                    </a>

                </div>
            </div>

            <a href="{{ route('drivers.index') }}" class="text-gray-700 hover:text-indigo-600 no-underline">Driver</a>
            <a href="{{ route('truck-assignment.index') }}"
                class="text-gray-700 hover:text-indigo-600 no-underline">Truck Assignment</a>
            <!-- Dropdown Hauling Route -->
            <div class="relative">
                <button onclick="toggleDropdown('hauling-dropdown-desktop')"
                    class="text-gray-700 hover:text-indigo-600 no-underline focus:outline-none">
                    Hauling Route
                    <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="hauling-dropdown-desktop" class="absolute hidden bg-white shadow-md rounded-md mt-2 w-48">
                    <a href="{{ route('hauling-route.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 no-underline">Hauling Route Info</a>
                    <a href="{{ route('hauling-route-weather.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 no-underline">Hauling Route Weather</a>
                </div>
            </div>
        </div>


        <!-- Tombol Menu Mobile (Hamburger) -->
        <div class="md:hidden">
            <button type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none"
                onclick="toggleMobileMenu()">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Menu Mobile (Dropdown) -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-4 pt-2 pb-3 space-y-8 sm:px-3">
            <a href="{{ route('dashboard') }}"
                class="block text-gray-700 hover:text-indigo-600 no-underline">Dashboard</a>

            <!-- Dropdown Truck (Mobile) -->
            <div>
                <button onclick="toggleDropdown('truck-dropdown-mobile')"
                    class="text-gray-700 hover:text-indigo-600 no-underline focus:outline-none">
                    Truck
                    <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="truck-dropdown-mobile" class="hidden pl-2 mt-4 space-y-4">
                    <a href="{{ route('trucks.index') }}"
                        class="block text-gray-700 hover:text-indigo-600 no-underline">Truck Info</a>
                    <a href="{{ route('trucks.index') }}"
                        class="block text-gray-700 hover:text-indigo-600 no-underline">Truck Service</a>
                    <a href="{{ route('trucks.index') }}"
                        class="block text-gray-700 hover:text-indigo-600 no-underline">Fuel Logs</a>
                    <a href="{{ route('trucks.index') }}"
                        class="block text-gray-700 hover:text-indigo-600 no-underline">GPS</a>

                </div>
            </div>

            <a href="{{ route('drivers.index') }}"
                class="block text-gray-700 hover:text-indigo-600 no-underline">Driver</a>
            {{-- <a href="{{ route('truck_assignment.index') }}" class="block text-gray-700 hover:text-indigo-600 no-underline">Truck Assignment</a> --}}

            <!-- Dropdown Hauling Route (Mobile) -->
            <div>
                <button onclick="toggleDropdown('hauling-dropdown-mobile')"
                    class="text-gray-700 hover:text-indigo-600 no-underline focus:outline-none">
                    Hauling Route
                    <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="hauling-dropdown-mobile" class="hidden pl-4 mt-2 space-y-2">
                    {{-- <a href="{{ route('hauling_route.index') }}" class="block text-gray-700 hover:text-indigo-600 no-underline">Hauling Route Info</a>
                    <a href="{{ route('hauling_route.weather') }}" class="block text-gray-700 hover:text-indigo-600 no-underline">Hauling Route Weather</a> --}}
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Script untuk Dropdown dan Menu Mobile -->
<script>
    // Fungsi untuk toggle menu mobile
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    }

    // Fungsi untuk toggle dropdown
    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        dropdown.classList.toggle('hidden');
    }

    // Tutup dropdown saat klik di luar dropdown
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.relative');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(event.target)) {
                const dropdownContent = dropdown.querySelector('div');
                if (dropdownContent && !dropdownContent.classList.contains('hidden')) {
                    dropdownContent.classList.add('hidden');
                }
            }
        });
    });
</script>
