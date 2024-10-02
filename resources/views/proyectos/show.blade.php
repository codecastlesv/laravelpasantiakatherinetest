<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex justify-center uppercase">
            {{ __('PROYECTO ') . $proyecto->nombre }}
        </h2>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </x-slot>
    <div class="flex justify-center bg-gray-100 dark:bg-gray-900 py-12">
        <div class="grid grid-cols-2 gap-4 w-full max-w-4xl text-lg text-slate-900 dark:text-slate-200">
            <div class="flex items-center">
                <span class="font-bold">Nombre:</span>
                <span class="ml-4">{{ $proyecto->nombre }}</span>
            </div>
            <div class="row-span-2 flex flex-col justify-start">
                <span class="font-bold">Descripción:</span>
                <p class="mt-2">
                    {{ $proyecto->descripcion }}
                </p>
            </div>
            <div class="flex items-center">
                <span class="font-bold">Fecha de inicio:</span>
                <span class="ml-4">{{ $proyecto->fecha_inicio }}</span>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-8 py-2 px-8">
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg">
            <div id="messageContainer" class="hidden"></div>
            <x-form id="tareaForm" action="{{ route('tareas.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="id" />
                <div class="flex flex-col">
                    <input type="hidden" name="proyecto_id" value="{{ $proyecto->id }}">
                    <x-input name="nombre" label="Nombre: " />
                    <x-textarea name="descripcion" label="Descripción" minHeight="100px" maxHeight="300px"
                        resize="vertical" />
                    <x-select name="estado" label="Estado">
                        @foreach (\App\Enums\EstadoTarea::cases() as $estado)
                            <option value="{{ $estado->value }}">{{ ucfirst($estado->value) }}</option>
                        @endforeach
                    </x-select>
                </div>
                <x-slot name="buttons">
                    <x-primary-button id="submitButton">
                        {{ __('Guardar') }}
                    </x-primary-button>
                    <x-danger-button id="updateButton" style="display: none;">
                        {{ __('Actualizar') }}
                    </x-danger-button>
                    <x-secondary-button id="cancelButton" style="display: none;">
                        {{ __('Cancelar') }}
                    </x-secondary-button>
                </x-slot>
            </x-form>
        </div>

        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg">
            @if ($tareas->isEmpty())
                <div class="p-4 text-center font-semibold text-xl text-gray-900 dark:text-gray-500">
                    {{ __('No hay tareas en este momento.') }}
                </div>
            @else
                <div class="mb-4 flex justify-end">
                    <form action="{{ url()->current() }}" method="GET">
                        <input type="text" name="query" placeholder="Buscar..." value="{{ request('query') }}"
                            class="input">
                        <x-primary-button>{{ __('Buscar') }}</x-primary-button>
                    </form>
                </div>
                <x-table>
                    <x-slot name="headers">
                        <th class="px-4 py-2 text-left">Tarea</th>
                        <th class="px-4 py-2 text-left">Descripción</th>
                        <th class="px-4 py-2 text-left">Estado</th>
                        <th class="px-4 py-2 text-center">Acciones</th>
                    </x-slot>
                    @foreach ($tareas as $tarea)
                        <tr>
                            <td class="border-b-2 border-gray-800 px-4 py-2">{{ ucfirst($tarea->nombre) }}</td>
                            <td class="w-1/4 border-b-2 border-gray-800 px-4 py-2">{{ ucfirst($tarea->descripcion) }}
                            </td>
                            <td class="border-b-2 border-gray-800 px-4 py-2">{{ ucfirst($tarea->estado->value) }}</td>
                            <td class="w-1/4 border-b-2 border-gray-800 px-4 py-2 text-center">
                                <button type="button"
                                    class="editButton inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase 
                                    tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition 
                                    ease-in-out duration-150 bg-emerald-800 hover:bg-emerald-700 active:bg-emerald-900 focus:ring-indigo-500"
                                    data-id="{{ $tarea->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('tareas.destroy', $tarea->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase 
                                    tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition 
                                    ease-in-out duration-150 bg-red-800 hover:bg-red-700 active:bg-red-900 focus:ring-indigo-500"><i
                                            class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
                <x-paginate :items="$tareas">
                </x-paginate>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/form-handler.js') }}"></script>

    <!-- Inicialización de funciones reutilizables -->
    <script>
        $(document).ready(function() {
            // Mapeo de campos para el formulario de proyecto
            const tareaFieldMap = {
                id: 'input[name="id"]',
                nombre: 'input[name="nombre"]',
                descripcion: 'textarea[name="descripcion"]',
                estado: 'select[name="estado"]',
                proyecto_id: 'input[name="proyecto_id"]',
            };

            handleEdit('.editButton', '#tareaForm', '/tareas', tareaFieldMap);
            handleUpdate('#updateButton', '#tareaForm', '/tareas');
            handleCancel('#cancelButton', '#tareaForm', '{{ route('tareas.store') }}');
            showSuccessMessage();
        });
    </script>
</x-app-layout>
