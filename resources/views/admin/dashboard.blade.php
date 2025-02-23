@extends('layouts.app')

@section('content')
<form action="{{ route('logout') }}" method="POST" class="mt-4 text-center">
    @csrf
    <button type="submit"
        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
        Logout
    </button>
</form>
    
@endsection
