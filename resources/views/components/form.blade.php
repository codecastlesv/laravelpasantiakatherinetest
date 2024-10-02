<div class="mx-auto bg-gray-800 p-4 rounded-lg shadow-md">
    <form {{ $attributes }}>
        @csrf
        {{ $slot }}
        <div class="flex justify-end">
            {{ $buttons ?? '' }}
        </div>
    </form>
</div>
