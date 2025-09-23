<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="padding-5px">
    <div class="relative flex justify-end items-center gap-x-4 mb-9">

        
    <!-- Container for the top-right aligned icon and dropdown -->
    {{-- <div class="relative w-full"> --}}
        <div class="absolute top-4 right-4 relative">
            <a id="profileIcon" onclick="toggleProfileDropdown()" href="javascript:void(0);"
                class="text-blue-600 hover:text-black-800 text-2xl transition duration-300">
                <i class="fas fa-user-circle"></i>
            </a>
            <div id="profileDropdown"
                class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-50">
                <div class="block">
                    <a href="/" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Home</a>
                    <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                    <a href="/mycarts" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Carts</a>
                    <a href="/my-orders" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Orders</a>
                    <a href="/my-payments" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My
                        Payments</a>
                    <a href="/user/reset-password" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Reset
                        Password</a>
                    <a href="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                    <button id="" onclick="userLogout()"
                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        Logout</button>
                </div>
            </div>
            <button id="authBtn" onclick="handleAuthButton()"
                class="w-full text-left px-6 py-2 text-sm text-white-600 bg-blue-500 hover:bg-gray-700">
                {{-- Login --}}
            </button>
        </div>

    </div>


 <div class="p-6 max-w-7xl mx-auto">
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
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const successMessage = localStorage.getItem('login_success');
                // const customer_id = localStorage.getItem('customer_id');
                // console.log(customer_id+":Customer Id")
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
            const authBtn = document.getElementById('authBtn');
            const profile = document.getElementById("profileIcon");

            if (token) {
                // authBtn.textContent = 'Logout';
                // authBtn.setAttribute('onclick', 'userLogout()');
                authBtn.style.display = "none";

                profile.innerHTML = '<i class="fas fa-user-circle text-2xl"></i>';
                profile.setAttribute('onclick', 'toggleProfileDropdown()');
                // profile.setAttribute
                // profile.setAttribute('onclick', alert("profile"));
            } else {
                authBtn.textContent = 'Login';
                authBtn.setAttribute('onclick', 'redirectToLogin()');
                profile.style.display = "none";
                document.getElementById('profileDropdown').classList.add('hidden');
            }
        });

        function redirectToLogin() {
            window.location.href = '/authuser/login';
        }
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Optional: Close dropdown when clicking outside
        document.addEventListener('click', function (event) {
            const profileIcon = document.getElementById('profileIcon');
            const dropdown = document.getElementById('profileDropdown');

            if (!profileIcon.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

    </script>
    <script src="{{ asset('js/showpopup.js')}}"></script>
    <script src="{{ asset('js/user-api/products.js')}}"></script>
    <script src="{{ asset('js/user/logout-user-api.js')}}"></script>


</body>

</html>