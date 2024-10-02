<div class="mb-4 py-4">
    <label for="{{ $id ?? $name }}" class="block text-gray-400 text-sm font-bold mb-2">
        {{ $label }}
    </label>
    <input id="{{ $id ?? $name }}" name="{{ $name }}" type="{{ $type ?? 'text' }}"
        value="{{ $value ?? old($name) }}"
        class="w-full p-3 bg-gray-900 text-white border border-gray-700 rounded focus:outline-none 
        focus:ring-2 focus:ring-gray-600 required"
        {{ $attributes }} />
    @error($name)
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
