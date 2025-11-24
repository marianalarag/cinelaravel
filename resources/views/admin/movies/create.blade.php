<x-admin-layout
    title="Crear Película - CineLaravel"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Películas', 'href' => route('admin.movies.index')],
        ['name' => 'Crear Película']
    ]"
    headerTitle="Crear Nueva Película"
    headerDescription="Agregue una nueva película a la cartelera del cine"
>
    <div class="max-w-4xl">
        <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Título -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                    <input type="text" name="title" id="title" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('title') }}">
                    @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea name="description" id="description" rows="3" required
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Duración -->
                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700">Duración (minutos)</label>
                    <input type="number" name="duration" id="duration" required min="1"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('duration') }}">
                    @error('duration')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Género -->
                <div>
                    <label for="genre" class="block text-sm font-medium text-gray-700">Género</label>
                    <input type="text" name="genre" id="genre" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('genre') }}">
                    @error('genre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Director -->
                <div>
                    <label for="director" class="block text-sm font-medium text-gray-700">Director</label>
                    <input type="text" name="director" id="director" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('director') }}">
                    @error('director')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reparto -->
                <div>
                    <label for="cast" class="block text-sm font-medium text-gray-700">Reparto</label>
                    <input type="text" name="cast" id="cast" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('cast') }}">
                    @error('cast')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rating -->
                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating (0-10)</label>
                    <input type="number" name="rating" id="rating" step="0.1" min="0" max="10"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('rating') }}">
                    @error('rating')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha de Estreno -->
                <div>
                    <label for="release_date" class="block text-sm font-medium text-gray-700">Fecha de Estreno</label>
                    <input type="date" name="release_date" id="release_date" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('release_date') }}">
                    @error('release_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Poster -->
                <div>
                    <label for="poster" class="block text-sm font-medium text-gray-700">Poster</label>
                    <input type="file" name="poster" id="poster"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    @error('poster')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Trailer URL -->
                <div>
                    <label for="trailer_url" class="block text-sm font-medium text-gray-700">URL del Trailer</label>
                    <input type="url" name="trailer_url" id="trailer_url"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('trailer_url') }}">
                    @error('trailer_url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.movies.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Crear Película
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
