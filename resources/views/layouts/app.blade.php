<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin E-commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="flex">

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed md:static left-0 top-0 h-full w-64 bg-gray-900 text-white transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-40">
        <div class="p-5">
            <h2 class="text-xl font-bold mb-5">Admin Panel</h2>
            <a href="{{ url('/dashboard') }}" class="block p-2 rounded hover:bg-gray-700">Dashboard</a>
            {{-- <strong class="block mb-2">Category</strong> --}}
            <a href="{{ url('/categories/category') }}" class="block p-2 rounded hover:bg-gray-700">Category</a>
            {{-- <strong class="block mb-2">Products</strong> --}}
            <a href="{{ url('/products/product') }}" class="block p-2 rounded hover:bg-gray-700">Product</a>
            <a href="{{ url('/products/clothes') }}" class="block p-2 rounded hover:bg-gray-700">Clothes</a>
            <a href="{{ url('/products/shoes') }}" class="block p-2 rounded hover:bg-gray-700">Shoes</a>
            <a href="{{ url('/products/bags') }}" class="block p-2 rounded hover:bg-gray-700">Bags</a>
            <a href="{{ url('/products/wallets') }}" class="block p-2 rounded hover:bg-gray-700">Wallets</a>

            <strong class="block mt-4 mb-2">Orders</strong>
            <a href="{{ url('/orders') }}" class="block p-2 rounded hover:bg-gray-700">View Orders</a>

            <strong class="block mt-4 mb-2">Users</strong>
            <a href="{{ url('/users') }}" class="block p-2 rounded hover:bg-gray-700">View Users</a>

            <strong class="block mt-4 mb-2">Payments</strong>
            <a href="{{ url('/payments/status') }}" class="block p-2 rounded hover:bg-gray-700">Payment Status</a>

            <strong class="block mt-4 mb-2">Inventory</strong>
            <a href="{{ url('/stocks') }}" class="block p-2 rounded hover:bg-gray-700">Stock Details</a>
        </div>
    </aside>

    <!-- Overlay (for small screens) -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-30 md:hidden"></div>
    <!-- Main Content -->
    <main class="flex-1 p-6 bg-gray-100 w-full">
        <!-- Menu Button -->
        <div class="flex justify-end md:hidden mb-4">
            <button id="menuBtn" class="p-2 bg-gray-900 text-white rounded">
                ☰ Menu
            </button>
        </div>
@hasSection ('content')
    @yield('content')
@else
   <h1>Welcome to the E-commerce Admin Dashboard</h1>
            <p>Use the sidebar to manage products, orders, users, and more.</p> 
@endif
        
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const menuBtn = document.getElementById('menuBtn');
        const overlay = document.getElementById('overlay');

        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
</body>

</html>