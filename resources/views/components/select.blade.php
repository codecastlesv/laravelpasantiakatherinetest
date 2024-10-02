<div class="flex flex-col mb-4">
    <label for="{{ $id ?? $name }}" class="block text-gray-400 text-sm font-bold mt-4 mb-2">
        {{ $label }}
    </label>
    <select id="{{ $id ?? $name }}" name="{{ $name }}"
        class="w-full p-3 bg-gray-900 text-white border border-gray-700 rounded focus:outline-none 
        focus:ring-2 focus:ring-gray-600"
        {{ $attributes }}>
        {{ $slot }}
    </select>
</div>
