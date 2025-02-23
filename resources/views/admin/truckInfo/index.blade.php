@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-8 ">
        <div class="py-8">
            <!-- Judul dan Tombol Tambah truck -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Truck List</h1>
                <a href="{{ route('trucks.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded no-underline">
                    Add Truck Info
                </a>
            </div>

            <div class="mb-6">
                <form action="{{ route('trucks.index') }}" method="GET" class="flex">
                    <div class="relative flex-grow">
                        <input type="text" name="search" placeholder="Search by license plate, license number..."
                            class="w-full px-4 py-2 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ request('search') }}">
                        <!-- Tombol X untuk hapus search -->
                        @if (request('search'))
                            <a href="{{ route('trucks.index') }}"
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
                                Truck Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                License Plate
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Truck Capacity
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fuel Capacity
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                License Number
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created Date
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Expired Date
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                License Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($trucks as $truck)
                            <tr>
                                {{-- @dd($truck->truck_services->first()->service_status) --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if ($truck->truck_services->isNotEmpty())
                                        @php
                                            $service = $truck->truck_services->first(); // Ambil service terbaru
                                        @endphp
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $service->service_status == 'READY'
                                                    ? 'bg-green-500 text-white'
                                                    : ($service->service_status == 'NEED REPAIR'
                                                        ? 'bg-red-500 text-white'
                                                        : ($service->service_status == 'IN SERVICE'
                                                            ? 'bg-yellow-500 text-white'
                                                            : 'bg-gray-500 text-white')) }}">
                                                                            {{ $service->service_status }}
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500 text-white">
                                            READY
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $truck->number_plate }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $truck->truck_capacity }} ton
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $truck->fuel_capacity }} liter
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $truck->license_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($truck->created_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($truck->expired_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $truck->license_status == 'active' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }} text-center">
                                        {{ $truck->license_status }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('trucks.edit', $truck->id) }}"
                                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-2 rounded no-underline mr-2">
                                        Edit
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('trucks.destroy', $truck->id) }}" method="POST" class="inline">
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
                    {{ $trucks->appends(['search' => request('search')])->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
