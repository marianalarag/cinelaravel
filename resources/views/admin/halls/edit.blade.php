<x-admin-layout
    title="Editar Sala - CineLaravel"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Salas', 'href' => route('admin.halls.index')],
        ['name' => 'Editar Sala']
    ]"
    headerTitle="Editar Sala"
    headerDescription="Actualice la información de la sala seleccionada"
>
    <div class="max-w-2xl">
        <form action="{{ route('admin.halls.update', $hall) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Sala</label>
                    <input type="text" name="name" id="name" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('name', $hall->name) }}" placeholder="Sala 1, Sala IMAX, etc.">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Capacidad -->
                <div>
                    <label for="capacity" class="block text-sm font-medium text-gray-700">Capacidad</label>
                    <input type="number" name="capacity" id="capacity" required min="1"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('capacity', $hall->capacity) }}" placeholder="Número de asientos">
                    @error('capacity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipo -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Sala</label>
                    <select name="type" id="type" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Seleccionar tipo</option>
                        <option value="standard" {{ old('type', $hall->type) == 'standard' ? 'selected' : '' }}>Standard</option>
                        <option value="imax" {{ old('type', $hall->type) == 'imax' ? 'selected' : '' }}>IMAX</option>
                        <option value="4dx" {{ old('type', $hall->type) == '4dx' ? 'selected' : '' }}>4DX</option>
                    </select>
                    @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Características -->
                <div class="md:col-span-2">
                    <label for="features" class="block text-sm font-medium text-gray-700">Características</label>
                    <textarea name="features" id="features" rows="3"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Butacas reclinables, Sonido Dolby Atmos, etc.">{{ old('features', $hall->features) }}</textarea>
                    @error('features')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado -->
                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            {{ $hall->is_active ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-600">Sala activa</span>
                    </label>
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.halls.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Actualizar Sala
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
