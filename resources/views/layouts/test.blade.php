<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom CSS untuk menyembunyikan/menampilkan section */
        .section-content {
            display: none;
        }
        .section-content.active {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="py-2 fixed top-0 z-10 w-full bg-white shadow-md">
        <div class="container mx-auto px-4 sm:px-8 flex justify-between items-center h-16">
            <!-- Logo atau Judul Aplikasi -->
            <div class="flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="text-xl font-semibold text-gray-900 no-underline">
                    Manajemen Armada
                </a>
            </div>

            <!-- Menu Navigasi -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 no-underline">Dashboard</a>
                <a href="{{ route('trucks.index') }}" class="text-gray-700 hover:text-indigo-600 no-underline">Truck</a>
                <a href="{{ route('drivers.index') }}" class="text-gray-700 hover:text-indigo-600 no-underline">Driver</a>
                <a href="{{ route('truck_assignment.index') }}" class="text-gray-700 hover:text-indigo-600 no-underline">Truck Assignment</a>
                <a href="{{ route('hauling_route.index') }}" class="text-gray-700 hover:text-indigo-600 no-underline">Hauling Route</a>
            </div>

            <!-- Tombol Menu Mobile (Hamburger) -->
            <div class="md:hidden">
                <button type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none" onclick="toggleMobileMenu()">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex pt-16">
        <!-- Sidebar untuk Truck -->
        <div id="truck-sidebar" class="w-64 bg-white shadow-md fixed h-full">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-800">Truck Management</h2>
                <ul class="mt-4 space-y-2">
                    <li>
                        <a href="#truck-info" class="block text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 p-2 rounded no-underline" onclick="showSection('truck-info')">Truck Info</a>
                    </li>
                    <li>
                        <a href="#truck-condition" class="block text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 p-2 rounded no-underline" onclick="showSection('truck-condition')">Truck Condition</a>
                    </li>
                    <li>
                        <a href="#truck-service" class="block text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 p-2 rounded no-underline" onclick="showSection('truck-service')">Truck Service</a>
                    </li>
                    <li>
                        <a href="#fuel-logs" class="block text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 p-2 rounded no-underline" onclick="showSection('fuel-logs')">Fuel Logs</a>
                    </li>
                    <li>
                        <a href="#gps" class="block text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 p-2 rounded no-underline" onclick="showSection('gps')">GPS</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Sidebar untuk Hauling Route -->
        <div id="hauling-route-sidebar" class="w-64 bg-white shadow-md fixed h-full hidden">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-800">Hauling Route</h2>
                <ul class="mt-4 space-y-2">
                    <li>
                        <a href="#hauling-route-info" class="block text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 p-2 rounded no-underline" onclick="showSection('hauling-route-info')">Hauling Route Info</a>
                    </li>
                    <li>
                        <a href="#hauling-route-weather" class="block text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 p-2 rounded no-underline" onclick="showSection('hauling-route-weather')">Hauling Route Weather</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Content Area -->
        <div class="ml-64 flex-1 p-8">
            <!-- Truck Sections -->
            <section id="truck-info" class="section-content active mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Truck Info</h2>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p>Informasi umum tentang truk.</p>
                </div>
            </section>

            <section id="truck-condition" class="section-content mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Truck Condition</h2>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p>Informasi kondisi truk.</p>
                </div>
            </section>

            <section id="truck-service" class="section-content mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Truck Service</h2>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p>Riwayat servis truk.</p>
                </div>
            </section>

            <section id="fuel-logs" class="section-content mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Fuel Logs</h2>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p>Catatan penggunaan bahan bakar.</p>
                </div>
            </section>

            <section id="gps" class="section-content mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">GPS</h2>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p>Informasi pelacakan GPS truk.</p>
                </div>
            </section>

            <!-- Hauling Route Sections -->
            <section id="hauling-route-info" class="section-content mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Hauling Route Info</h2>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p>Informasi rute pengangkutan.</p>
                </div>
            </section>

            <section id="hauling-route-weather" class="section-content mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Hauling Route Weather</h2>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p>Informasi cuaca untuk rute pengangkutan.</p>
                </div>
            </section>
        </div>
    </div>

    <!-- Script untuk Menu Mobile dan Toggle Section -->
    <script>
        // Toggle Mobile Menu
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Tampilkan section yang dipilih
        function showSection(sectionId) {
            // Sembunyikan semua section
            document.querySelectorAll('.section-content').forEach(section => {
                section.classList.remove('active');
            });

            // Tampilkan section yang dipilih
            document.getElementById(sectionId).classList.add('active');
        }

        // Toggle Sidebar berdasarkan halaman
        function toggleSidebar(page) {
            document.getElementById('truck-sidebar').classList.toggle('hidden', page !== 'truck');
            document.getElementById('hauling-route-sidebar').classList.toggle('hidden', page !== 'hauling-route');
        }

        // Contoh: Saat halaman Truck diklik
        document.querySelector('a[href="{{ route('trucks.index') }}"]').addEventListener('click', () => {
            toggleSidebar('truck');
        });

        // Contoh: Saat halaman Hauling Route diklik
        document.querySelector('a[href="{{ route('hauling_route.index') }}"]').addEventListener('click', () => {
            toggleSidebar('hauling-route');
        });
    </script>
</body>
</html>
