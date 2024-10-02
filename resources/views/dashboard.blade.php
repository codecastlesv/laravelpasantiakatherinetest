<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl flex justify-center text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('INICIO') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="p-4 flex justify-center">
                        {{ __('¡HOLA ') }} {{ strtoupper(auth()->user()->name) }} {{ __('! HOY ES ') }}
                        {{ date('d') }} DE {{ strtoupper(strftime('%B', time())) }} DEL {{ strtoupper(date('Y')) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($proyectosPendientes->isEmpty())
                        <div class="p-4 text-center font-semibold text-xl text-gray-900 dark:text-gray-100">
                            {{ __('No hay proyectos pendientes en este momento.') }}
                        </div>
                    @else
                        <div class="p-4 font-semibold text-xl flex justify-center">
                            {{ __('PROYECTOS PENDIENTES') }}
                        </div>
                        <x-table>
                            <x-slot name="headers">
                                <th class="px-4 py-2 text-left">Nombre</th>
                                <th class="px-4 py-2 text-left">Descripción</th>
                                <th class="px-4 py-2 text-left">Fecha Inicio</th>
                                <th class="px-4 py-2 text-left">Estado</th>
                            </x-slot>
                            @foreach ($proyectosPendientes as $proyecto)
                                <tr>
                                    <td class="border-b-2 border-gray-800 px-4 py-2">{{ ucfirst($proyecto->nombre) }}
                                    </td>
                                    <td class="w-1/4 border-b-2 border-gray-800 px-4 py-2">
                                        {{ ucfirst($proyecto->descripcion) }}</td>
                                    <td class="border-b-2 border-gray-800 px-4 py-2">
                                        {{ ucfirst($proyecto->fecha_inicio) }}</td>
                                    <td class="border-b-2 border-gray-800 px-4 py-2">{{ $proyecto->estado }}</td>
                                </tr>
                            @endforeach
                        </x-table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
