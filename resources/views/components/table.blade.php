<table class="min-w-full dark:bg-gray-800 p-4 rounded-lg shadow-md">
    <thead class="bg-gray-50">
        <tr class="bg-gray-100 dark:bg-gray-800 text-white">
            {{ $headers }}
        </tr>
    </thead>
    <tbody class="text-slate-300 rounded-lg shadow-md p-4 dark:bg-gray-800">
        {{ $slot }}
    </tbody>
</table>
