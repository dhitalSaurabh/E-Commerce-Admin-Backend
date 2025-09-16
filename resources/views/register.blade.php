@extends('layouts.auth')

@section('content')
{{-- <x-layout> --}}
     <div class="bg-white bg-opacity-90 shadow-xl rounded-lg p-8 w-full max-w-md z-10">
    <h1 class="text-2xl font-bold mb-4">Register Here</h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <x-auth.register-form />
    {{-- <a>Click here if not registered.</a> --}}
    <p class="mt-6 text-center text-sm text-gray-700">
        Already have an account? <a href="{{ url('/auth/login') }}" class="text-indigo-600 hover:underline font-medium">Login here</a></p>
    <script src="{{ asset('js/register-api.js')}}"></script>
{{-- </x-layout> --}}
@endsection