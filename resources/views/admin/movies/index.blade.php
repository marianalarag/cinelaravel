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

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poster</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Género</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duración</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estreno</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @forelse($movies as $movie)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($movie->poster_url)
                            <img src="{{ Storage::disk('public')->url($movie->poster_url) }}"
                                 alt="{{ $movie->title }}"
                                 class="h-16 w-12 object-cover rounded">
                        @else
                            <div class="h-16 w-12 bg-gray-200 rounded flex items-center justify-center">
                                <span class="text-gray-400 text-xs">No image</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $movie->title }}</div>
                        <div class="text-sm text-gray-500">{{ $movie->director }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $movie->genre }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $movie->duration }} min</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $movie->rating }}/10</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $movie->release_date->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('admin.movies.toggle-status', $movie) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $movie->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $movie->is_active ? 'Activa' : 'Inactiva' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.movies.edit', $movie) }}"
                               class="text-indigo-600 hover:text-indigo-900">
                                Editar
                            </a>
                            <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('¿Estás seguro de eliminar esta película?')">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                        No hay películas registradas.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
