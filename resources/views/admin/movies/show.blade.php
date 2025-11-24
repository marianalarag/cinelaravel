<x-admin-layout
    title="{{ $movie->title }} - CineLaravel"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Películas', 'href' => route('admin.movies.index')],
        ['name' => $movie->title]
    ]"
    headerTitle="{{ $movie->title }}"
    headerDescription="Detalles completos de la película"
>
    <x-slot name="actions">
        <div class="flex space-x-2">
            <a href="{{ route('admin.movies.edit', $movie) }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md inline-flex items-center text-sm font-medium transition-colors shadow-sm">
                <i class="fas fa-edit w-4 h-4 mr-2"></i>
                Editar
            </a>
            <a href="{{ route('admin.showtimes.create') }}?movie={{ $movie->id }}"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md inline-flex items-center text-sm font-medium transition-colors shadow-sm">
                <i class="fas fa-calendar-plus w-4 h-4 mr-2"></i>
                Nueva Función
            </a>
            <a href="{{ route('admin.movies.index') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md inline-flex items-center text-sm font-medium transition-colors shadow-sm">
                <i class="fas fa-arrow-left w-4 h-4 mr-2"></i>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna izquierda: Información de la película -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Información Principal -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información General</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Título</label>
                        <p class="text-sm text-gray-900">{{ $movie->title }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Director</label>
                        <p class="text-sm text-gray-900">{{ $movie->director }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Género</label>
                        <p class="text-sm text-gray-900">{{ $movie->genre }}</p>
                        @if($movie->genreRelation)
                            <p class="text-xs text-gray-500">{{ $movie->genreRelation->description }}</p>
                        @endif
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Duración</label>
                        <p class="text-sm text-gray-900">{{ $movie->duration }} minutos</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Rating</label>
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                            <span class="text-sm text-gray-900">{{ $movie->rating ?? 'N/A' }}/10</span>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Fecha de Estreno</label>
                        <p class="text-sm text-gray-900">{{ $movie->release_date->format('d/m/Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $movie->release_date->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- Sinopsis -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Sinopsis</h3>
                <p class="text-gray-700 leading-relaxed">{{ $movie->description }}</p>
            </div>

            <!-- Reparto -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Reparto</h3>
                <p class="text-gray-700">{{ $movie->cast }}</p>
            </div>

            <!-- Funciones Programadas -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Funciones Programadas</h3>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $movie->showtimes->count() }} función(es)
                    </span>
                </div>

                @if($movie->showtimes->count() > 0)
                    <div class="space-y-3">
                        @foreach($movie->showtimes as $showtime)
                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-4">
                                        <div class="text-sm">
                                            <p class="font-medium text-gray-900">{{ $showtime->room->name }}</p>
                                            <p class="text-gray-500 text-xs">{{ strtoupper($showtime->room->type) }}</p>
                                        </div>
                                        <div class="text-sm">
                                            <p class="font-medium text-gray-900">{{ $showtime->start_time->format('d/m/Y H:i') }}</p>
                                            <p class="text-gray-500 text-xs">a {{ $showtime->end_time->format('H:i') }}</p>
                                        </div>
                                        <div class="text-sm">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $showtime->format }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-gray-900">${{ number_format($showtime->price, 2) }}</span>
                                    <a href="{{ route('admin.showtimes.edit', $showtime) }}"
                                       class="text-indigo-600 hover:text-indigo-900 text-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-times text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 mb-4">No hay funciones programadas para esta película</p>
                        <a href="{{ route('admin.showtimes.create') }}?movie={{ $movie->id }}"
                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md inline-flex items-center text-sm font-medium transition-colors">
                            <i class="fas fa-calendar-plus w-4 h-4 mr-2"></i>
                            Programar Primera Función
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Columna derecha: Poster y información adicional -->
        <div class="space-y-6">
            <!-- Poster -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Poster</h3>
                @if($movie->poster_url)
                    <img src="{{ Storage::disk('public')->url($movie->poster_url) }}"
                         alt="{{ $movie->title }}"
                         class="w-full rounded-lg shadow-sm">
                @else
                    <div class="bg-gray-100 rounded-lg h-64 flex items-center justify-center">
                        <i class="fas fa-film text-4xl text-gray-400"></i>
                    </div>
                @endif
            </div>

            <!-- Estado y Metadatos -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Estado</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Estado</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $movie->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $movie->is_active ? 'Activa' : 'Inactiva' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">ID</span>
                        <span class="text-sm text-gray-900">{{ $movie->id }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Creada</span>
                        <span class="text-sm text-gray-900">{{ $movie->created_at->format('d/m/Y H:i') }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Actualizada</span>
                        <span class="text-sm text-gray-900">{{ $movie->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Trailer -->
            @if($movie->trailer_url)
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Trailer</h3>
                    <a href="{{ $movie->trailer_url }}"
                       target="_blank"
                       class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Ver trailer en YouTube
                    </a>
                </div>
            @endif

            <!-- Acciones Rápidas -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones Rápidas</h3>
                <div class="space-y-2">
                    <form action="{{ route('admin.movies.toggle-status', $movie) }}" method="POST" class="w-full">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm {{ $movie->is_active ? 'text-red-700 hover:bg-red-50' : 'text-green-700 hover:bg-green-50' }} rounded-md transition-colors">
                            <i class="fas fa-power-off mr-2"></i>
                            {{ $movie->is_active ? 'Desactivar Película' : 'Activar Película' }}
                        </button>
                    </form>

                    <a href="{{ route('admin.showtimes.create') }}?movie={{ $movie->id }}"
                       class="w-full text-left px-4 py-2 text-sm text-blue-700 hover:bg-blue-50 rounded-md transition-colors block">
                        <i class="fas fa-calendar-plus mr-2"></i>
                        Nueva Función
                    </a>

                    @if($movie->showtimes->count() == 0)
                        <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50 rounded-md transition-colors"
                                    onclick="return confirm('¿Estás seguro de eliminar esta película?')">
                                <i class="fas fa-trash mr-2"></i>
                                Eliminar Película
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
