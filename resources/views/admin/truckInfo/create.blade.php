<!-- resources/views/admin/truck/partials/truckInfo/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto pt-8 px-4 sm:px-8 flex justify-center items-center min-h-full">
    <div class="w-full max-w-md">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">Add Truck Info</h1>

        <form action="{{ route('trucks.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <!-- Input License Plate -->
            <div class="mb-4">
                <label for="number_plate" class="block text-sm font-medium text-gray-700">Number Plate</label>
                <input type="number" name="number_plate" id="number_plate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>

            <!-- Input Truck Capacity -->
            <div class="mb-4">
                <label for="truck_capacity" class="block text-sm font-medium text-gray-700">Truck Capacity (ton)</label>
                <input type="number" name="truck_capacity" id="truck_capacity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>

            {{-- <!-- Input Hauling Max Speed -->
            <div class="mb-4">
                <label for="hauling_max_speed" class="block text-sm font-medium text-gray-700">Hauling Max Speed:</label>
                <input type="number" name="hauling_max_speed" id="hauling_max_speed" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>

            <!-- Input Empty Max Speed -->
            <div class="mb-4">
                <label for="empty_max_speed" class="block text-sm font-medium text-gray-700">Empty Max Speed:</label>
                <input type="number" name="empty_max_speed" id="empty_max_speed" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div> --}}

            <div class="mb-4">
                <label for="fuel_capacity" class="block text-sm font-medium text-gray-700">Fuel Capacity (liter)</label>
                <input type="number" name="fuel_capacity" id="fuel_capacity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>

            <div class="mb-4">
                <label for="license_number" class="block text-sm font-medium text-gray-700">License Number</label>
                <input type="number" name="license_number" id="license_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>

            <div class="mb-4">
                <label for="created_date" class="block text-sm font-medium text-gray-700">Created Date</label>
                <input type="date" name="created_date" id="created_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>

            <div class="mt-6 flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                    Save
                </button>
                <a href="{{ route('trucks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded w-full text-center no-underline">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
