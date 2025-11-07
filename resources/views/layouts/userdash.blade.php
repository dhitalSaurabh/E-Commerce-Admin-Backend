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

<body class="bg-gray-50">

<!-- ✅ Beautiful E-commerce Navbar -->
<nav class="bg-white shadow-sm fixed w-full top-0 left-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">
      
      <!-- 🛍️ Logo -->
      <div class="flex-shrink-0 flex items-center">
        <a href="/" class="text-2xl font-bold text-blue-600 hover:text-gray-700">
          <i class="fas fa-shopping-bag mr-2"></i>E-Shop
        </a>
      </div>

      <!-- 🌐 Navigation Links -->
      <div class="hidden md:flex space-x-8">
        <a href="/" class="text-gray-700 hover:text-blue-600 font-medium">Home</a>
        <a href="/" class="text-gray-700 hover:text-blue-600 font-medium">Products</a>
        <a href="/contact" class="text-gray-700 hover:text-blue-600 font-medium">Contact</a>
      </div>

      <!-- 👤 Profile + Login Section -->
      <div class="flex items-center gap-x-4">
        <!-- Profile Icon -->
        <div class="relative">
          <a id="profileIcon" onclick="toggleProfileDropdown()" href="javascript:void(0);"
            class="text-blue-600 hover:text-gray-800 text-2xl transition duration-300">
            <i class="fas fa-user-circle"></i>
          </a>

          <!-- Profile Dropdown -->
          <div id="profileDropdown"
            class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-50">
            <div class="block">
              <a href="/" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Home</a>
              <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
              <a href="/mycarts" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Carts</a>
              <a href="/my-orders" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Orders</a>
              <a href="/my-payments" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Payments</a>
              <a href="/user/reset-password"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Reset Password</a>
              <a href="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
              <button onclick="userLogout()"
                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
            </div>
          </div>
        </div>

        <!-- Login Button -->
        <button id="authBtn" onclick="handleAuthButton()"
          class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-md transition">
          Login
        </button>

        <!-- Mobile Menu Button -->
        <button id="mobileMenuButton" class="md:hidden text-gray-700 hover:text-blue-600 focus:outline-none">
          <i class="fas fa-bars text-2xl"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- 📱 Mobile Menu -->
  <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-gray-200">
    <div class="px-4 py-2 space-y-2">
      <a href="/" class="block text-gray-700 hover:text-blue-600 font-medium">Home</a>
      <a href="/products" class="block text-gray-700 hover:text-blue-600 font-medium">Products</a>
      <a href="/contact" class="block text-gray-700 hover:text-blue-600 font-medium">Contact</a>
      <button onclick="handleAuthButton()"
        class="block w-full text-left text-blue-600 font-medium hover:text-blue-800">Login</button>
    </div>
  </div>
</nav>

  <!-- Add padding since header is fixed -->
  <div class="pt-20"></div>

  <div class="p-6 max-w-7xl mx-auto">
    @if(session('error'))
      <div class="bg-red-100 text-red-700 p-3 mb-4 rounded"> {{ session('error') }}
    </div> @endif @hasSection ('content')
      @yield('content')
    @else 
    <h1>Welcome to the E-commerce Admin Dashboard</h1>
    <p>Use the sidebar to manage products, orders, users, and more.</p>
     @endif 
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const token = localStorage.getItem('token');
      const authBtn = document.getElementById('authBtn');
      const profileIcon = document.getElementById('profileIcon');

      if (token) {
        authBtn.style.display = 'none';
        profileIcon.style.display = 'block';
      } else {
        authBtn.style.display = 'block';
        profileIcon.style.display = 'none';
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

    // Close dropdown when clicking outside
    document.addEventListener('click', function (event) {
      const profileIcon = document.getElementById('profileIcon');
      const dropdown = document.getElementById('profileDropdown');
      if (!profileIcon.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.classList.add('hidden');
      }
    });

    function handleAuthButton() {
      redirectToLogin();
    }

    function userLogout() {
      localStorage.removeItem('token');
      alert("Logged out!");
      location.reload();
    }
  </script>
  <script src="{{ asset('js/showpopup.js')}}"></script>
  <script src="{{ asset('js/user-api/products.js')}}"></script>
  <script src="{{ asset('js/user/logout-user-api.js')}}"></script>


</body>

</html>