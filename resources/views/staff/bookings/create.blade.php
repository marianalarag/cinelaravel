<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Reserva - Staff') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('staff.bookings.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Cliente -->
                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-700">Cliente *</label>
                                <select name="user_id" id="user_id" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Seleccionar cliente</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Función -->
                            <div>
                                <label for="showtime_id" class="block text-sm font-medium text-gray-700">Función *</label>
                                <select name="showtime_id" id="showtime_id" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Seleccionar función</option>
                                    @foreach($showtimes as $showtime)
                                        <option value="{{ $showtime->id }}" {{ old('showtime_id') == $showtime->id ? 'selected' : '' }}>
                                            {{ $showtime->movie->title }} - {{ $showtime->start_time->format('d/m H:i') }} - Sala {{ $showtime->room->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('showtime_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Número de Tickets -->
                            <div>
                                <label for="number_of_tickets" class="block text-sm font-medium text-gray-700">Número de Tickets *</label>
                                <input type="number" name="number_of_tickets" id="number_of_tickets" min="1" max="10"
                                       value="{{ old('number_of_tickets', 1) }}" required
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('number_of_tickets')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Estado -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Estado *</label>
                                <select name="status" id="status" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : 'selected' }}>Confirmada</option>
                                </select>
                                @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('staff.bookings.index') }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Crear Reserva
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
