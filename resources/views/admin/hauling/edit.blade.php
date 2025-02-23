div<!-- resources/views/admin/truck/partials/truckInfo/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto pt-8 px-4 sm:px-8 flex justify-center items-center min-h-full">
        <div class="w-full max-w-md">
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Edit Truck Info</h1>

            <form action="{{ route('hauling-route.update', $haulingRoute->id) }}" method="POST"
                class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="route_name" class="block text-sm font-medium text-gray-700">Route Name</label>
                    <input type="text" name="route_name" id="route_name" value="{{ $haulingRoute->route_name }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                </div>

                <!-- Input Truck Capacity -->
                <div class="mb-4">
                    <label for="length" class="block text-sm font-medium text-gray-700">Length (km)</label>
                    <input type="number" name="length" id="length" value="{{ $haulingRoute->length }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="estimation_time" class="block text-sm font-medium text-gray-700">Estimated Time (minutes</label>
                    <input type="time" name="estimation_time" id="estimation_time" value="{{ $haulingRoute->estimation_time }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                </div>

                <div class="mt-6 flex space-x-4">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                        Save
                    </button>
                    <a href="{{ route('trucks.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded w-full text-center no-underline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
