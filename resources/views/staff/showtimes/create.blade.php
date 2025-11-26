<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Función - Staff</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
<div class="min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="{{ route('staff.showtimes.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                        ← Volver a Funciones
                    </a>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Crear Nueva Función</h1>
            </div>
        </div>
    </header>

    <!-- Form -->
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <h3 class="text-red-800 font-semibold mb-2">Por favor corrige los siguientes errores:</h3>
                    <ul class="list-disc list-inside text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('staff.showtimes.store') }}" method="POST">
                @csrf

                <!-- Película -->
                <div class="mb-6">
                    <label for="movie_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Película *
                    </label>
                    <select name="movie_id" id="movie_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccionar Película</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
                                {{ $movie->title }} ({{ $movie->duration }} min)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sala -->
                <div class="mb-6">
                    <label for="room_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Sala *
                    </label>
                    <select name="room_id" id="room_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccionar Sala</option>
                        @foreach($halls as $hall)
                            <option value="{{ $hall->id }}" {{ old('room_id') == $hall->id ? 'selected' : '' }}>
                                {{ $hall->name }} (Capacidad: {{ $hall->capacity }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Fecha y Hora -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Fecha *
                        </label>
                        <input type="date" name="start_date" id="start_date" required
                               value="{{ old('start_date') }}"
                               min="{{ now()->format('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Hora *
                        </label>
                        <input type="time" name="start_time" id="start_time" required
                               value="{{ old('start_time') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Precio y Asientos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Precio por Asiento ($) *
                        </label>
                        <input type="number" name="price" id="price" required step="0.01" min="0"
                               value="{{ old('price') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Ej: 12.50">
                    </div>

                    <div>
                        <label for="available_seats" class="block text-sm font-medium text-gray-700 mb-2">
                            Asientos Disponibles *
                        </label>
                        <input type="number" name="available_seats" id="available_seats" required min="1"
                               value="{{ old('available_seats') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Ej: 100">
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('staff.showtimes.index') }}"
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Crear Función
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('start_date');
        const timeInput = document.getElementById('start_time');

        if (!dateInput.value) {
            dateInput.value = new Date().toISOString().split('T')[0];
        }

        if (!timeInput.value) {
            const now = new Date();
            now.setMinutes(now.getMinutes() + 30);
            timeInput.value = now.toTimeString().slice(0, 5);
        }
    });
</script>
</body>
</html>
