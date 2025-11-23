<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Administración - CineLaravel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Bienvenido al Sistema de Cine</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Gestiona usuarios, películas, salas y funciones desde aquí.
                    </p>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.users.index') }}"
                           class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold">{{ \App\Models\User::count() }}</div>
                            <div>Usuarios</div>
                        </a>

                        <div class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold">0</div>
                            <div>Películas</div>
                        </div>

                        <div class="bg-purple-500 hover:bg-purple-600 text-white p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold">0</div>
                            <div>Funciones</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
