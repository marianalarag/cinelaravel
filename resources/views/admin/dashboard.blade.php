<x-admin-layout
    title="Dashboard - CineLaravel"
    :breadcrumbs="[['name' => 'Dashboard']]"
    headerTitle="Dashboard"
    headerDescription="Bienvenido al sistema de gestión de CineLaravel"
>
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

    @php
        // Datos temporales mientras se arregla el controlador
        $stats = $stats ?? [
            'total_movies' => \App\Models\Movie::count(),
            'today_showtimes' => \App\Models\Showtime::whereDate('start_time', today())->count(),
            'today_bookings' => \App\Models\Booking::whereDate('created_at', today())->count(),
            'today_revenue' => \App\Models\Booking::whereDate('created_at', today())->sum('total_price') ?? 0,
            'total_users' => \App\Models\User::count(),
            'active_halls' => \App\Models\Hall::where('is_active', true)->count(),
        ];

        $nowShowing = $nowShowing ?? \App\Models\Movie::where('is_active', true)
            ->where('release_date', '<=', now())
            ->orderBy('release_date', 'desc')
            ->take(5)
            ->get();

        $comingSoon = $comingSoon ?? \App\Models\Movie::where('is_active', true)
            ->where('release_date', '>', now())
            ->orderBy('release_date')
            ->take(3)
            ->get();

        $todayShowtimes = $todayShowtimes ?? \App\Models\Showtime::with(['movie', 'room'])
            ->whereDate('start_time', today())
            ->where('is_active', true)
            ->orderBy('start_time')
            ->get();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Películas -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-film text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Películas</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_movies'] }}</p>
                </div>
            </div>
        </div>

        <!-- Funciones Hoy -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Funciones Hoy</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['today_showtimes'] }}</p>
                </div>
            </div>
        </div>

        <!-- Reservas Hoy -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-ticket-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Reservas Hoy</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['today_bookings'] }}</p>
                </div>
            </div>
        </div>

        <!-- Ingresos Hoy -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Ingresos Hoy</h3>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['today_revenue'], 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Películas en Cartelera -->
        <div class="bg-white rounded-lg shadow-sm border p-6 lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Películas en Cartelera</h3>
                <a href="{{ route('admin.movies.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Ver todas
                </a>
            </div>

            @if($nowShowing->count() > 0)
                <div class="space-y-4">
                    @foreach($nowShowing as $movie)
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <div class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center overflow-hidden">
                                    @if($movie->poster_url)
                                        <img src="{{ $movie->poster_url }}"
                                             alt="{{ $movie->title }}"
                                             class="w-full h-full object-cover"
                                             onerror="this.style.display='none'">
                                    @endif
                                    @if(!$movie->poster_url)
                                        <i class="fas fa-film text-gray-400 text-lg"></i>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $movie->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $movie->genre }} • {{ $movie->duration }} min</p>
                                    <p class="text-xs text-gray-400">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        Estreno: {{ $movie->release_date->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                    En cartelera
                                </span>
                                <a href="{{ route('admin.movies.show', $movie) }}"
                                   class="text-blue-600 hover:text-blue-800 p-1 rounded">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-film text-4xl mb-3 text-gray-300"></i>
                    <p>No hay películas en cartelera</p>
                    <a href="{{ route('admin.movies.create') }}" class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">
                        Agregar primera película
                    </a>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones Rápidas</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.movies.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors">
                    <i class="fas fa-film text-2xl text-blue-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Nueva Película</span>
                </a>
                <a href="{{ route('admin.showtimes.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500 hover:bg-green-50 transition-colors">
                    <i class="fas fa-calendar-plus text-2xl text-green-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Nueva Función</span>
                </a>
                <a href="{{ route('admin.halls.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-colors">
                    <i class="fas fa-theater-masks text-2xl text-purple-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Nueva Sala</span>
                </a>
                <a href="{{ route('admin.genres.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-yellow-500 hover:bg-yellow-50 transition-colors">
                    <i class="fas fa-tags text-2xl text-yellow-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Nuevo Género</span>
                </a>
            </div>

            <!-- Información adicional -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Total Usuarios:</span>
                        <span class="font-medium">{{ $stats['total_users'] }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Salas Activas:</span>
                        <span class="font-medium">{{ $stats['active_halls'] }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Próximos Estrenos:</span>
                        <span class="font-medium">{{ $comingSoon->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Funciones de Hoy -->
    @if($todayShowtimes->count() > 0)
        <div class="mt-6 bg-white rounded-lg shadow-sm border p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Funciones de Hoy</h3>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ now()->format('d/m/Y') }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($todayShowtimes as $showtime)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-medium text-gray-900">{{ $showtime->movie->title }}</p>
                                <p class="text-sm text-gray-600">{{ $showtime->room->name }}</p>
                            </div>
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                {{ $showtime->start_time->format('H:i') }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><strong>Formato:</strong> {{ $showtime->format }}</p>
                            <p><strong>Idioma:</strong> {{ $showtime->language }}</p>
                            <p><strong>Precio:</strong> ${{ number_format($showtime->price, 2) }}</p>
                        </div>
                        <div class="mt-3 flex justify-between items-center">
                            <span class="text-xs text-gray-500">
                                {{ $showtime->available_seats }} asientos disponibles
                            </span>
                            <a href="{{ route('admin.showtimes.show', $showtime) }}"
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-admin-layout>
