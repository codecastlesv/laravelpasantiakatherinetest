<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 antialiased">
    <div class="flex items-center justify-center min-h-screen">
        <div class="max-w-xl w-full bg-gray-800 shadow-lg rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4v16a1 1 0 001 1h16a1 1 0 001-1V4M3 4h18m-8 4h4m-4 4h4m-4 4h4m-4 4h4" />
                    </svg>
                </div>
                <div class="ml-4 text-lg text-gray-200">
                    @yield('code')
                </div>
            </div>

            <div class="mt-4 text-gray-400">
                @yield('message')
            </div>

            <div class="mt-6">
                <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Volver
                </a>
            </div>
        </div>
    </div>
</body>
</html>
