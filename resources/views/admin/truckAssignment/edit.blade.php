<!-- resources/views/drivers/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto pt-8 px-4 sm:px-8 flex justify-center items-center min-h-full">
        <div class="w-full max-w-md">
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Edit Driver</h1>

            <form action="{{ route('truck-assignment.update', $truckAssignment->id) }}" method="POST"
                class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" id="notes"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        rows="4"></textarea>
                </div>

                <!-- Tombol Update dan Cancel -->
                <div class="mt-6 flex space-x-4">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                        Update
                    </button>
                    <a href="{{ route('truck-assignment.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded w-full text-center no-underline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
