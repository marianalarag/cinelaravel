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
                    <select name="genre" id="genre" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Seleccionar género</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->name }}" {{ old('genre') == $genre->name ? 'selected' : '' }}>
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('genre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado -->
                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" checked
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">Película activa</span>
                    </label>
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
            <div class="mb-6">
                <label for="poster_url" class="block text-sm font-medium text-gray-700 mb-2">
                    Póster de la Película
                </label>

                <!-- Input para URL -->
                <div class="mb-4">
                    <input type="url"
                           name="poster_url"
                           id="poster_url"
                           value="{{ old('poster_url', $movie->poster_url ?? '') }}"
                           placeholder="https://ejemplo.com/poster.jpg"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-sm text-gray-500 mt-1">Ingresa la URL de la imagen del póster</p>
                </div>

                <!-- O subir archivo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        O subir archivo
                    </label>
                    <input type="file"
                           name="poster_file"
                           id="poster_file"
                           accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-sm text-gray-500 mt-1">Formatos: JPG, PNG, WEBP (Máx. 2MB)</p>
                </div>

                <!-- Vista previa -->
                @if(isset($movie) && $movie->poster_url)
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-700 mb-2">Vista previa actual:</p>
                        <img src="{{ $movie->poster_url }}"
                             alt="Vista previa"
                             class="h-48 rounded-lg shadow-sm border"
                             onerror="this.style.display='none'">
                    </div>
                @endif
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Columna 1 -->
                <div class="space-y-6">
                    <!-- Campo para subir archivo -->
                    <div>
                        <label for="poster" class="block text-sm font-medium text-gray-700 mb-2">
                            Subir Póster
                        </label>
                        <input type="file"
                               name="poster"
                               id="poster"
                               accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, WEBP (Máx. 2MB)</p>
                    </div>

                    <!-- Campo para URL -->
                    <div>
                        <label for="poster_url" class="block text-sm font-medium text-gray-700 mb-2">
                            O usar URL de imagen
                        </label>
                        <input type="url"
                               name="poster_url"
                               id="poster_url"
                               value="{{ old('poster_url', $movie->poster_url ?? '') }}"
                               placeholder="https://ejemplo.com/poster.jpg"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Ingresa la URL completa de la imagen</p>
                    </div>
                </div>

                <!-- Columna 2 - Vista previa -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Vista Previa
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center h-64 flex items-center justify-center">
                        @if(isset($movie) && $movie->poster_url)
                            <img src="{{ $movie->poster_url }}"
                                 alt="Vista previa"
                                 class="max-h-56 mx-auto rounded shadow-sm"
                                 id="poster-preview"
                                 onerror="document.getElementById('poster-preview').style.display='none'">
                        @else
                            <div class="text-gray-400">
                                <i class="fas fa-image text-3xl mb-2"></i>
                                <p class="text-sm">Vista previa del póster</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
    @push('scripts')
        <script>
            // Vista previa en tiempo real
            document.addEventListener('DOMContentLoaded', function() {
                const posterInput = document.getElementById('poster');
                const posterUrlInput = document.getElementById('poster_url');
                const preview = document.getElementById('poster-preview');

                // Vista previa desde archivo
                if (posterInput) {
                    posterInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                preview.src = e.target.result;
                                preview.style.display = 'block';
                                // Ocultar el placeholder
                                const placeholder = preview.parentElement.querySelector('.text-gray-400');
                                if (placeholder) {
                                    placeholder.style.display = 'none';
                                }
                            }
                            reader.readAsDataURL(file);
                        }
                    });
                }

                // Vista previa desde URL
                if (posterUrlInput) {
                    posterUrlInput.addEventListener('input', function() {
                        if (this.value) {
                            preview.src = this.value;
                            preview.style.display = 'block';
                            // Ocultar el placeholder
                            const placeholder = preview.parentElement.querySelector('.text-gray-400');
                            if (placeholder) {
                                placeholder.style.display = 'none';
                            }
                        } else {
                            preview.style.display = 'none';
                            // Mostrar placeholder
                            const placeholder = preview.parentElement.querySelector('.text-gray-400');
                            if (placeholder) {
                                placeholder.style.display = 'block';
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
</x-admin-layout>
