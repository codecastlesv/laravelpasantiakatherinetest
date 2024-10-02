@props(['accion' => 'alert', 'ruta' => '#'])

@php
    $bgColor = match ($accion) {
        'show' => 'bg-sky-800 dark:bg-sky-200 dark:text-sky-800 hover:bg-sky-700 dark:hover:bg-white focus:bg-sky-700 
            dark:focus:bg-white active:bg-sky-900 dark:active:bg-sky-300 focus:ring-indigo-500',
        'edit' => 'bg-emerald-800 hover:bg-emerald-700 active:bg-emerald-900 focus:ring-indigo-500',
        'delete' => 'bg-red-600 hover:bg-red-500 active:bg-red-700 focus:ring-red-500',
        default
            => 'bg-gray-800 dark:bg-gray-200 dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 
            dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:ring-indigo-500',
    };
@endphp
    <a href="{{ $ruta }}" type = "submit"
        class = "inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase 
            tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition 
            ease-in-out duration-150 {{ $bgColor }}">
        {{ $slot }}
    </a>
