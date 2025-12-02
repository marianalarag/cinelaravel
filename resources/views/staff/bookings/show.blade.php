<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles de Reserva') }}
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

                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                                <span class="text-red-800">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @if($booking)
                        <!-- Información Principal -->
                        <div class="mb-8">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">Reserva #{{ $booking->id }}</h1>
                                    <p class="text-gray-600">Creada el {{ $booking->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                           ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                           'bg-red-100 text-red-800') }}">
                                        <span class="w-2 h-2 rounded-full mr-2
                                            {{ $booking->status === 'confirmed' ? 'bg-green-500' :
                                               ($booking->status === 'pending' ? 'bg-yellow-500' :
                                               'bg-red-500') }}"></span>
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Información de la Película -->
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de la Función</h3>
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <i class="fas fa-film text-gray-400 w-5 mr-3"></i>
                                            <div>
                                                <p class="text-sm text-gray-600">Película</p>
                                                <p class="font-semibold text-gray-900">{{ $booking->showtime->movie->title }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar text-gray-400 w-5 mr-3"></i>
                                            <div>
                                                <p class="text-sm text-gray-600">Fecha y Hora</p>
                                                <p class="font-semibold text-gray-900">
                                                    {{ $booking->showtime->start_time->format('d/m/Y H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-theater-masks text-gray-400 w-5 mr-3"></i>
                                            <div>
                                                <p class="text-sm text-gray-600">Sala</p>
                                                <p class="font-semibold text-gray-900">{{ $booking->showtime->hall->name ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-clock text-gray-400 w-5 mr-3"></i>
                                            <div>
                                                <p class="text-sm text-gray-600">Duración</p>
                                                <p class="font-semibold text-gray-900">{{ $booking->showtime->movie->duration }} min</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información de la Reserva -->
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de la Reserva</h3>
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <i class="fas fa-user text-gray-400 w-5 mr-3"></i>
                                            <div>
                                                <p class="text-sm text-gray-600">Cliente</p>
                                                <p class="font-semibold text-gray-900">{{ $booking->user->name }}</p>
                                                <p class="text-sm text-gray-600">{{ $booking->user->email }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-ticket-alt text-gray-400 w-5 mr-3"></i>
                                            <div>
                                                <p class="text-sm text-gray-600">Número de Entradas</p>
                                                <p class="font-semibold text-gray-900">{{ $booking->number_of_tickets }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-dollar-sign text-gray-400 w-5 mr-3"></i>
                                            <div>
                                                <p class="text-sm text-gray-600">Precio Total</p>
                                                <p class="font-semibold text-gray-900">${{ number_format($booking->total_amount, 2) }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-info-circle text-gray-400 w-5 mr-3"></i>
                                            <div>
                                                <p class="text-sm text-gray-600">Asientos Disponibles</p>
                                                <p class="font-semibold text-gray-900">
                                                    {{ $booking->showtime->available_seats }} / {{ $booking->showtime->hall->capacity ?? 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                            <div class="flex space-x-3">
                                <a href="{{ route('staff.bookings.index') }}"
                                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Volver al Listado
                                </a>

                                <!-- BOTÓN CREAR NUEVA RESERVA - AGREGAR ESTO -->
                                <a href="{{ route('staff.bookings.create') }}"
                                   class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-plus mr-2"></i>
                                    Nueva Reserva
                                </a>

                                <a href="{{ route('staff.bookings.edit', $booking) }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-edit mr-2"></i>
                                    Editar Reserva
                                </a>
                            </div>

                            <div class="flex space-x-3">
                                @if($booking->status !== 'cancelled')
                                    <form action="{{ route('staff.bookings.toggle-status', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <i class="fas fa-times mr-2"></i>
                                            Cancelar Reserva
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('staff.bookings.destroy', $booking) }}" method="POST" class="inline"
                                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta reserva? Esta acción no se puede deshacer.')">
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
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Reserva no encontrada</h3>
                            <p class="text-gray-600 mb-4">La reserva que buscas no existe.</p>
                            <a href="{{ route('staff.bookings.index') }}"
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
