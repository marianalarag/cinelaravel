<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Funciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alertas -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-green-800">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <span class="text-red-800">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Header con estadísticas y botones -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Funciones Programadas</h1>
                    <p class="text-gray-600">Gestiona todas las funciones del cine</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('staff.showtimes.today') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-calendar-day mr-2"></i>
                        Hoy
                    </a>
                    <a href="{{ route('staff.showtimes.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-plus mr-2"></i>
                        Nueva Función
                    </a>
                </div>
            </div>

            <!-- Tarjetas de estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-sm border p-4">
                    <div class="flex items-center">
                        <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-film"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-500">Total Funciones</h3>
                            <p class="text-xl font-bold text-gray-900">{{ $showtimes->total() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border p-4">
                    <div class="flex items-center">
                        <div class="p-2 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-500">Activas</h3>
                            <p class="text-xl font-bold text-gray-900">
                                {{ $showtimes->where('is_active', true)->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border p-4">
                    <div class="flex items-center">
                        <div class="p-2 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-500">Próximas</h3>
                            <p class="text-xl font-bold text-gray-900">
                                {{ $showtimes->where('start_time', '>', now())->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border p-4">
                    <div class="flex items-center">
                        <div class="p-2 rounded-full bg-red-100 text-red-600">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-500">Inactivas</h3>
                            <p class="text-xl font-bold text-gray-900">
                                {{ $showtimes->where('is_active', false)->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de funciones -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($showtimes->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Película
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha y Hora
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sala
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Precio
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Asientos
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($showtimes as $showtime)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                                    @if($showtime->movie->poster_url)
                                                        <img src="{{ $showtime->movie->poster_url }}"
                                                             alt="{{ $showtime->movie->title }}"
                                                             class="h-10 w-10 rounded object-cover"
                                                             onerror="this.style.display='none'">
                                                    @endif
                                                    @if(!$showtime->movie->poster_url)
                                                        <i class="fas fa-film text-gray-400"></i>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ Str::limit($showtime->movie->title, 30) }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $showtime->movie->duration }} min
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $showtime->start_time->format('d/m/Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $showtime->start_time->format('H:i') }} - {{ $showtime->end_time->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @php
                                                $sala = $showtime->hall->name ?? $showtime->room->name ?? $showtime->sala->name ?? 'N/A';
                                            @endphp
                                            Sala {{ $sala }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ${{ number_format($showtime->price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @php
                                                $capacity = $showtime->hall->capacity ?? $showtime->room->capacity ?? $showtime->sala->capacity ?? 'N/A';
                                            @endphp
                                            {{ $showtime->available_seats }} / {{ $capacity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $showtime->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    <span class="w-2 h-2 rounded-full mr-1
                                                        {{ $showtime->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                                    {{ $showtime->is_active ? 'Activa' : 'Inactiva' }}
                                                </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <!-- Ver detalles -->
                                                <a href="{{ route('staff.showtimes.show', $showtime) }}"
                                                   class="text-blue-600 hover:text-blue-900 transition-colors p-1 rounded hover:bg-blue-50"
                                                   title="Ver detalles">
                                                    <i class="fas fa-eye w-4 h-4"></i>
                                                </a>

                                                <!-- Editar -->
                                                <a href="{{ route('staff.showtimes.edit', $showtime) }}"
                                                   class="text-indigo-600 hover:text-indigo-900 transition-colors p-1 rounded hover:bg-indigo-50"
                                                   title="Editar">
                                                    <i class="fas fa-edit w-4 h-4"></i>
                                                </a>

                                                <!-- Cambiar Estado -->
                                                <form action="{{ route('staff.showtimes.toggle-status', $showtime) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                            class="text-green-600 hover:text-green-900 transition-colors p-1 rounded hover:bg-green-50"
                                                            title="{{ $showtime->is_active ? 'Desactivar' : 'Activar' }}">
                                                        <i class="fas {{ $showtime->is_active ? 'fa-times' : 'fa-check' }} w-4 h-4"></i>
                                                    </button>
                                                </form>

                                                <!-- Eliminar -->
                                                <form action="{{ route('staff.showtimes.destroy', $showtime) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta función?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-900 transition-colors p-1 rounded hover:bg-red-50"
                                                            title="Eliminar">
                                                        <i class="fas fa-trash w-4 h-4"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="mt-6">
                            {{ $showtimes->links() }}
                        </div>
                    @else
                        <!-- Estado vacío -->
                        <div class="text-center py-12">
                            <div class="bg-gradient-to-br from-blue-100 to-purple-100 rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                                <i class="fas fa-film text-blue-400 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay funciones programadas</h3>
                            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                                Comienza creando la primera función para que los clientes puedan hacer reservas.
                            </p>
                            <a href="{{ route('staff.showtimes.create') }}"
                               class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-plus mr-2"></i>
                                Crear Primera Función
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
