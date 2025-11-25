<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reservas de Hoy') }}
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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-sm border p-4">
                    <div class="flex items-center">
                        <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-500">Total Hoy</h3>
                            <p class="text-xl font-bold text-gray-900">{{ $todayBookings->total() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border p-4">
                    <div class="flex items-center">
                        <div class="p-2 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-500">Confirmadas</h3>
                            <p class="text-xl font-bold text-gray-900">
                                {{ $todayBookings->where('status', 'confirmed')->count() }}
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
                            <h3 class="text-sm font-medium text-gray-500">Pendientes</h3>
                            <p class="text-xl font-bold text-gray-900">
                                {{ $todayBookings->where('status', 'pending')->count() }}
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
                            <h3 class="text-sm font-medium text-gray-500">Canceladas</h3>
                            <p class="text-xl font-bold text-gray-900">
                                {{ $todayBookings->where('status', 'cancelled')->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navegación -->
            <div class="mb-6 bg-white p-4 rounded-lg shadow-sm">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('staff.bookings.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        Todas las Reservas
                    </a>
                    <a href="{{ route('staff.bookings.today') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg transition-colors">
                        Reservas de Hoy
                    </a>
                    <a href="{{ route('staff.bookings.create') }}"
                       class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus mr-1"></i>
                        Nueva Reserva
                    </a>
                </div>
            </div>

            <!-- Lista de Reservas -->
            @if($todayBookings->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Reservas para el {{ now()->translatedFormat('l, d \\d\\e F Y') }}
                        </h3>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cliente
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Película
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Horario
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
                                        Acciones
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($todayBookings as $booking)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $booking->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $booking->showtime->movie->title }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                Sala {{ $booking->showtime->hall->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->showtime->start_time->format('H:i') }}
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
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
                                                            title="{{ $booking->status === 'confirmed' ? 'Cancelar' : 'Confirmar' }}">
                                                        <i class="fas {{ $booking->status === 'confirmed' ? 'fa-times' : 'fa-check' }} w-4 h-4"></i>
                                                    </button>
                                                </form>

                                                <!-- Eliminar -->
                                                <form action="{{ route('staff.bookings.destroy', $booking) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta reserva?')">
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
                            {{ $todayBookings->links() }}
                        </div>
                    </div>
                </div>
            @else
                <!-- Estado cuando no hay reservas -->
                <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="bg-gradient-to-br from-blue-100 to-purple-100 rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                            <i class="fas fa-ticket-alt text-blue-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay reservas para hoy</h3>
                        <p class="text-gray-600 mb-6">
                            No se han realizado reservas para las funciones de hoy.
                        </p>
                        <div class="flex flex-col sm:flex-row justify-center gap-3">
                            <a href="{{ route('staff.bookings.create') }}"
                               class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-plus mr-2"></i>
                                Crear Reserva
                            </a>
                            <a href="{{ route('staff.bookings.index') }}"
                               class="inline-flex items-center px-6 py-3 bg-gray-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-list mr-2"></i>
                                Ver Todas las Reservas
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
