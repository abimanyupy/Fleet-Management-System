<!-- resources/views/drivers/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto pt-8 px-4 sm:px-8 flex justify-center items-center min-h-full">
    <div class="w-full max-w-md">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">Add Driver</h1>

        <form action="{{ route('drivers.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <!-- Input Nama -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-3" required>
            </div>

            <!-- Input Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-3" required>
            </div>

            <!-- Input Nomor Telepon -->
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number:</label>
                <input type="text" name="phone" id="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-3" required>
            </div>

            <!-- Input Nomor Lisensi -->
            <div class="mb-4">
                <label for="license_number" class="block text-sm font-medium text-gray-700">License Number:</label>
                <input type="text" name="license_number" id="license_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-3" required>
            </div>

            <!-- Tombol Simpan dan Cancel -->
            <div class="mt-6 flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                    Save
                </button>
                <a href="{{ route('drivers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded w-full text-center no-underline">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
