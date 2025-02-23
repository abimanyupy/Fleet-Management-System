@extends('layouts.app')

@section('content')
    <div class="container mx-auto pt-8 px-4 sm:px-8 flex justify-center items-center min-h-full">
        <div class="w-full max-w-md">
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Add Hauling Route Weather</h1>

            <form action="{{ route('hauling-route-weather.store') }}" method="POST"
                class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                <div class="mb-4">
                    <label for="route_id" class="block text-sm font-medium text-gray-700">Hauling Route</label>
                    <div class="relative">
                        <button type="button" onclick="toggleRouteDropdown()"
                            class="bg-white border border-gray-300 rounded-md px-4 py-2 w-full text-left flex items-center justify-between">
                            <span id="selectedRoute">Pilih Rute Hauling</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        <div id="RouteDropdown"
                            class="absolute hidden mt-2 w-full bg-white border border-gray-300 rounded-md shadow-lg z-10">
                            <input type="text" id="searchRouteInput" placeholder="Cari rute..."
                                class="w-full px-4 py-2 border-b border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <div id="routeList" class="max-h-48 overflow-y-auto">
                                @foreach ($haulingRoute as $route)
                                    <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                        data-route-id="{{ $route->id }}"
                                        onclick="selectRoute('{{ $route->id }}', '{{ $route->route_name }}')">
                                        {{ $route->route_name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="route_id" id="hauling_route_id" required>
                </div>

                <div class="mb-4">
                    <label for="kilometer" class="block text-sm font-medium text-gray-700">Kilometer</label>
                    <input type="number" name="kilometer" id="kilometer"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                    <input type="text" name="latitude" id="latitude"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                    <input type="text" name="longitude" id="longitude"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="weather_condition" class="block text-sm font-medium text-gray-700">Weather Condition</label>
                    <input type="text" name="weather_condition" id="weather_condition"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                </div>

                <div class="mt-6 flex space-x-4">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                        Save
                    </button>
                    <a href="{{ route('hauling-route-weather.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded w-full text-center no-underline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleRouteDropdown() {
            const RouteDropdown = document.getElementById('RouteDropdown');
            RouteDropdown.classList.toggle('hidden');
        }

        document.getElementById('searchRouteInput').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const routeList = document.getElementById('routeList').children;

            for (let i = 0; i < routeList.length; i++) {
                const route = routeList[i];
                const routeText = route.textContent.toLowerCase();
                const regex = new RegExp(`^${searchValue}`);

                if (routeText.includes(searchValue)) {
                    route.style.display = 'block';
                } else {
                    route.style.display = 'none';
                }
            }
        });

        function selectRoute(routeId, routeName) {
            document.getElementById('hauling_route_id').value = routeId;
            document.getElementById('selectedRoute').textContent = routeName;
            toggleRouteDropdown();
        }

        document.addEventListener('click', function(event) {
            const RouteDropdown = document.getElementById('RouteDropdown');
            const button = document.querySelector('button[onclick="toggleRouteDropdown()"]');

            if (!RouteDropdown.contains(event.target) && !button.contains(event.target)) {
                RouteDropdown.classList.add('hidden');
            }
        });
    </script>
@endsection
