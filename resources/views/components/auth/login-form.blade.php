<form id="loginForm" method="POST"  class="space-y-4">
    {{-- @csrf --}}

    {{-- <x-input type="email" name="email" id="name" placeholder="Email" required class="border p-2 w-full" />
    @error('email')
    <div class="text-red-500 text-sm">{{ $message }}</div>
    @enderror

    <x-input type="password" name="password" id="password" placeholder="Password" required class="border p-2 w-full" />
    @error('password')
    <div class="text-red-500 text-sm">{{ $message }}</div>
    @enderror --}}
    <input id="email" name="email" type="email" placeholder="Email" />
    <input id="password" name="password" type="password" placeholder="Password" />

    <x-button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-4">Login</x-button>
    <div id="errorMessage" class="text-red-500 mt-2"></div>
</form>