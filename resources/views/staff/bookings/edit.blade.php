<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Reserva') }}
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

                    <form action="{{ route('staff.bookings.update', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Información del Cliente -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900">Información del Cliente</h3>

                                <div>
                                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Cliente *
                                    </label>
                                    <select name="user_id" id="user_id" required
                                            class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                        <option value="">Seleccionar Cliente</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('user_id', $booking->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Información de la Función -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900">Información de la Función</h3>

                                <div>
                                    <label for="showtime_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Función *
                                    </label>
                                    <select name="showtime_id" id="showtime_id" required
                                            class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                        <option value="">Seleccionar Función</option>
                                        @foreach($showtimes as $showtime)
                                            <option value="{{ $showtime->id }}"
                                                    data-available="{{ $showtime->available_seats }}"
                                                    data-price="{{ $showtime->price }}"
                                                {{ old('showtime_id', $booking->showtime_id) == $showtime->id ? 'selected' : '' }}>
                                                {{ $showtime->movie->title }} -
                                                {{ $showtime->start_time->format('d/m/Y H:i') }} -
                                                Sala {{ $showtime->hall->name }}
                                                ({{ $showtime->available_seats }} disponibles)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <!-- Número de Entradas -->
                            <div>
                                <label for="number_of_tickets" class="block text-sm font-medium text-gray-700 mb-2">
                                    Número de Entradas *
                                </label>
                                <input type="number" name="number_of_tickets" id="number_of_tickets"
                                       min="1" max="10" required
                                       value="{{ old('number_of_tickets', $booking->number_of_tickets) }}"
                                       class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                <p class="mt-1 text-sm text-gray-500" id="available-seats">
                                    Máximo 10 entradas por reserva
                                </p>
                            </div>

                            <!-- Estado -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Estado *
                                </label>
                                <select name="status" id="status" required
                                        class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                    <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>
                                        Pendiente
                                    </option>
                                    <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>
                                        Confirmada
                                    </option>
                                    <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>
                                        Cancelada
                                    </option>
                                </select>
                            </div>

                            <!-- Precio Total -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Precio Total
                                </label>
                                <div class="p-3 bg-gray-50 rounded-md border border-gray-300">
                                    <p class="text-lg font-semibold text-gray-900" id="total-price">
                                        ${{ number_format($booking->total_amount, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Resumen -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <h4 class="font-semibold text-blue-800 mb-2">Resumen de la Reserva</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p><strong>Película:</strong> <span id="summary-movie">{{ $booking->showtime->movie->title }}</span></p>
                                    <p><strong>Fecha y Hora:</strong> <span id="summary-time">{{ $booking->showtime->start_time->format('d/m/Y H:i') }}</span></p>
                                </div>
                                <div>
                                    <p><strong>Sala:</strong> <span id="summary-hall">{{ $booking->showtime->hall->name ?? 'N/A' }}</span></p>
                                    <p><strong>Asientos Disponibles:</strong> <span id="summary-available">{{ $booking->showtime->available_seats }}</span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                            <a href="{{ route('staff.bookings.show', $booking) }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-times mr-2"></i>
                                Cancelar
                            </a>

                            <div class="flex space-x-3">
                                <a href="{{ route('staff.bookings.show', $booking) }}"
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
            const showtimeSelect = document.getElementById('showtime_id');
            const ticketsInput = document.getElementById('number_of_tickets');
            const totalPrice = document.getElementById('total-price');
            const availableSeats = document.getElementById('available-seats');

            const summaryMovie = document.getElementById('summary-movie');
            const summaryTime = document.getElementById('summary-time');
            const summaryHall = document.getElementById('summary-hall');
            const summaryAvailable = document.getElementById('summary-available');

            function updateSummary() {
                const selectedOption = showtimeSelect.options[showtimeSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    const text = selectedOption.text.split(' - ');
                    summaryMovie.textContent = text[0];
                    summaryTime.textContent = text[1];
                    summaryHall.textContent = text[2]?.split('(')[0] || 'N/A';
                    summaryAvailable.textContent = selectedOption.dataset.available;

                    // Actualizar precio
                    const price = parseFloat(selectedOption.dataset.price) || 0;
                    const tickets = parseInt(ticketsInput.value) || 0;
                    totalPrice.textContent = '$' + (price * tickets).toFixed(2);

                    // Actualizar mensaje de asientos disponibles
                    availableSeats.textContent = `${selectedOption.dataset.available} asientos disponibles en esta función`;
                }
            }

            function updatePrice() {
                const selectedOption = showtimeSelect.options[showtimeSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    const price = parseFloat(selectedOption.dataset.price) || 0;
                    const tickets = parseInt(ticketsInput.value) || 0;
                    totalPrice.textContent = '$' + (price * tickets).toFixed(2);
                }
            }

            showtimeSelect.addEventListener('change', updateSummary);
            ticketsInput.addEventListener('input', updatePrice);

            // Inicializar
            updateSummary();
        });
    </script>
</x-app-layout>
