<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-center">
            {{ __('PROYECTOS') }}
        </h2>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </x-slot>

    <div class="grid grid-cols-2 gap-8 py-2 px-8">
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg">
            <div id="messageContainer" class="hidden"></div>
            <x-form id="proyectoForm" action="{{ route('proyectos.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="id" />
                <div class="flex flex-col">
                    <x-input name="nombre" label="Nombre: " />
                    <x-textarea name="descripcion" label="Descripción" minHeight="100px" maxHeight="300px"
                        resize="vertical" />
                    <x-input name="fecha_inicio" label="Fecha de inicio: " type="date" class="flex items-center" />
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
            @if ($proyectos->isEmpty())
                <div class="p-4 text-center font-semibold text-xl text-gray-900 dark:text-gray-500">
                    {{ __('No hay proyectos en este momento.') }}
                </div>
            @else
                <div class="mb-4 flex justify-end">
                    <form action="{{ url()->current() }}" method="GET">
                        <input type="text" name="query" placeholder="Buscar..." value="{{ request('query') }}" class="input">
                        <x-primary-button>{{ __('Buscar') }}</x-primary-button>
                    </form>
                </div>

                <x-table>
                    <x-slot name="headers">
                        <th class="px-4 py-2 text-left">Nombre</th>
                        <th class="px-4 py-2 text-left">Descripción</th>
                        <th class="px-4 py-2 text-left">Fecha Inicio</th>
                        <th class="px-4 py-2 text-center">Acciones</th>
                    </x-slot>
                    @foreach ($proyectos as $proyecto)
                        <tr>
                            <td class="border-b-2 border-gray-800 px-4 py-2">{{ ucfirst($proyecto->nombre) }}</td>
                            <td class="w-1/4 border-b-2 border-gray-800 px-4 py-2">{{ ucfirst($proyecto->descripcion) }}
                            </td>
                            <td class="border-b-2 border-gray-800 px-4 py-2">{{ $proyecto->fecha_inicio }}</td>
                            <td class="w-1/4 border-b-2 border-gray-800 px-4 py-2 text-center">
                                <x-button-action accion="show" :ruta="route('proyectos.show', $proyecto->id)">
                                    <i class="fas fa-eye"></i>
                                </x-button-action>
                                <button type="button"
                                    class="editButton inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase 
                                tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition 
                                ease-in-out duration-150 bg-emerald-800 hover:bg-emerald-700 active:bg-emerald-900 focus:ring-indigo-500"
                                    data-id="{{ $proyecto->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('proyectos.destroy', $proyecto->id) }}" method="POST"
                                    class="inline">
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
                <x-paginate :items="$proyectos">
                </x-paginate>
            @endif
        </div>
    </div>

    <!-- JS para el form -->
    <script src="{{ asset('js/form-handler.js') }}"></script>
    
    <!-- Inicialización de funciones  -->
    <script>
        $(document).ready(function() {
            // Mapeo de campos para el formulario de proyecto
            const proyectoFieldMap = {
                id: 'input[name="id"]',
                nombre: 'input[name="nombre"]',
                descripcion: 'textarea[name="descripcion"]',
                fecha_inicio: 'input[name="fecha_inicio"]',
            };

            preventDoubleSubmit('#proyectoForm', '#submitButton');
            handleEdit('.editButton', '#proyectoForm', '/proyectos', proyectoFieldMap);
            handleUpdate('#updateButton', '#proyectoForm', '/proyectos');
            handleCancel('#cancelButton', '#proyectoForm', '{{ route('proyectos.store') }}');
            showSuccessMessage();
        });
    </script>
</x-app-layout>
