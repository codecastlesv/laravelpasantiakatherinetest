<div class="flex flex-col">
    <label for="{{ $name }}" class="block text-gray-400 text-sm font-bold mb-2">
        {{ $label ?? ucfirst($name) }}
    </label>
    <textarea id="{{ $name }}" name="{{ $name }}" cols="{{ $cols ?? 50 }}" rows="{{ $rows ?? 20 }}"
        value="{{ $value ?? old($name) }}"
        class="w-full p-3 bg-gray-900 text-white border border-gray-700 rounded focus:outline-none 
        focus:ring-2 focus:ring-gray-600"
        style="min-height: {{ $minHeight ?? '100px' }}; max-height: {{ $maxHeight ?? '300px' }}; resize: {{ $resize ?? 'vertical' }};"
        {{ $attributes }}>
    </textarea>
    @error($name)
        <div class="text-red-500 text-sm">{{ $message }}</div>
    @enderror
</div>
