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
 <script>
document.addEventListener('DOMContentLoaded', function () {
    const successMessage = localStorage.getItem('register_success');

    if (successMessage) {
        // Show the notification
        showPopup(successMessage);

        // Remove it so it doesn’t show again on refresh
        localStorage.removeItem('register_success');
    }

    function showPopup(message) {
        const notification = document.createElement('div');
        notification.innerText = message;
        notification.className = 'fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50 transition-opacity duration-500 opacity-0';
        document.body.appendChild(notification);

        // Fade in
        setTimeout(() => {
            notification.classList.add('opacity-100');
        }, 10);

        // Fade out after 3s
        setTimeout(() => {
            notification.classList.remove('opacity-100');
            notification.classList.add('opacity-0');
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const msg = localStorage.getItem('logout_message');
    if (msg) {
        alert(msg); // or use showPopup(msg);
        localStorage.removeItem('logout_message');
    }
});
</script>
@endsection
