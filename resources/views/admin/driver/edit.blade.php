<!-- resources/views/drivers/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto pt-8 px-4 sm:px-8 flex justify-center items-center min-h-full">
        <div class="w-full max-w-md">
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Edit Driver</h1>

            <form action="{{ route('drivers.update', $drivers->id) }}" method="POST"
                class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                @method('PUT')

                <!-- Input Nama -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                    <input type="text" name="name" id="name" value="{{ $drivers->name }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-3"
                        required>
                </div>

                <!-- Input Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" name="email" id="email" value="{{ $drivers->email }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-3"
                        required>
                </div>

                <!-- Input Nomor Telepon -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number:</label>
                    <input type="text" name="phone" id="phone" value="{{ $drivers->phone }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-3"
                        required>
                </div>

                <!-- Input Nomor Lisensi -->
                <div class="mb-4">
                    <label for="license_number" class="block text-sm font-medium text-gray-700">License Number:</label>
                    <input type="text" name="license_number" id="license_number" value="{{ $drivers->license_number }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-3"
                        required>
                </div>

                <!-- Input Status Driver -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Driver Status:</label>
                    <div class="mt-2 space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="driver_status" value="active"
                                {{ $drivers->driver_status == 'active' ? 'checked' : '' }}
                                class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                            <span class="ml-2">Active</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="driver_status" value="inactive"
                                {{ $drivers->driver_status == 'inactive' ? 'checked' : '' }}
                                class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                            <span class="ml-2">Inactive</span>
                        </label>
                    </div>
                </div>

                <!-- Tombol Update dan Cancel -->
                <div class="mt-6 flex space-x-4">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                        Update
                    </button>
                    <a href="{{ route('drivers.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded w-full text-center no-underline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
