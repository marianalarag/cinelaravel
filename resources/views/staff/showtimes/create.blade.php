<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Función') }}
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

                    <form action="{{ route('staff.showtimes.store') }}" method="POST">
                        @csrf

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
                                        <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
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
                                        <option value="{{ $hall->id }}" {{ old('hall_id') == $hall->id ? 'selected' : '' }}>
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
                                       value="{{ old('start_time') }}"
                                       min="{{ now()->format('Y-m-d\TH:i') }}"
                                       class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                <p class="mt-1 text-sm text-gray-500">Debe ser una fecha futura</p>
                            </div>

                            <!-- Fecha y Hora de Fin -->
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                                    Fecha y Hora de Fin *
                                </label>
                                <input type="datetime-local" name="end_time" id="end_time" required
                                       value="{{ old('end_time') }}"
                                       class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                <p class="mt-1 text-sm text-gray-500">Debe ser posterior a la hora de inicio</p>
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
                                           value="{{ old('price') }}"
                                           class="pl-7 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                           placeholder="0.00">
                                </div>
                            </div>

                            <!-- Asientos Disponibles -->
                            <div>
                                <label for="available_seats" class="block text-sm font-medium text-gray-700 mb-2">
                                    Asientos Disponibles *
                                </label>
                                <input type="number" name="available_seats" id="available_seats" required
                                       value="{{ old('available_seats') }}"
                                       class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                       readonly>
                                <p class="mt-1 text-sm text-gray-500" id="capacity-info">
                                    La capacidad se establecerá automáticamente según la sala seleccionada
                                </p>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                            <a href="{{ route('staff.showtimes.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Volver
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-save mr-2"></i>
                                Crear Función
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hallSelect = document.getElementById('hall_id');
            const availableSeats = document.getElementById('available_seats');
            const capacityInfo = document.getElementById('capacity-info');

            function updateCapacity() {
                const selectedOption = hallSelect.options[hallSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    const hallText = selectedOption.text;
                    const capacityMatch = hallText.match(/Capacidad: (\d+)/);

                    if (capacityMatch) {
                        const capacity = capacityMatch[1];
                        availableSeats.value = capacity;
                        capacityInfo.textContent = `Capacidad de la sala: ${capacity} asientos`;
                    }
                } else {
                    availableSeats.value = '';
                    capacityInfo.textContent = 'La capacidad se establecerá automáticamente según la sala seleccionada';
                }
            }

            hallSelect.addEventListener('change', updateCapacity);

            // Inicializar
            updateCapacity();
        });
    </script>
</x-app-layout>
