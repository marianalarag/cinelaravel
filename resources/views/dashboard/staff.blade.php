<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel Staff - CineLaravel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <!-- Estadísticas Rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-ticket-alt text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Reservas Hoy</h3>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ \App\Models\Booking::whereDate('created_at', today())->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-film text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Funciones Hoy</h3>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ \App\Models\Showtime::whereDate('start_time', today())->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Clientes Activos</h3>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ \App\Models\User::role('client')->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-dollar-sign text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Ingresos Hoy</h3>
                            <p class="text-2xl font-bold text-gray-900">
                                ${{ number_format(\App\Models\Booking::whereDate('created_at', today())->sum('total_price'), 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Gestión de Reservas -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Gestión de Reservas</h3>
                        <div class="space-y-3">
                            <a href="{{ route('staff.bookings.index') }}"
                               class="w-full flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <i class="fas fa-list text-blue-500 mr-3"></i>
                                    <span>Ver Todas las Reservas</span>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </a>
                            <a href="{{ route('staff.bookings.create') }}"
                               class="w-full flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <i class="fas fa-plus text-green-500 mr-3"></i>
                                    <span>Crear Nueva Reserva</span>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </a>
                            <a href="{{ route('staff.bookings.today') }}"
                               class="w-full flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-day text-orange-500 mr-3"></i>
                                    <span>Reservas de Hoy</span>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Gestión de Funciones -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Gestión de Funciones</h3>
                        <div class="space-y-3">
                            <a href="{{ route('staff.showtimes.index') }}"
                               class="w-full flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-purple-500 mr-3"></i>
                                    <span>Ver Todas las Funciones</span>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </a>
                            <a href="{{ route('staff.showtimes.create') }}"
                               class="w-full flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <i class="fas fa-plus-circle text-orange-500 mr-3"></i>
                                    <span>Programar Nueva Función</span>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </a>
                            <a href="{{ route('staff.showtimes.today') }}"
                               class="w-full flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-yellow-500 mr-3"></i>
                                    <span>Funciones de Hoy</span>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Funciones de Hoy -->
            <div class="mt-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Funciones de Hoy</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ now()->format('d/m/Y') }}
                        </span>
                    </div>

                    @php
                        $todayShowtimes = \App\Models\Showtime::with(['movie', 'room'])
                            ->whereDate('start_time', today())
                            ->orderBy('start_time')
                            ->get();
                    @endphp

                    @if($todayShowtimes->count() > 0)
                        <div class="space-y-3">
                            @foreach($todayShowtimes->take(5) as $showtime)
                                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                                            @if($showtime->movie->poster_url)
                                                <img src="{{ $showtime->movie->poster_url }}" alt="{{ $showtime->movie->title }}" class="w-full h-full object-cover">
                                            @else
                                                <i class="fas fa-film text-gray-400"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $showtime->movie->title }}</p>
                                            <p class="text-sm text-gray-500">
                                                Sala {{ $showtime->room->name ?? 'N/A' }} •
                                                {{ $showtime->start_time->format('H:i') }} - {{ $showtime->end_time->format('H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">${{ number_format($showtime->price, 2) }}</p>
                                        <p class="text-xs text-gray-500">
                                            @php
                                                // Si tienes el campo 'seats' que almacena los asientos como array/JSON
                                                $occupiedSeats = $showtime->bookings()->get()->sum(function($booking) {
                                                    if ($booking->seats) {
                                                        $seats = json_decode($booking->seats, true);
                                                        return is_array($seats) ? count($seats) : 0;
                                                    }
                                                    return 0;
                                                });
                                                $totalSeats = $showtime->room->capacity ?? 100;
                                            @endphp
                                            {{ $occupiedSeats }}/{{ $totalSeats }} asientos
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($todayShowtimes->count() > 5)
                            <div class="mt-4 text-center">
                                <a href="{{ route('staff.showtimes.today') }}"
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Ver todas las {{ $todayShowtimes->count() }} funciones de hoy
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-film text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">No hay funciones programadas para hoy</p>
                            <a href="{{ route('staff.showtimes.create') }}"
                               class="inline-flex items-center mt-3 px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Programar Función
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reservas Recientes -->
            <div class="mt-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Reservas Recientes</h3>
                        <a href="{{ route('staff.bookings.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Ver todas
                        </a>
                    </div>

                    @php
                        $recentBookings = \App\Models\Booking::with(['user', 'showtime.movie'])
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
                    @endphp

                    @if($recentBookings->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentBookings as $booking)
                                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-ticket-alt text-green-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">
                                                {{ $booking->user->name }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $booking->showtime->movie->title }} •
                                                {{ $booking->number_of_tickets }} tickets
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">${{ number_format($booking->total_price, 2) }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $booking->created_at->format('H:i') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-ticket-alt text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">No hay reservas recientes</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-refresh cada 60 segundos para estadísticas en tiempo real
        setTimeout(function() {
            window.location.reload();
        }, 60000);
    </script>
</x-app-layout>
