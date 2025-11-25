<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Reservas - Staff') }}
            </h2>
            <a href="{{ route('staff.bookings.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-flex items-center text-sm font-medium transition-colors">
                <i class="fas fa-plus w-4 h-4 mr-2"></i>
                Nueva Reserva
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros -->
            <div class="mb-6 bg-white p-4 rounded-lg shadow-sm border">
                <div class="flex flex-col md:flex-row gap-4 items-start md:items-center justify-between">
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('staff.bookings.index') }}"
                           class="px-3 py-1 text-sm rounded-full {{ !request('status') ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            Todas
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'confirmed']) }}"
                           class="px-3 py-1 text-sm rounded-full {{ request('status') == 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            Confirmadas
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}"
                           class="px-3 py-1 text-sm rounded-full {{ request('status') == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            Pendientes
                        </a>
                        <a href="{{ route('staff.bookings.today') }}"
                           class="px-3 py-1 text-sm rounded-full bg-orange-100 text-orange-800">
                            Hoy
                        </a>
                    </div>
                    <div class="text-sm text-gray-600">
                        {{ $bookings->total() }} reserva(s)
                    </div>
                </div>
            </div>

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

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                {{ session('error') }}
                            </h3>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Tabla de Reservas -->
            <div class="bg-white shadow-sm rounded-lg border overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Película</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Función</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    #{{ $booking->id }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded overflow-hidden">
                                            @if($booking->showtime->movie->poster_url)
                                                <img src="{{ $booking->showtime->movie->poster_url }}"
                                                     alt="{{ $booking->showtime->movie->title }}"
                                                     class="h-10 w-10 object-cover">
                                            @else
                                                <div class="h-10 w-10 flex items-center justify-center bg-gray-100">
                                                    <i class="fas fa-film text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $booking->showtime->movie->title }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                Sala {{ $booking->showtime->room->name ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $booking->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $booking->showtime->start_time->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($booking->total_amount ?? $booking->total_price ?? 0, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-800' :
                                           ($booking->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <!-- Ver -->
                                        <a href="{{ route('staff.bookings.show', $booking) }}"
                                           class="text-blue-600 hover:text-blue-900 transition-colors p-1 rounded hover:bg-blue-50"
                                           title="Ver detalles">
                                            <i class="fas fa-eye w-4 h-4"></i>
                                        </a>

                                        <!-- Editar -->
                                        <a href="{{ route('staff.bookings.edit', $booking) }}"
                                           class="text-indigo-600 hover:text-indigo-900 transition-colors p-1 rounded hover:bg-indigo-50"
                                           title="Editar">
                                            <i class="fas fa-edit w-4 h-4"></i>
                                        </a>

                                        <!-- Cambiar Estado -->
                                        <form action="{{ route('staff.bookings.toggle-status', $booking) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                    class="text-green-600 hover:text-green-900 transition-colors p-1 rounded hover:bg-green-50"
                                                    title="{{ $booking->status == 'confirmed' ? 'Cancelar' : 'Confirmar' }}"
                                                    onclick="return confirm('¿Estás seguro de cambiar el estado de esta reserva?')">
                                                <i class="fas {{ $booking->status == 'confirmed' ? 'fa-times' : 'fa-check' }} w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <i class="fas fa-ticket-alt text-4xl mb-4 text-gray-300"></i>
                                        <p class="text-lg font-medium mb-2">No hay reservas</p>
                                        <p class="text-sm mb-4">No se encontraron reservas con los filtros aplicados</p>
                                        <a href="{{ route('staff.bookings.create') }}"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-flex items-center text-sm font-medium transition-colors">
                                            <i class="fas fa-plus w-4 h-4 mr-2"></i>
                                            Crear Primera Reserva
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if($bookings->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
