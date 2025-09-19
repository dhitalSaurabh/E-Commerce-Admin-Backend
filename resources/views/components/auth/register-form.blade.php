<form id="registerForm" method="POST" class="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded space-y-6">
    <h2 class="text-2xl font-bold text-center text-gray-800">Create an Account</h2>

    <!-- Name -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
        <x-input id="name" type="text" name="name" placeholder="Your full name" required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <x-input id="email" type="email" name="email" placeholder="you@example.com" required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <x-input id="password" type="password" name="password" placeholder="••••••••" required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Confirm Password -->
    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
        <x-input id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Submit Button -->
    <x-button type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
        Register
    </x-button>

    <!-- Error Message -->
    <div id="errorMessage" class="text-red-500 text-sm text-center mt-2"></div>
</form>