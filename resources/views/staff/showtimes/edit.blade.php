<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Función') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Alertas -->
                    @if($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                                <div>
                                    <h4 class="text-sm font-medium text-red-800">Por favor corrige los siguientes errores:</h4>
                                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('staff.showtimes.update', $showtime) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Película -->
                            <div>
                                <label for="movie_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Película *
                                </label>
                                <select name="movie_id" id="movie_id" required
                                        class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                    <option value="">Seleccionar Película</option>
                                    @foreach($movies as $movie)
                                        <option value="{{ $movie->id }}"
                                            {{ old('movie_id', $showtime->movie_id) == $movie->id ? 'selected' : '' }}>
                                            {{ $movie->title }} ({{ $movie->duration }} min)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sala -->
                            <div>
                                <label for="hall_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Sala *
                                </label>
                                <select name="hall_id" id="hall_id" required
                                        class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                    <option value="">Seleccionar Sala</option>
                                    @foreach($halls as $hall)
                                        <option value="{{ $hall->id }}"
                                                data-capacity="{{ $hall->capacity }}"
                                            {{ old('hall_id', $showtime->hall_id) == $hall->id ? 'selected' : '' }}>
                                            {{ $hall->name }} (Capacidad: {{ $hall->capacity }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Fecha y Hora de Inicio -->
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                                    Fecha y Hora de Inicio *
                                </label>
                                <input type="datetime-local" name="start_time" id="start_time" required
                                       value="{{ old('start_time', $showtime->start_time->format('Y-m-d\TH:i')) }}"
                                       class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            </div>

                            <!-- Fecha y Hora de Fin -->
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                                    Fecha y Hora de Fin *
                                </label>
                                <input type="datetime-local" name="end_time" id="end_time" required
                                       value="{{ old('end_time', $showtime->end_time->format('Y-m-d\TH:i')) }}"
                                       class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Precio -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Precio por Entrada *
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="price" id="price" step="0.01" min="0" required
                                           value="{{ old('price', $showtime->price) }}"
                                           class="pl-7 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                           placeholder="0.00">
                                </div>
                            </div>

                            <!-- Asientos Disponibles -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Asientos Disponibles
                                </label>
                                <div class="p-3 bg-gray-50 rounded-md border border-gray-300">
                                    <p class="text-lg font-semibold text-gray-900" id="available-seats">
                                        {{ $showtime->available_seats }}
                                    </p>
                                    <p class="text-sm text-gray-600">de <span id="total-capacity">{{ $showtime->hall->capacity ?? 'N/A' }}</span> asientos totales</p>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Resumen -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <h4 class="font-semibold text-blue-800 mb-2">Resumen de la Función</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p><strong>Película:</strong> <span id="summary-movie">{{ $showtime->movie->title }}</span></p>
                                    <p><strong>Duración:</strong> <span id="summary-duration">{{ $showtime->movie->duration }} minutos</span></p>
                                </div>
                                <div>
                                    <p><strong>Sala:</strong> <span id="summary-hall">{{ $showtime->hall->name ?? 'N/A' }}</span></p>
                                    <p><strong>Capacidad:</strong> <span id="summary-capacity">{{ $showtime->hall->capacity ?? 'N/A' }}</span> asientos</p>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                            <a href="{{ route('staff.showtimes.show', $showtime) }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-times mr-2"></i>
                                Cancelar
                            </a>

                            <div class="flex space-x-3">
                                <a href="{{ route('staff.showtimes.show', $showtime) }}"
                                   class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-eye mr-2"></i>
                                    Ver Detalles
                                </a>

                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-save mr-2"></i>
                                    Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const movieSelect = document.getElementById('movie_id');
            const hallSelect = document.getElementById('hall_id');

            const summaryMovie = document.getElementById('summary-movie');
            const summaryDuration = document.getElementById('summary-duration');
            const summaryHall = document.getElementById('summary-hall');
            const summaryCapacity = document.getElementById('summary-capacity');
            const totalCapacity = document.getElementById('total-capacity');
            const availableSeats = document.getElementById('available-seats');

            function updateSummary() {
                // Actualizar película
                const selectedMovie = movieSelect.options[movieSelect.selectedIndex];
                if (selectedMovie && selectedMovie.value) {
                    const movieText = selectedMovie.text.split(' (');
                    summaryMovie.textContent = movieText[0];
                    summaryDuration.textContent = movieText[1]?.replace(' min)', '') + ' minutos' || 'N/A';
                }

                // Actualizar sala
                const selectedHall = hallSelect.options[hallSelect.selectedIndex];
                if (selectedHall && selectedHall.value) {
                    const hallText = selectedHall.text.split(' (');
                    summaryHall.textContent = hallText[0];
                    summaryCapacity.textContent = selectedHall.dataset.capacity;
                    totalCapacity.textContent = selectedHall.dataset.capacity;
                    availableSeats.textContent = selectedHall.dataset.capacity;
                }
            }

            movieSelect.addEventListener('change', updateSummary);
            hallSelect.addEventListener('change', updateSummary);

            // Inicializar
            updateSummary();
        });
    </script>
</x-app-layout>
