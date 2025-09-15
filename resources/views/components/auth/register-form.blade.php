<form id="registerForm" method="POST" class="space-y-4">

    <x-input type="name" name="name" placeholder="Name" required />
    <x-input type="email" name="email" placeholder="Email" required />
    <x-input type="password" name="password" placeholder="Password" required />
    <x-input type="password" name="password_confirmation" placeholder="Confirm Password" required />

    <x-button type="submit">Register</x-button>
    <div id="errorMessage" class="text-red-500 mt-2"></div>
</form>