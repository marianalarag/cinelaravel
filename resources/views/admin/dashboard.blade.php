<x-admin-layout
    title="Dashboard - CineLaravel"
    :breadcrumbs="[['name' => 'Dashboard']]"
    headerTitle="Dashboard"
    headerDescription="Bienvenido al sistema de gestión de CineLaravel"
>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Películas -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-film text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Películas</h3>
                    <p class="text-2xl font-bold text-gray-900">45</p>
                </div>
            </div>
        </div>

        <!-- Funciones Hoy -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Funciones Hoy</h3>
                    <p class="text-2xl font-bold text-gray-900">12</p>
                </div>
            </div>
        </div>

        <!-- Reservas Hoy -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-ticket-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Reservas Hoy</h3>
                    <p class="text-2xl font-bold text-gray-900">156</p>
                </div>
            </div>
        </div>

        <!-- Ingresos Hoy -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Ingresos Hoy</h3>
                    <p class="text-2xl font-bold text-gray-900">$2,450</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Películas en Cartelera -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Películas en Cartelera</h3>
            <div class="space-y-4">
                @for($i = 0; $i < 5; $i++)
                    <div class="flex items-center justify-between p-3 border rounded-lg">
                        <div class="flex items-center">
                            <img class="w-12 h-16 rounded object-cover" src="https://via.placeholder.com/48x64" alt="Movie Poster">
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Avengers: Endgame</p>
                                <p class="text-xs text-gray-500">Acción • 3h 1m</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">En cartelera</span>
                    </div>
                @endfor
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones Rápidas</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.movies.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors">
                    <i class="fas fa-film text-2xl text-blue-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Nueva Película</span>
                </a>
                <a href="{{ route('admin.showtimes.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500 hover:bg-green-50 transition-colors">
                    <i class="fas fa-calendar-plus text-2xl text-green-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Nueva Función</span>
                </a>
                <a href="{{ route('admin.halls.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-colors">
                    <i class="fas fa-theater-masks text-2xl text-purple-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Nueva Sala</span>
                </a>
                <a href="{{ route('admin.genres.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-yellow-500 hover:bg-yellow-50 transition-colors">
                    <i class="fas fa-tags text-2xl text-yellow-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Nuevo Género</span>
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>
