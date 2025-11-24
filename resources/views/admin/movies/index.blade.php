<x-admin-layout
    title="Películas - CineLaravel"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Películas']
    ]"
    headerTitle="Gestión de Películas"
    headerDescription="Administra la cartelera de películas del cine"
>
    <x-slot name="actions">
        <a href="{{ route('admin.movies.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-flex items-center text-sm font-medium transition-colors shadow-sm">
            <i class="fa-solid fa-plus w-4 h-4 mr-2"></i>
            Nueva Película
        </a>
    </x-slot>

    <!-- Filtros y Búsqueda -->
    <div class="mb-6 bg-white p-4 rounded-lg shadow-sm border">
        <div class="flex flex-col md:flex-row gap-4 items-start md:items-center justify-between">
            <!-- Búsqueda -->
            <div class="w-full md:w-64">
                <form action="{{ route('admin.movies.index') }}" method="GET">
                    <div class="relative">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Buscar películas..."
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
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}"
                       class="px-3 py-1 text-xs rounded-full {{ request('status') == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Activas
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'inactive']) }}"
                       class="px-3 py-1 text-xs rounded-full {{ request('status') == 'inactive' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Inactivas
                    </a>
                </div>

                <!-- Contador -->
                <div class="text-sm text-gray-600 px-3 py-1 bg-gray-100 rounded-full">
                    {{ $movies->count() }} película(s)
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Películas -->
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Película</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Información</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Género</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estreno</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($movies as $movie)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <!-- Poster y Título -->
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    @if($movie->poster_url)
                                        <img src="{{ Storage::disk('public')->url($movie->poster_url) }}"
                                             alt="{{ $movie->title }}"
                                             class="h-16 w-12 object-cover rounded-lg shadow-sm">
                                    @else
                                        <div class="h-16 w-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-film text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="text-sm font-semibold text-gray-900 truncate">{{ $movie->title }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-clock mr-1"></i>{{ $movie->duration }} min
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Información -->
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                <div class="flex items-center text-xs text-gray-500 mb-1">
                                    <i class="fas fa-user-tie mr-1"></i>
                                    {{ $movie->director }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    <i class="fas fa-users mr-1"></i>
                                    {{ Str::limit($movie->cast, 30) }}
                                </div>
                            </div>
                        </td>

                        <!-- Género -->
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-gray-900">{{ $movie->genre }}</span>
                                @if($movie->genreRelation)
                                    <span class="text-xs text-gray-500">{{ $movie->genreRelation->description }}</span>
                                @endif
                            </div>
                        </td>

                        <!-- Rating -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex items-center text-sm text-gray-900">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    {{ $movie->rating ?? 'N/A' }}/10
                                </div>
                            </div>
                        </td>

                        <!-- Fecha de Estreno -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $movie->release_date->format('d/m/Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $movie->release_date->diffForHumans() }}
                            </div>
                        </td>

                        <!-- Estado -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.movies.toggle-status', $movie) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition-colors {{ $movie->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                    <span class="w-2 h-2 rounded-full mr-1 {{ $movie->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ $movie->is_active ? 'Activa' : 'Inactiva' }}
                                </button>
                            </form>
                            @if($movie->showtimes_count > 0)
                                <div class="text-xs text-blue-600 mt-1">
                                    {{ $movie->showtimes_count }} función(es)
                                </div>
                            @endif
                        </td>

                        <!-- Acciones -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <!-- Ver -->
                                <a href="{{ route('admin.movies.show', $movie) }}"
                                   class="text-blue-600 hover:text-blue-900 transition-colors"
                                   title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Editar -->
                                <a href="{{ route('admin.movies.edit', $movie) }}"
                                   class="text-indigo-600 hover:text-indigo-900 transition-colors"
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Funciones -->
                                <a href="{{ route('admin.showtimes.index') }}?movie={{ $movie->id }}"
                                   class="text-purple-600 hover:text-purple-900 transition-colors"
                                   title="Ver funciones">
                                    <i class="fas fa-calendar-alt"></i>
                                </a>

                                <!-- Eliminar -->
                                @if($movie->showtimes_count == 0)
                                    <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-900 transition-colors"
                                                title="Eliminar"
                                                onclick="return confirm('¿Estás seguro de eliminar esta película?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 cursor-not-allowed" title="No se puede eliminar (tiene funciones)">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <i class="fas fa-film text-4xl mb-4 text-gray-300"></i>
                                <p class="text-lg font-medium mb-2">No hay películas registradas</p>
                                <p class="text-sm mb-4">Comienza agregando una nueva película a la cartelera</p>
                                <a href="{{ route('admin.movies.create') }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-flex items-center text-sm font-medium transition-colors">
                                    <i class="fa-solid fa-plus w-4 h-4 mr-2"></i>
                                    Crear Primera Película
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($movies->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $movies->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
