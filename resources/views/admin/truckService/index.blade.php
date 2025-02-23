@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-8 ">
        <div class="py-8">
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            <!-- Judul dan Tombol Tambah truck -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Truck Service List</h1>
                <a href="{{ route('truck-service.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded no-underline">
                    Add Truck Service
                </a>
            </div>

            <div class="mb-6">
                <form action="{{ route('truck-service.index') }}" method="GET" class="flex">
                    <div class="relative flex-grow">
                        <input type="text" name="search"
                            placeholder="Search by service status, number plate, service description..."
                            class="w-full px-4 py-2 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ request('search') }}">
                        <!-- Tombol X untuk hapus search -->
                        @if (request('search'))
                            <a href="{{ route('truck-service.index') }}"
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
                                License Plate
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Service Descirption
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Service Status
                            </th>

                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Start Service Date
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Finish Service Date
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Next Service Date
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($trucksService as $service)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $service->trucks->number_plate }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 w-60 max-w-60 ">
                                    {{ $service->service_description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if ($service->start_service_date)
                                        {{ \Carbon\Carbon::parse($service->start_service_date)->format('d M Y') }}
                                    @elseif ($service->service_status == 'NEED REPAIR')
                                        Segera Perbaikan!
                                    @else
                                        Masa Perbaikan
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if ($service->finish_service_date)
                                        {{ \Carbon\Carbon::parse($service->finish_service_date)->format('d M Y') }}
                                    @elseif ($service->service_status == 'NEED REPAIR')
                                        Segera Perbaikan!
                                    @else
                                        Masa Perbaikan
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if ($service->next_service_date)
                                        {{ \Carbon\Carbon::parse($service->next_service_date)->format('d M Y') }}
                                    @elseif ($service->service_status == 'NEED REPAIR')
                                        Segera Perbaikan!
                                    @else
                                        Masa Perbaikan
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                    <!-- Tombol Edit -->
                                    <form action="{{ route('truck-service.update', $service->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit"
                                            class="{{ $service->buttonData['color'] }} text-white font-bold py-2 px-2 rounded no-underline mr-2"
                                            onclick="return confirm('{{ $service->buttonData['confirm'] }}')"
                                            {{ $service->buttonData['disabled'] ? 'disabled' : '' }}>
                                            {{ $service->buttonData['label'] }}
                                        </button>
                                    </form>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('truck-service.destroy', $service->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-2 rounded no-underline"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus service ini?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mb-4 mx-4">
                    {{ $trucksService->appends(['search' => request('search')])->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
