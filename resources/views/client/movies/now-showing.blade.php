<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Películas en Cartelera') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros CORREGIDOS -->
            <div class="mb-6 bg-white p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Filtrar por:</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('movies.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        Todas las Películas
                    </a>
                    <a href="{{ route('movies.now-showing') }}"
                       class="px-4 py-2 bg-green-600 text-white rounded-lg transition-colors">
                        🎬 En Cartelera
                    </a>
                    <a href="{{ route('movies.coming-soon') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        🗓️ Próximamente
                    </a>
                </div>
            </div>

            <!-- Mensaje informativo -->
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-ticket-alt text-green-500 text-lg mr-3"></i>
                    <div>
                        <h4 class="font-semibold text-green-800">Películas en Cartelera</h4>
                        <p class="text-green-700 text-sm">Estas películas ya están disponibles para ver en nuestro cine.</p>
                    </div>
                </div>
            </div>

            <!-- Grid de Películas -->
            @if($movies->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($movies as $movie)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <!-- Poster -->
                            <div class="relative h-64 bg-gray-200 overflow-hidden">
                                @if($movie->poster_url)
                                    <img src="{{ $movie->poster_url }}"
                                         alt="{{ $movie->title }}"
                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                         onerror="this.style.display='none'">
                                @endif
                                @if(!$movie->poster_url || !filter_var($movie->poster_url, FILTER_VALIDATE_URL))
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-100 to-purple-100">
                                        <div class="text-center text-gray-500">
                                            <i class="fas fa-film text-3xl mb-2"></i>
                                            <p class="text-sm font-medium">{{ Str::limit($movie->title, 20) }}</p>
                                        </div>
                                    </div>
                                @endif

                                <!-- Badge de estado -->
                                <span class="absolute top-2 right-2 bg-green-600 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                    En Cartelera
                                </span>
                            </div>

                            <!-- Información -->
                            <div class="p-4">
                                <h3 class="font-semibold text-lg text-gray-900 mb-2 line-clamp-2">{{ $movie->title }}</h3>

                                <div class="space-y-1 text-sm text-gray-600 mb-3">
                                    <p><strong>Género:</strong> {{ $movie->genre }}</p>
                                    <p><strong>Duración:</strong> {{ $movie->duration }} min</p>
                                    <p><strong>Estreno:</strong> {{ $movie->release_date->format('d/m/Y') }}</p>
                                </div>

                                <div class="flex space-x-2">
                                    <a href="{{ route('movies.show', $movie) }}"
                                       class="flex-1 bg-blue-600 text-white text-center py-2 px-3 rounded hover:bg-blue-700 transition-colors text-sm">
                                        Ver Detalles
                                    </a>
                                    <a href="{{ route('movies.showtimes', $movie) }}"
                                       class="flex-1 bg-green-600 text-white text-center py-2 px-3 rounded hover:bg-green-700 transition-colors text-sm">
                                        Reservar
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="mt-6">
                    {{ $movies->links() }}
                </div>
            @else
                <!-- Mensaje cuando no hay películas -->
                <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                    <i class="fas fa-film text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay películas en cartelera</h3>
                    <p class="text-gray-600 mb-4">Próximamente tendremos nuevas películas disponibles.</p>
                    <div class="flex justify-center space-x-3">
                        <a href="{{ route('movies.index') }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                            Ver Todas las Películas
                        </a>
                        <a href="{{ route('movies.coming-soon') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition-colors">
                            Ver Próximos Estrenos
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }
    </style>
</x-app-layout>
