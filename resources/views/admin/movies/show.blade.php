<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles de Película') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Poster -->
        <div class="lg:col-span-1">
            <div class="bg-gray-100 rounded-lg p-4 text-center">
                <div class="max-w-xs mx-auto">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        @if($movie->poster_url)
                            <img src="{{ $movie->poster_url }}"
                                 alt="{{ $movie->title }}"
                                 class="w-full h-auto object-cover"
                                 onerror="this.style.display='none'">
                        @endif
                        @if(!$movie->poster_url || !filter_var($movie->poster_url, FILTER_VALIDATE_URL))
                            <div class="h-96 flex items-center justify-center bg-gradient-to-br from-blue-100 to-purple-100">
                                <div class="text-center">
                                    <i class="fas fa-film text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-500 font-medium">{{ $movie->title }}</p>
                                    <p class="text-gray-400 text-sm">{{ $movie->genre }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Información -->
        <div class="lg:col-span-2">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $movie->title }}</h1>

                        <!-- Badge de estado -->
                        <div class="flex items-center mb-4">
                            @if($movie->release_date->isFuture())
                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-clock mr-1"></i>
                                    Próximamente
                                </span>
                            @else
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-play-circle mr-1"></i>
                                    En cartelera
                                </span>
                            @endif
                            <span class="ml-2 bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $movie->genre }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="space-y-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-clock mr-2 w-4"></i>
                                    <span><strong>Duración:</strong> {{ $movie->duration }} minutos</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-calendar-alt mr-2 w-4"></i>
                                    <span><strong>Estreno:</strong> {{ $movie->release_date->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-user-tie mr-2 w-4"></i>
                                    <span><strong>Director:</strong> {{ $movie->director }}</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-start text-sm text-gray-600">
                                    <i class="fas fa-users mr-2 w-4 mt-0.5"></i>
                                    <span><strong>Reparto:</strong> {{ $movie->cast }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-star mr-2 w-4 text-yellow-400"></i>
                                    <span><strong>Género:</strong> {{ $movie->genre }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Sinopsis -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Sinopsis</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $movie->description }}</p>
                        </div>

                        <!-- Acciones -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            @if($movie->release_date->isPast())
                                <a href="{{ route('client.movies.showtimes', $movie) }}"
                                   class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold text-center">
                                    <i class="fas fa-ticket-alt mr-2"></i>
                                    Ver Funciones Disponibles
                                </a>
                            @else
                                <button class="bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold text-center cursor-not-allowed opacity-70"
                                        title="Disponible a partir del {{ $movie->release_date->format('d/m/Y') }}">
                                    <i class="fas fa-clock mr-2"></i>
                                    Próximamente
                                </button>
                            @endif
                            <a href="{{ route('client.movies.index') }}"
                               class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Volver a Cartelera
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trailer (si existe) -->
            @if($movie->trailer_url)
                <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Tráiler</h3>
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe src="{{ $movie->trailer_url }}"
                                class="w-full h-64 md:h-96 rounded-lg"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                        </iframe>
                    </div>
                </div>
            @endif

            <!-- Funciones próximas (si hay) -->
            @if(isset($showtimes) && $showtimes->count() > 0)
                <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-900">Próximas Funciones</h3>
                        <a href="{{ route('client.movies.showtimes', $movie) }}"
                           class="text-blue-600 hover:text-blue-800 font-medium">
                            Ver todas las funciones
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($showtimes->take(3) as $date => $dayShowtimes)
                            @foreach($dayShowtimes->take(2) as $showtime)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $showtime->start_time->format('H:i') }}</p>
                                            <p class="text-sm text-gray-600">{{ $showtime->room->name }}</p>
                                        </div>
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                            {{ $showtime->format }}
                                        </span>
                                    </div>

                                    <div class="space-y-1 text-sm text-gray-600 mb-4">
                                        <p><strong>Idioma:</strong> {{ $showtime->language }}</p>
                                        <p><strong>Asientos disponibles:</strong> {{ $showtime->available_seats }}</p>
                                        <p class="text-lg font-bold text-gray-900">${{ number_format($showtime->price, 2) }}</p>
                                    </div>

                                    @if($showtime->available_seats > 0)
                                        <a href="{{ route('client.movies.showtimes', $movie) }}"
                                           class="w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition-colors font-semibold text-center block">
                                            Reservar
                                        </a>
                                    @else
                                        <button disabled
                                                class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded cursor-not-allowed font-semibold">
                                            Agotado
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
