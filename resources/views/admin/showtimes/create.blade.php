<x-admin-layout
    title="Crear Función - CineLaravel"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Funciones', 'href' => route('admin.showtimes.index')],
        ['name' => 'Crear Función']
    ]"
    headerTitle="Crear Nueva Función"
    headerDescription="Programe una nueva función de cine"
>
    <div class="max-w-2xl">
        <form action="{{ route('admin.showtimes.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Película -->
                <div>
                    <label for="movie_id" class="block text-sm font-medium text-gray-700">Película</label>
                    <select name="movie_id" id="movie_id" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Seleccionar película</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
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
                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                {{ $room->name }} ({{ $room->capacity }} asientos) - {{ strtoupper($room->type) }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha y Hora -->
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700">Fecha y Hora de Inicio</label>
                    <input type="datetime-local" name="start_time" id="start_time" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('start_time') }}"
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
                           value="{{ old('price') }}">
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
                        <option value="2D" {{ old('movie_format') == '2D' ? 'selected' : '' }}>2D</option>
                        <option value="3D" {{ old('movie_format') == '3D' ? 'selected' : '' }}>3D</option>
                        <option value="IMAX" {{ old('movie_format') == 'IMAX' ? 'selected' : '' }}>IMAX</option>
                        <option value="4DX" {{ old('movie_format') == '4DX' ? 'selected' : '' }}>4DX</option>
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
                           value="{{ old('language', 'Español') }}">
                    @error('language')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.showtimes.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Crear Función
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
