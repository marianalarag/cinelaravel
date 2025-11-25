<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Funciones de Hoy') }}
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

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-sm border p-4">
                    <div class="flex items-center">
                        <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-film"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-500">Total Funciones Hoy</h3>
                            <p class="text-xl font-bold text-gray-900">{{ $todayShowtimes->total() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border p-4">
                    <div class="flex items-center">
                        <div class="p-2 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-500">Funciones Activas</h3>
                            <p class="text-xl font-bold text-gray-900">
                                {{ $todayShowtimes->where('is_active', true)->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border p-4">
                    <div class="flex items-center">
                        <div class="p-2 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-500">Total Asientos Ocupados</h3>
                            <p class="text-xl font-bold text-gray-900">
                                @php
                                    $totalCapacity = $todayShowtimes->sum(function($showtime) {
                                        return $showtime->hall->capacity ?? 0;
                                    });
                                    $totalAvailable = $todayShowtimes->sum('available_seats');
                                    $totalOccupied = max(0, $totalCapacity - $totalAvailable); // Usar max() para evitar negativos
                                @endphp
                                {{ $totalOccupied }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de Funciones de Hoy -->
            @if($todayShowtimes->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-900">Funciones Programadas para Hoy</h3>
                            <div class="text-sm text-gray-600">
                                {{ now()->format('d/m/Y') }}
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Película
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Horario
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sala
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Asientos
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Precio
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
                                @foreach($todayShowtimes as $showtime)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                                    @if($showtime->movie->poster_url)
                                                        <img class="h-10 w-10 rounded object-cover"
                                                             src="{{ $showtime->movie->poster_url }}"
                                                             alt="{{ $showtime->movie->title }}"
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
                                                {{ $showtime->start_time->format('H:i') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                a {{ $showtime->end_time->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $showtime->hall->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $showtime->available_seats }} / {{ $showtime->hall->capacity ?? 'N/A' }}
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                @php
                                                    $capacity = $showtime->hall->capacity ?? 1;
                                                    $occupied = $capacity - $showtime->available_seats;
                                                    $percentage = ($occupied / $capacity) * 100;
                                                @endphp
                                                <div class="bg-green-600 h-2 rounded-full"
                                                     style="width: {{ $percentage }}%"></div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ${{ number_format($showtime->price, 2) }}
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
                                                <!-- Ver Detalles -->
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

                                                <!-- Ver Reservas -->
                                                <a href="{{ route('staff.bookings.index') }}?showtime={{ $showtime->id }}"
                                                   class="text-purple-600 hover:text-purple-900 transition-colors p-1 rounded hover:bg-purple-50"
                                                   title="Ver reservas">
                                                    <i class="fas fa-ticket-alt w-4 h-4"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="mt-6">
                            {{ $todayShowtimes->links() }}
                        </div>
                    </div>
                </div>
            @else
                <!-- Estado cuando no hay funciones hoy -->
                <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="bg-gradient-to-br from-blue-100 to-purple-100 rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                            <i class="fas fa-film text-blue-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay funciones programadas para hoy</h3>
                        <p class="text-gray-600 mb-6">
                            No hay funciones programadas para el día de hoy.
                            Puedes crear nuevas funciones desde el listado principal.
                        </p>
                        <div class="flex flex-col sm:flex-row justify-center gap-3">
                            <a href="{{ route('staff.showtimes.index') }}"
                               class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-list mr-2"></i>
                                Ver Todas las Funciones
                            </a>
                            <a href="{{ route('staff.showtimes.create') }}"
                               class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-plus mr-2"></i>
                                Crear Nueva Función
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
