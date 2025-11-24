<x-admin-layout
    title="Editar Función - CineLaravel"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Funciones', 'href' => route('admin.showtimes.index')],
        ['name' => 'Editar Función']
    ]"
    headerTitle="Editar Función"
    headerDescription="Actualice la información de la función seleccionada"
>
    <div class="max-w-2xl">
        <form action="{{ route('admin.showtimes.update', $showtime) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Película -->
                <div>
                    <label for="movie_id" class="block text-sm font-medium text-gray-700">Película</label>
                    <select name="movie_id" id="movie_id" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Seleccionar película</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}"
                                    {{ old('movie_id', $showtime->movie_id) == $movie->id ? 'selected' : '' }}
                                    data-duration="{{ $movie->duration }}">
                                {{ $movie->title }} ({{ $movie->duration }} min)
                            </option>
                        @endforeach
                    </select>
                    @error('movie_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sala -->
                <div>
                    <label for="room_id" class="block text-sm font-medium text-gray-700">Sala</label>
                    <select name="room_id" id="room_id" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Seleccionar sala</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}"
                                {{ old('room_id', $showtime->room_id) == $room->id ? 'selected' : '' }}>
                                {{ $room->name }} ({{ $room->capacity }} asientos) - {{ strtoupper($room->type) }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha y Hora de Inicio -->
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700">Fecha y Hora de Inicio</label>
                    <input type="datetime-local" name="start_time" id="start_time" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('start_time', $showtime->start_time->format('Y-m-d\TH:i')) }}"
                           min="{{ now()->format('Y-m-d\TH:i') }}">
                    @error('start_time')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Precio -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Precio ($)</label>
                    <input type="number" name="price" id="price" required min="0" step="0.01"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('price', $showtime->price) }}">
                    @error('price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Formato -->
                <div>
                    <label for="movie_format" class="block text-sm font-medium text-gray-700">Formato</label>
                    <select name="movie_format" id="movie_format" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Seleccionar formato</option>
                        <option value="2D" {{ old('movie_format', $showtime->format) == '2D' ? 'selected' : '' }}>2D</option>
                        <option value="3D" {{ old('movie_format', $showtime->format) == '3D' ? 'selected' : '' }}>3D</option>
                        <option value="IMAX" {{ old('movie_format', $showtime->format) == 'IMAX' ? 'selected' : '' }}>IMAX</option>
                        <option value="4DX" {{ old('movie_format', $showtime->format) == '4DX' ? 'selected' : '' }}>4DX</option>
                    </select>
                    @error('movie_format')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Idioma -->
                <div>
                    <label for="language" class="block text-sm font-medium text-gray-700">Idioma</label>
                    <input type="text" name="language" id="language" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('language', $showtime->language) }}">
                    @error('language')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado -->
                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            {{ old('is_active', $showtime->is_active) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-600">Función activa</span>
                    </label>
                </div>
            </div>

            <!-- Información de la función actual -->
            <div class="mt-8 bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Información de la Función</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <p><strong>Película actual:</strong> {{ $showtime->movie->title }}</p>
                        <p><strong>Sala actual:</strong> {{ $showtime->room->name }}</p>
                        <p><strong>Hora de fin calculada:</strong> {{ $showtime->end_time->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p><strong>Asientos disponibles:</strong> {{ $showtime->available_seats }}</p>
                        <p><strong>Creada:</strong> {{ $showtime->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Actualizada:</strong> {{ $showtime->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.showtimes.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    <i class="fa-solid fa-save mr-2"></i>
                    Actualizar Función
                </button>
            </div>
        </form>

        <!-- Sección de eliminación -->
        <div class="mt-8 border-t pt-6">
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <h3 class="text-lg font-medium text-red-800 mb-2">Eliminar Función</h3>
                <p class="text-sm text-red-600 mb-4">
                    Una vez que elimines esta función, no podrás recuperarla. Los usuarios con reservas serán notificados.
                </p>
                <form action="{{ route('admin.showtimes.destroy', $showtime) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors"
                            onclick="return confirm('¿Estás seguro de que quieres eliminar esta función?')">
                        <i class="fa-solid fa-trash mr-2"></i>
                        Eliminar Función
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para calcular hora de fin automáticamente -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const movieSelect = document.getElementById('movie_id');
            const startTimeInput = document.getElementById('start_time');

            function updateEndTime() {
                const selectedOption = movieSelect.options[movieSelect.selectedIndex];
                const duration = selectedOption.getAttribute('data-duration');
                const startTime = startTimeInput.value;

                if (duration && startTime) {
                    const start = new Date(startTime);
                    const end = new Date(start.getTime() + (parseInt(duration) + 30) * 60000); // +30min para limpieza

                    // Mostrar información de la hora de fin calculada
                    const endTimeElement = document.getElementById('end-time-info');
                    if (endTimeElement) {
                        endTimeElement.textContent = 'Hora de fin calculada: ' + end.toLocaleString('es-ES');
                    }
                }
            }

            movieSelect.addEventListener('change', updateEndTime);
            startTimeInput.addEventListener('change', updateEndTime);

            // Ejecutar al cargar la página
            updateEndTime();
        });
    </script>
</x-admin-layout>
