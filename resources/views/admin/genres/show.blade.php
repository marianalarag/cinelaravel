<x-admin-layout
    title="{{ $genre->name }} - CineLaravel"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Géneros', 'href' => route('admin.genres.index')],
        ['name' => $genre->name]
    ]"
    headerTitle="{{ $genre->name }}"
    headerDescription="Detalles del género"
>
    <x-slot name="actions">
        <div class="flex space-x-2">
            <a href="{{ route('admin.genres.edit', $genre) }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md inline-flex items-center text-sm font-medium transition-colors shadow-sm">
                <i class="fas fa-edit w-4 h-4 mr-2"></i>
                Editar
            </a>
            <a href="{{ route('admin.genres.index') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md inline-flex items-center text-sm font-medium transition-colors shadow-sm">
                <i class="fas fa-arrow-left w-4 h-4 mr-2"></i>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Información del género -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Género</h3>
            <div class="space-y-3">
                <div>
                    <label class="text-sm font-medium text-gray-500">Nombre</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $genre->name }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Descripción</label>
                    <p class="text-gray-700">{{ $genre->description ?? 'Sin descripción' }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Estado</label>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $genre->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $genre->is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Películas</label>
                    <p class="text-gray-900">{{ $genre->movies_count ?? $genre->movies()->count() }} película(s)</p>
                </div>
            </div>
        </div>

        <!-- Metadatos -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Metadatos</h3>
            <div class="space-y-2 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span>ID:</span>
                    <span>{{ $genre->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Creado:</span>
                    <span>{{ $genre->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Actualizado:</span>
                    <span>{{ $genre->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
