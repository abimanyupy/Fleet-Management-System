<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fleet Management System</title>
    <!-- Tambahkan CSS atau JS yang diperlukan -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS untuk menyembunyikan/menampilkan section */
        .section-content {
            display: none;
        }
        .section-content.active {
            display: block;
        }
        /* Tambahkan padding ke body untuk menghindari navbar yang fixed */
        /* body {
            padding-top: 80px; /* Sesuaikan dengan tinggi navbar */
        } */
    </style>
</head>
<body>
    <header>
        @include('layouts.navbar') <!-- Include Navbar -->
    </header>

    <div class="container pt-24">
        @yield('content') <!-- Ini adalah tempat konten view akan dimasukkan -->
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
    </script>
</body>
</html>
