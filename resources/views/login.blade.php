@extends('layouts.auth')

@section('content')
{{-- <x-layout> --}}
    <div class="bg-white bg-opacity-90 shadow-xl rounded-lg p-8 w-full max-w-md z-10">
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Login Here</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded text-sm">
                {{ session('error') }}
            </div>
        @endif
        <x-auth.login-form />
        <p class="mt-6 text-center text-sm text-gray-700">
            Not registered yet?
            <a href="{{ url('/auth/register') }}" class="text-indigo-600 hover:underline font-medium">Register here</a>
        </p>
    </div>
    <script src="{{ asset('js/login-api.js')}}"></script>
{{-- </x-layout> --}}
@endsection
