<x-admin-layout
    title="Editar Película - CineLaravel"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Películas', 'href' => route('admin.movies.index')],
        ['name' => 'Editar Película']
    ]"
    headerTitle="Editar Película"
    headerDescription="Actualice la información de la película seleccionada"
>
    <div class="max-w-4xl">
        <form action="{{ route('admin.movies.update', $movie) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Título -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                    <input type="text" name="title" id="title" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('title', $movie->title) }}">
                    @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea name="description" id="description" rows="3" required
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $movie->description) }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Duración -->
                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700">Duración (minutos)</label>
                    <input type="number" name="duration" id="duration" required min="1"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('duration', $movie->duration) }}">
                    @error('duration')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Género -->
                <div>
                    <label for="genre" class="block text-sm font-medium text-gray-700">Género</label>
                    <select name="genre" id="genre" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Seleccionar género</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->name }}" {{ old('genre', $movie->genre) == $genre->name ? 'selected' : '' }}>
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('genre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Director -->
                <div>
                    <label for="director" class="block text-sm font-medium text-gray-700">Director</label>
                    <input type="text" name="director" id="director" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('director', $movie->director) }}">
                    @error('director')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reparto -->
                <div>
                    <label for="cast" class="block text-sm font-medium text-gray-700">Reparto</label>
                    <input type="text" name="cast" id="cast" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('cast', $movie->cast) }}">
                    @error('cast')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rating -->
                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating (0-10)</label>
                    <input type="number" name="rating" id="rating" step="0.1" min="0" max="10"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('rating', $movie->rating) }}">
                    @error('rating')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha de Estreno -->
                <div>
                    <label for="release_date" class="block text-sm font-medium text-gray-700">Fecha de Estreno</label>
                    <input type="date" name="release_date" id="release_date" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('release_date', $movie->release_date->format('Y-m-d')) }}">
                    @error('release_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Poster Actual -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Poster Actual</label>
                    @if($movie->poster_url)
                        <div class="flex items-center space-x-4">
                            <img src="{{ Storage::disk('public')->url($movie->poster_url) }}"
                                 alt="{{ $movie->title }}"
                                 class="h-32 w-24 object-cover rounded-lg shadow-sm">
                            <div class="text-sm text-gray-600">
                                <p>Poster actual de la película</p>
                                <p class="text-xs text-gray-500">Subir un nuevo poster reemplazará este</p>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No hay poster actual</p>
                    @endif
                </div>

                <!-- Nuevo Poster -->
                <div class="md:col-span-2">
                    <label for="poster" class="block text-sm font-medium text-gray-700">Nuevo Poster</label>
                    <input type="file" name="poster" id="poster"
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="mt-1 text-sm text-gray-500">Formatos: JPEG, PNG, JPG, GIF. Máx: 2MB</p>
                    @error('poster')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Trailer URL -->
                <div class="md:col-span-2">
                    <label for="trailer_url" class="block text-sm font-medium text-gray-700">URL del Trailer</label>
                    <input type="url" name="trailer_url" id="trailer_url"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('trailer_url', $movie->trailer_url) }}"
                           placeholder="https://www.youtube.com/watch?v=...">
                    @error('trailer_url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado -->
                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            {{ old('is_active', $movie->is_active) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-600">Película activa (visible en la cartelera)</span>
                    </label>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="mt-8 bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Información de la Película</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <p><strong>ID:</strong> {{ $movie->id }}</p>
                        <p><strong>Creada:</strong> {{ $movie->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p><strong>Actualizada:</strong> {{ $movie->updated_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Funciones:</strong> {{ $movie->showtimes->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.movies.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    <i class="fa-solid fa-save mr-2"></i>
                    Actualizar Película
                </button>
            </div>
        </form>

        <!-- Sección de eliminación -->
        @if($movie->showtimes->count() == 0)
            <div class="mt-8 border-t pt-6">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-red-800 mb-2">Zona de Peligro</h3>
                    <p class="text-sm text-red-600 mb-4">
                        Una vez que elimines esta película, no podrás recuperarla. Esta acción no se puede deshacer.
                    </p>
                    <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors"
                                onclick="return confirm('¿Estás seguro de que quieres eliminar esta película?')">
                            <i class="fa-solid fa-trash mr-2"></i>
                            Eliminar Película
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="mt-8 border-t pt-6">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-yellow-800 mb-2">No se puede eliminar</h3>
                    <p class="text-sm text-yellow-600">
                        Esta película no puede ser eliminada porque tiene {{ $movie->showtimes->count() }} función(es) asociada(s).
                        Primero debes eliminar todas las funciones relacionadas.
                    </p>
                </div>
            </div>
        @endif
    </div>
</x-admin-layout>
