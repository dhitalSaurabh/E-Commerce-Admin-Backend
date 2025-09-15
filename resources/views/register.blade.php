{{-- <!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
        </div>
        <div>
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        </div>
        <div>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <div>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        </div>
        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
</body>
</html> --}}

<x-layout>
    <h1 class="text-2xl font-bold mb-4">Register Here</h1>
    
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <x-auth.register-form />
    {{-- <a>Click here if not registered.</a> --}}
    <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
     <script src="{{ asset('js/register-api.js')}}"></script>
</x-layout>

