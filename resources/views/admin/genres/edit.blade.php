<x-admin-layout
    title="Editar Género - CineLaravel"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Géneros', 'href' => route('admin.genres.index')],
        ['name' => 'Editar Género']
    ]"
    headerTitle="Editar Género"
    headerDescription="Actualice la información del género seleccionado"
>
    <div class="max-w-2xl">
        <form action="{{ route('admin.genres.update', $genre) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Género</label>
                    <input type="text" name="name" id="name" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           value="{{ old('name', $genre->name) }}"
                           placeholder="Acción, Comedia, Drama, etc.">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea name="description" id="description" rows="4"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Descripción del género...">{{ old('description', $genre->description) }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            {{ old('is_active', $genre->is_active) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-600">Género activo</span>
                    </label>
                </div>
            </div>

            <!-- Información del género -->
            <div class="mt-8 bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Género</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <p><strong>ID:</strong> {{ $genre->id }}</p>
                        <p><strong>Creado:</strong> {{ $genre->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p><strong>Actualizado:</strong> {{ $genre->updated_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Películas asociadas:</strong> {{ $genre->movies_count ?? $genre->movies()->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.genres.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    <i class="fa-solid fa-save mr-2"></i>
                    Actualizar Género
                </button>
            </div>
        </form>

        <!-- Sección de eliminación -->
        @if(($genre->movies_count ?? $genre->movies()->count()) == 0)
            <div class="mt-8 border-t pt-6">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-red-800 mb-2">Eliminar Género</h3>
                    <p class="text-sm text-red-600 mb-4">
                        Una vez que elimines este género, no podrás recuperarlo. Esta acción no se puede deshacer.
                    </p>
                    <form action="{{ route('admin.genres.destroy', $genre) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors"
                                onclick="return confirm('¿Estás seguro de que quieres eliminar este género?')">
                            <i class="fa-solid fa-trash mr-2"></i>
                            Eliminar Género
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="mt-8 border-t pt-6">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-yellow-800 mb-2">No se puede eliminar</h3>
                    <p class="text-sm text-yellow-600">
                        Este género no puede ser eliminado porque tiene {{ $genre->movies_count ?? $genre->movies()->count() }} película(s) asociada(s).
                        Primero debes cambiar el género de estas películas o eliminarlas.
                    </p>
                </div>
            </div>
        @endif
    </div>
</x-admin-layout>
