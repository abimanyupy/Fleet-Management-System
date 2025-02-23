<!-- resources/views/drivers/show.blade.php -->
@extends('layouts.app')

@section('content')
<h1>Detail Driver</h1>
<p><strong>Nama:</strong> {{ $drivers->name }}</p>
<p><strong>Nomor Telepon:</strong> {{ $drivers->phone_number }}</p>
<p><strong>Email:</strong> {{ $drivers->email }}</p>
<p><strong>Status:</strong> {{ $drivers->status }}</p>
<p><strong>Nomor Lisensi:</strong> {{ $drivers->license_number }}</p>
<a href="{{ route('drivers.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
