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
                    {{ $movies->total() }} película(s)
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

    <!-- Tabla de Películas -->
    <div class="bg-white shadow-sm rounded-lg border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Película
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Género
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Duración
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Estreno
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
                @forelse($movies as $movie)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <!-- Información de la Película -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded overflow-hidden">
                                    @if($movie->poster_url)
                                        <img src="{{ $movie->poster_url }}"
                                             alt="{{ $movie->title }}"
                                             class="h-12 w-12 object-cover"
                                             onerror="this.style.display='none'">
                                    @endif
                                    @if(!$movie->poster_url || !filter_var($movie->poster_url, FILTER_VALIDATE_URL))
                                        <div class="h-12 w-12 flex items-center justify-center bg-gray-100">
                                            <i class="fas fa-film text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $movie->title }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ Str::limit($movie->description, 50) }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Género -->
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $movie->genre }}
                            </span>
                        </td>

                        <!-- Duración -->
                        <td class="px-6 py-4">
                            <div class="flex items-center text-sm text-gray-900">
                                <i class="fas fa-clock text-gray-400 mr-1"></i>
                                {{ $movie->duration }} min
                            </div>
                        </td>

                        <!-- Fecha de Estreno -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $movie->release_date->format('d/m/Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                @if($movie->release_date->isFuture())
                                    <span class="text-orange-600">En {{ $movie->release_date->diffForHumans() }}</span>
                                @else
                                    <span class="text-green-600">Hace {{ $movie->release_date->diffForHumans() }}</span>
                                @endif
                            </div>
                        </td>

                        <!-- Estado -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.movies.toggle-status', $movie) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition-colors {{ $movie->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}"
                                        onclick="return confirm('¿Estás seguro de cambiar el estado de esta película?')">
                                    <span class="w-2 h-2 rounded-full mr-1 {{ $movie->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ $movie->is_active ? 'Activa' : 'Inactiva' }}
                                </button>
                            </form>
                            @php
                                $showtimesCount = $movie->showtimes()->count();
                            @endphp
                            @if($showtimesCount > 0)
                                <div class="text-xs text-blue-600 mt-1">
                                    {{ $showtimesCount }} función(es)
                                </div>
                            @endif
                        </td>

                        <!-- Acciones -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <!-- Ver -->
                                <a href="{{ route('admin.movies.show', $movie) }}"
                                   class="text-blue-600 hover:text-blue-900 transition-colors p-1 rounded hover:bg-blue-50"
                                   title="Ver detalles">
                                    <i class="fas fa-eye w-4 h-4"></i>
                                </a>

                                <!-- Editar -->
                                <a href="{{ route('admin.movies.edit', $movie) }}"
                                   class="text-indigo-600 hover:text-indigo-900 transition-colors p-1 rounded hover:bg-indigo-50"
                                   title="Editar">
                                    <i class="fas fa-edit w-4 h-4"></i>
                                </a>

                                <!-- Funciones -->
                                <a href="{{ route('admin.showtimes.index') }}?movie={{ $movie->id }}"
                                   class="text-purple-600 hover:text-purple-900 transition-colors p-1 rounded hover:bg-purple-50"
                                   title="Ver funciones">
                                    <i class="fas fa-calendar-alt w-4 h-4"></i>
                                </a>

                                <!-- Eliminar -->
                                @php
                                    $canDelete = $movie->showtimes()->count() == 0;
                                @endphp
                                @if($canDelete)
                                    <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-900 transition-colors p-1 rounded hover:bg-red-50"
                                                title="Eliminar"
                                                onclick="return confirm('¿Estás seguro de eliminar esta película? Esta acción no se puede deshacer.')">
                                            <i class="fas fa-trash w-4 h-4"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 cursor-not-allowed p-1" title="No se puede eliminar (tiene funciones asociadas)">
                <i class="fas fa-trash w-4 h-4"></i>
            </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
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

    <style>
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }
    </style>

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
