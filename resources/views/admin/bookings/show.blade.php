<x-admin-layout
    title="Detalles de Reserva - CineLaravel"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Reservas', 'href' => route('admin.bookings.index')],
        ['name' => 'Detalles']
    ]"
    headerTitle="Detalles de Reserva"
    headerDescription="Información detallada de la reserva"
>
    <x-slot name="actions">
        <a href="{{ route('admin.bookings.edit', $booking) }}"
           class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md inline-flex items-center text-sm font-medium transition-colors shadow-sm mr-2">
            <i class="fas fa-edit w-4 h-4 mr-2"></i>
            Editar
        </a>
        <a href="{{ route('admin.bookings.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md inline-flex items-center text-sm font-medium transition-colors shadow-sm">
            <i class="fas fa-arrow-left w-4 h-4 mr-2"></i>
            Volver
        </a>
    </x-slot>

    <!-- Alertas -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400 text-lg"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </h3>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información Principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Información de la Reserva -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-ticket-alt text-blue-500 mr-2"></i>
                    Información de la Reserva
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Estado -->
                    <div>
                        <label class="text-sm font-medium text-gray-500">Estado</label>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-800' :
                                   ($booking->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                <span class="w-2 h-2 rounded-full mr-2
                                    {{ $booking->status == 'confirmed' ? 'bg-green-500' :
                                       ($booking->status == 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}"></span>
                                {{ $booking->status == 'confirmed' ? 'Confirmada' :
                                   ($booking->status == 'pending' ? 'Pendiente' : 'Cancelada') }}
                            </span>
                        </div>
                    </div>

                    <!-- Número de Tickets -->
                    <div>
                        <label class="text-sm font-medium text-gray-500">Número de Tickets</label>
                        <div class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $booking->number_of_tickets }}
                        </div>
                    </div>

                    <!-- Precio Total -->
                    <div>
                        <label class="text-sm font-medium text-gray-500">Precio Total</label>
                        <div class="mt-1 text-2xl font-bold text-green-600">
                            ${{ number_format($booking->total_price, 2) }}
                        </div>
                    </div>

                    <!-- Fecha de Reserva -->
                    <div>
                        <label class="text-sm font-medium text-gray-500">Fecha de Reserva</label>
                        <div class="mt-1 text-sm text-gray-900">
                            {{ $booking->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="text-xs text-gray-500">
                            Hace {{ $booking->created_at->diffForHumans() }}
                        </div>
                    </div>

                    <!-- Última Actualización -->
                    <div>
                        <label class="text-sm font-medium text-gray-500">Última Actualización</label>
                        <div class="mt-1 text-sm text-gray-900">
                            {{ $booking->updated_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="text-xs text-gray-500">
                            Hace {{ $booking->updated_at->diffForHumans() }}
                        </div>
                    </div>

                    <!-- ID de Reserva -->
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-500">ID de Reserva</label>
                        <div class="mt-1 font-mono text-sm text-gray-600 bg-gray-50 p-2 rounded">
                            #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Cliente -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user text-purple-500 mr-2"></i>
                    Información del Cliente
                </h3>

                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-xl">
                            {{ substr($booking->user->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-900">{{ $booking->user->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $booking->user->email }}</p>
                        <p class="text-xs text-gray-500 mt-1">ID: {{ $booking->user->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Información de la Función -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-film text-red-500 mr-2"></i>
                    Información de la Función
                </h3>

                <div class="flex space-x-4">
                    <!-- Poster de la Película -->
                    <div class="flex-shrink-0">
                        <div class="w-24 h-36 bg-gray-200 rounded-lg overflow-hidden">
                            @if($booking->showtime->movie->poster_url)
                                <img src="{{ $booking->showtime->movie->poster_url }}"
                                     alt="{{ $booking->showtime->movie->title }}"
                                     class="w-full h-full object-cover"
                                     onerror="this.style.display='none'">
                            @endif
                            @if(!$booking->showtime->movie->poster_url || !filter_var($booking->showtime->movie->poster_url, FILTER_VALIDATE_URL))
                                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                    <i class="fas fa-film text-gray-400 text-2xl"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Detalles de la Película y Función -->
                    <div class="flex-1">
                        <h4 class="text-xl font-bold text-gray-900">{{ $booking->showtime->movie->title }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $booking->showtime->movie->description }}</p>

                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="text-xs font-medium text-gray-500">Género</label>
                                <p class="text-sm text-gray-900">{{ $booking->showtime->movie->genre }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Duración</label>
                                <p class="text-sm text-gray-900">{{ $booking->showtime->movie->duration }} min</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Fecha y Hora</label>
                                <p class="text-sm text-gray-900">{{ $booking->showtime->start_time->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Sala</label>
                                <p class="text-sm text-gray-900">{{ $booking->showtime->room->name }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Precio por Ticket</label>
                                <p class="text-sm text-gray-900">${{ number_format($booking->showtime->price, 2) }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Asientos Disponibles</label>
                                <p class="text-sm text-gray-900">{{ $booking->showtime->available_seats }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Lateral -->
        <div class="space-y-6">
            <!-- Acciones Rápidas -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones</h3>

                <div class="space-y-3">
                    <!-- Cambiar Estado -->
                    <form action="{{ route('admin.bookings.toggle-status', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                                class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md inline-flex items-center justify-center text-sm font-medium transition-colors">
                            <i class="fas fa-sync-alt w-4 h-4 mr-2"></i>
                            {{ $booking->status == 'confirmed' ? 'Cancelar Reserva' : 'Confirmar Reserva' }}
                        </button>
                    </form>

                    <!-- Editar -->
                    <a href="{{ route('admin.bookings.edit', $booking) }}"
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-flex items-center justify-center text-sm font-medium transition-colors">
                        <i class="fas fa-edit w-4 h-4 mr-2"></i>
                        Editar Reserva
                    </a>

                    <!-- Eliminar -->
                    <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md inline-flex items-center justify-center text-sm font-medium transition-colors"
                                onclick="return confirm('¿Estás seguro de eliminar esta reserva? Esta acción no se puede deshacer.')">
                            <i class="fas fa-trash w-4 h-4 mr-2"></i>
                            Eliminar Reserva
                        </button>
                    </form>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Adicional</h3>

                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Creado el:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $booking->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Actualizado el:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $booking->updated_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Precio Unitario:</span>
                        <span class="text-sm font-medium text-gray-900">${{ number_format($booking->showtime->price, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Calculado:</span>
                        <span class="text-sm font-medium text-gray-900">${{ number_format($booking->showtime->price * $booking->number_of_tickets, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Estado del Sistema -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Estado del Sistema</h3>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Reserva Activa:</span>
                        <span class="inline-flex items-center">
                            @if($booking->is_active)
                                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                <span class="text-sm text-green-600">Sí</span>
                            @else
                                <i class="fas fa-times-circle text-red-500 mr-1"></i>
                                <span class="text-sm text-red-600">No</span>
                            @endif
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Función Activa:</span>
                        <span class="inline-flex items-center">
                            @if($booking->showtime->is_active)
                                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                <span class="text-sm text-green-600">Sí</span>
                            @else
                                <i class="fas fa-times-circle text-red-500 mr-1"></i>
                                <span class="text-sm text-red-600">No</span>
                            @endif
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Película Activa:</span>
                        <span class="inline-flex items-center">
                            @if($booking->showtime->movie->is_active)
                                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                <span class="text-sm text-green-600">Sí</span>
                            @else
                                <i class="fas fa-times-circle text-red-500 mr-1"></i>
                                <span class="text-sm text-red-600">No</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para manejar errores de imagen
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.addEventListener('error', function() {
                    this.style.display = 'none';
                    const placeholder = this.parentElement.querySelector('.fa-film');
                    if (placeholder) {
                        placeholder.parentElement.style.display = 'flex';
                    }
                });
            });
        });
    </script>
</x-admin-layout>
