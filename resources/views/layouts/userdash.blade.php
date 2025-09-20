<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="flex">
    {{-- <h2>User Dash</h2> --}}
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

     @hasSection ('content')
            @yield('content')
        @else
            <h1>Welcome to the E-commerce Admin Dashboard</h1>
            <p>Use the sidebar to manage products, orders, users, and more.</p>
        @endif
    {{-- <div id="productsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- JavaScript will populate clothes here -->
    </div> --}}


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const successMessage = localStorage.getItem('login_success');

            if (successMessage) {
                // Show the notification
                showPopup(successMessage, "success");

                // Remove it so it doesn’t show again on refresh
                localStorage.removeItem('login_success');
            }

        });
    </script>
    <script>
        // public/js/auth.js
        document.addEventListener('DOMContentLoaded', function () {
            const token = localStorage.getItem('token');

            if (!token) {
                // Not logged in, redirect to login page
                window.location.href = '/';
            }

            // Optional: You can add token validation via API call here if needed
        });
    </script>
    <script src="{{ asset('js/showpopup.js')}}"></script>
    <script src="{{ asset('js/user-api/products.js')}}"></script>
    <script src="{{ asset('js/user/logout-user-api.js')}}"></script>


</body>

</html>