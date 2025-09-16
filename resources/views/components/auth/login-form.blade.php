
<form id="loginForm" method="POST" class="max-w-sm mx-auto mt-10 p-6 bg-white shadow-md rounded space-y-6">
    <h2 class="text-2xl font-bold text-center text-gray-800">Login to Your Account</h2>

    <!-- Email Input -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input
            id="email"
            name="email"
            type="email"
            placeholder="you@example.com"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
    </div>

    <!-- Password Input -->
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input
            id="password"
            name="password"
            type="password"
            placeholder="••••••••"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
    </div>

    <!-- Submit Button -->
    <x-button
        type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200"
    >
        Login
    </x-button>

    <!-- Error Message -->
    <div id="errorMessage" class="text-red-500 text-sm text-center mt-2"></div>
</form>
