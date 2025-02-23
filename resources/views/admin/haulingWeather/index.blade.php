@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-8 ">
        <div class="py-8">
            <!-- Judul dan Tombol Tambah truck -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Hauling Route Weather List</h1>
                <a href="{{ route('hauling-route-weather.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded no-underline">
                    Add Route
                </a>
            </div>

            <div class="mb-6">
                <form action="{{ route('hauling-route-weather.index') }}" method="GET" class="flex">
                    <div class="relative flex-grow">
                        <input type="text" name="search" placeholder="Search by kilometer, weather..."
                            class="w-full px-4 py-2 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ request('search') }}">
                        <!-- Tombol X untuk hapus search -->
                        @if (request('search'))
                            <a href="{{ route('hauling-route-weather.index') }}"
                                class="no-underline absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-r-md">
                                X
                            </a>
                        @endif
                    </div>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-r-md">
                        Search
                    </button>
                </form>
            </div>

            <!-- Tabel truck -->
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Route Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kilometer
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                latitude
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Longtitude
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Weather Condition
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                            </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($haulingWeather as $weather)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $weather->hauling_route->route_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $weather->kilometer }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $weather->latitude }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $weather->longitude }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $weather->weather_condition }}
                                </td>

                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('hauling-route-weather.edit', $weather->id) }}"
                                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-2 rounded no-underline mr-2">
                                        Edit
                                    </a>
                                    <form action="{{ route('hauling-route-weather.destroy', $weather->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-2 rounded no-underline"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus truck ini?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mb-4 mx-4">
                    {{ $haulingWeather->appends(['search' => request('search')])->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
