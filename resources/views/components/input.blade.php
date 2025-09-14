<div>
    <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
    {{-- <input {{ $attributes->merge(['class' => 'border p-2 rounded w-full']) }}> --}}
    <input {{ $attributes }} id="{{ $attributes->get('id') ?? $attributes->get('name') }}"
        name="{{ $attributes->get('name') }}" type="{{ $type ?? 'text' }}" />
</div>