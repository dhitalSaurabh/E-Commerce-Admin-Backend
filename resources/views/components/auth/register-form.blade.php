<form method="POST" action="{{ route('register') }}" class="space-y-4">
    @csrf
<x-input type="name" name="name" placeholder="Name" required />
    @error('name')
        <div class="text-red-500 text-sm">{{ $message }}</div>
    @enderror
    <x-input type="email" name="email" placeholder="Email" required />
    @error('email')
        <div class="text-red-500 text-sm">{{ $message }}</div>
    @enderror

    <x-input type="password" name="password" placeholder="Password" required />
    @error('password')
        <div class="text-red-500 text-sm">{{ $message }}</div>
    @enderror
    <x-input type="password" name="password_confirmation" placeholder="Confirm Password" required />
    @error('password')
        <div class="text-red-500 text-sm">{{ $message }}</div>
    @enderror

    <x-button type="submit">Register</x-button>
</form>
