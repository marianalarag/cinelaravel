<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles de Función') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Alertas -->
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <span class="text-green-800">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if($showtime)
                        <!-- Información Principal -->
                        <div class="mb-8">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">{{ $showtime->movie->title }}</h1>
                                    <p class="text-gray-600">Función programada para {{ $showtime->start_time->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        {{ $showtime->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        <span class="w-2 h-2 rounded-full mr-2
                                            {{ $showtime->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        {{ $showtime->is_active ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Información de la Película -->
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de la Película</h3>
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <i class="fas fa-film text-gray-400 w-5 mr-3"></i>
                                            <div>
                                                <p class="text-sm text-gray-600">Título</p>
                                                <p class="font-semibold text-gray-900">{{ $showtime->movie->title }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-clock text-gray-400 w-5 mr-3"></i>
                                            <div>
                                                <p class="text-sm text-gray-600">Duración</p>
                                                <p class="font-semibold text-gray-900">{{ $showtime->movie->duration }} minutos</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-tags text-gray-400 w-5 mr-3"></i>
                                            <div>
                                                <p class="text-sm text-gray-600">Género</p>
                                                <p class="font-semibold text-gray-900">{{ $showtime->movie->genre }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-star text-gray-400 w-5 mr-3"></i>
                                            <div>
                                                <p class="text-sm text-gray-600">Clasificación</p>
                                                <p class="font-semibold text-gray-900">{{ $showtime->movie->rating ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información de la Función -->
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de la Función</h3>
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <i class="fas fa-theater-masks text-gray-400 w-5 mr-3"></i>
                                            <div>
                                                <p class="text-sm text-gray-600">Sala</p>
                                                <p class="font-semibold text-gray-900">{{ $showtime->hall->name ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar text-gray-400 w-5 mr-3"></i>
                                            <div>
                                                <p class="text-sm text-gray-600">Fecha y Hora</p>
                                                <p class="font-semibold text-gray-900">
                                                    {{ $showtime->start_time->format('d/m/Y H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-clock text-gray-400 w-5 mr-3"></i>
                                            <div>
                                                <p class="text-sm text-gray-600">Hora de Fin</p>
                                                <p class="font-semibold text-gray-900">
                                                    {{ $showtime->end_time->format('H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-dollar-sign text-gray-400 w-5 mr-3"></i>
                                            <div>
                                                <p class="text-sm text-gray-600">Precio</p>
                                                <p class="font-semibold text-gray-900">${{ number_format($showtime->price, 2) }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-chair text-gray-400 w-5 mr-3"></i>
                                            <div>
                                                <p class="text-sm text-gray-600">Asientos</p>
                                                <p class="font-semibold text-gray-900">
                                                    {{ $showtime->available_seats }} / {{ $showtime->hall->capacity ?? 'N/A' }} disponibles
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reservas de esta Función -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Reservas para esta Función</h3>
                            @if($showtime->bookings->count() > 0)
                                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Cliente
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Entradas
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Total
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Estado
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Fecha Reserva
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($showtime->bookings as $booking)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $booking->user->email }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $booking->number_of_tickets }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        ${{ number_format($booking->total_amount, 2) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                                {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                                                   ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                                                   'bg-red-100 text-red-800') }}">
                                                                {{ ucfirst($booking->status) }}
                                                            </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $booking->created_at->format('d/m/Y H:i') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8 bg-gray-50 rounded-lg">
                                    <i class="fas fa-ticket-alt text-gray-400 text-3xl mb-3"></i>
                                    <p class="text-gray-600">No hay reservas para esta función.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Acciones -->
                        <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                            <div class="flex space-x-3">
                                <a href="{{ route('staff.showtimes.index') }}"
                                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Volver al Listado
                                </a>

                                <a href="{{ route('staff.showtimes.edit', $showtime) }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-edit mr-2"></i>
                                    Editar Función
                                </a>
                            </div>

                            <div class="flex space-x-3">
                                <form action="{{ route('staff.showtimes.toggle-status', $showtime) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2
                                                {{ $showtime->is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }}
                                                border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <i class="fas {{ $showtime->is_active ? 'fa-times' : 'fa-check' }} mr-2"></i>
                                        {{ $showtime->is_active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>

                                <form action="{{ route('staff.showtimes.destroy', $showtime) }}" method="POST" class="inline"
                                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta función? Esta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-900 focus:bg-red-900 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <i class="fas fa-trash mr-2"></i>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Función no encontrada</h3>
                            <p class="text-gray-600 mb-4">La función que buscas no existe.</p>
                            <a href="{{ route('staff.showtimes.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Volver al Listado
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
