<x-layout>
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <h1 class="text-2xl font-bold mb-4">Login Here</h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <x-auth.login-form />
    {{-- <a>Click here if not registered.</a> --}}
    <p>Click here if not registered<a href="{{ route('register') }}">Register here</a></p>
    <script src="{{ asset('js/login-api.js')}}"></script>
</x-layout>