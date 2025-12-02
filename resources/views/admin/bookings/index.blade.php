<x-admin-layout
    title="Reservas - CineLaravel"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Reservas']
    ]"
    headerTitle="Gestión de Reservas"
    headerDescription="Administra las reservas del sistema"
>
    <x-slot name="actions">
        <a href="{{ route('admin.bookings.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-flex items-center text-sm font-medium transition-colors shadow-sm">
            <i class="fa-solid fa-plus w-4 h-4 mr-2"></i>
            Nueva Reserva
        </a>
    </x-slot>

    <!-- Filtros y Búsqueda -->
    <div class="mb-6 bg-white p-4 rounded-lg shadow-sm border">
        <div class="flex flex-col md:flex-row gap-4 items-start md:items-center justify-between">
            <!-- Búsqueda -->
            <div class="w-full md:w-64">
                <form action="{{ route('admin.bookings.index') }}" method="GET">
                    <div class="relative">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Buscar reservas..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </form>
            </div>

            <!-- Filtros -->
            <div class="flex flex-wrap gap-2">
                <!-- Filtro por estado -->
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Estado:</span>
                    <a href="{{ request()->fullUrlWithQuery(['status' => '']) }}"
                       class="px-3 py-1 text-xs rounded-full {{ !request('status') ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Todos
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'confirmed']) }}"
                       class="px-3 py-1 text-xs rounded-full {{ request('status') == 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Confirmadas
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}"
                       class="px-3 py-1 text-xs rounded-full {{ request('status') == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Pendientes
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'cancelled']) }}"
                       class="px-3 py-1 text-xs rounded-full {{ request('status') == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Canceladas
                    </a>
                </div>

                <!-- Contador -->
                <div class="text-sm text-gray-600 px-3 py-1 bg-gray-100 rounded-full">
                    {{ $bookings->total() }} reserva(s)
                </div>
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
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Cliente
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Película
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Función
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tickets
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Total
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Fecha Reserva
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Estado
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <!-- Cliente -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $booking->user->name }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $booking->user->email }}
                            </div>
                        </td>

                        <!-- Película -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded overflow-hidden">
                                    @if($booking->showtime->movie->poster_url)
                                        <img src="{{ $booking->showtime->movie->poster_url }}"
                                             alt="{{ $booking->showtime->movie->title }}"
                                             class="h-12 w-12 object-cover"
                                             onerror="this.style.display='none'">
                                    @endif
                                    @if(!$booking->showtime->movie->poster_url || !filter_var($booking->showtime->movie->poster_url, FILTER_VALIDATE_URL))
                                        <div class="h-12 w-12 flex items-center justify-center bg-gray-100">
                                            <i class="fas fa-film text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $booking->showtime->movie->title }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $booking->showtime->movie->duration }} min
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Función -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $booking->showtime->start_time->format('d/m/Y H:i') }}
                            </div>
                            <div class="text-sm text-gray-500">
                                Sala {{ $booking->showtime->room->name }}
                            </div>
                        </td>

                        <!-- Tickets -->
                        <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center px-3 py-1 text-sm font-bold leading-none text-white bg-blue-600 rounded-full">
                                    {{ $booking->number_of_tickets }}
                                </span>
                        </td>

                        <!-- Total -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                            ${{ number_format($booking->total_price, 2) }}
                        </td>

                        <!-- Fecha Reserva -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $booking->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                Hace {{ $booking->created_at->diffForHumans() }}
                            </div>
                        </td>

                        <!-- Estado -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.bookings.toggle-status', $booking) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition-colors
                                                {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-800 hover:bg-green-200' :
                                                   ($booking->status == 'pending' ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-red-100 text-red-800 hover:bg-red-200') }}"
                                        onclick="return confirm('¿Estás seguro de cambiar el estado de esta reserva?')">
                                        <span class="w-2 h-2 rounded-full mr-1
                                            {{ $booking->status == 'confirmed' ? 'bg-green-500' :
                                               ($booking->status == 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}"></span>
                                    {{ $booking->status == 'confirmed' ? 'Confirmada' :
                                       ($booking->status == 'pending' ? 'Pendiente' : 'Cancelada') }}
                                </button>
                            </form>
                        </td>

                        <!-- Acciones -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <!-- Ver -->
                                <a href="{{ route('admin.bookings.show', $booking) }}"
                                   class="text-blue-600 hover:text-blue-900 transition-colors p-1 rounded hover:bg-blue-50"
                                   title="Ver detalles">
                                    <i class="fas fa-eye w-4 h-4"></i>
                                </a>

                                <!-- Editar -->
                                <a href="{{ route('admin.bookings.edit', $booking) }}"
                                   class="text-indigo-600 hover:text-indigo-900 transition-colors p-1 rounded hover:bg-indigo-50"
                                   title="Editar">
                                    <i class="fas fa-edit w-4 h-4"></i>
                                </a>

                                <!-- Eliminar -->
                                <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 transition-colors p-1 rounded hover:bg-red-50"
                                            title="Eliminar"
                                            onclick="return confirm('¿Estás seguro de eliminar esta reserva? Esta acción no se puede deshacer.')">
                                        <i class="fas fa-trash w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <i class="fas fa-ticket-alt text-4xl mb-4 text-gray-300"></i>
                                <p class="text-lg font-medium mb-2">No hay reservas registradas</p>
                                <p class="text-sm mb-4">Comienza creando una nueva reserva</p>
                                <a href="{{ route('admin.bookings.create') }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-flex items-center text-sm font-medium transition-colors">
                                    <i class="fa-solid fa-plus w-4 h-4 mr-2"></i>
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

    <script>
        // Función para manejar errores de imagen
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.addEventListener('error', function() {
                    this.style.display = 'none';
                    // Mostrar placeholder si está disponible
                    const placeholder = this.parentElement.querySelector('.fa-film');
                    if (placeholder) {
                        placeholder.parentElement.style.display = 'flex';
                    }
                });
            });
        });
    </script>
</x-admin-layout>
