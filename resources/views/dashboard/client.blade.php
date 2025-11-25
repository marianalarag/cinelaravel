<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Cuenta - CineLaravel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Bienvenida -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6 bg-gradient-to-r from-blue-500 to-purple-600 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold">¡Bienvenido, {{ Auth::user()->name }}!</h1>
                            <p class="mt-2 opacity-90">Disfruta de la mejor experiencia cinematográfica</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm opacity-90">Miembro desde</p>
                            <p class="font-semibold">{{ Auth::user()->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Cartelera -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Cartelera</h3>
                            <i class="fas fa-film text-blue-500 text-xl"></i>
                        </div>
                        <p class="text-gray-600 mb-4">Descubre las películas en exhibición</p>
                        <a href="{{ route('client.movies.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Ver Cartelera
                        </a>
                    </div>
                </div>

                <!-- Mis Reservas -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Mis Reservas</h3>
                            <i class="fas fa-ticket-alt text-green-500 text-xl"></i>
                        </div>
                        <p class="text-gray-600 mb-4">Gestiona tus entradas y reservas</p>
                        <a href="{{ route('client.bookings.my-bookings') }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Ver Mis Reservas
                        </a>
                    </div>
                </div>

                <!-- Perfil -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Mi Perfil</h3>
                            <i class="fas fa-user-circle text-purple-500 text-xl"></i>
                        </div>
                        <p class="text-gray-600 mb-4">Actualiza tu información personal</p>
                        <a href="{{ route('profile.show') }}"
                           class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Editar Perfil
                        </a>
                    </div>
                </div>
            </div>

            <!-- Próximos Estrenos -->
            <div class="mt-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Próximos Estrenos</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @php
                            $upcomingMovies = \App\Models\Movie::where('release_date', '>', now())
                                ->orderBy('release_date')
                                ->take(4)
                                ->get();
                        @endphp

                        @forelse($upcomingMovies as $movie)
                            <div class="border border-gray-200 rounded-lg p-4 text-center">
                                <div class="bg-gray-200 h-32 rounded-lg mb-3 flex items-center justify-center">
                                    @if($movie->poster_url)
                                        <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <i class="fas fa-film text-gray-400 text-2xl"></i>
                                    @endif
                                </div>
                                <h4 class="font-medium text-gray-900">{{ $movie->title }}</h4>
                                <p class="text-sm text-gray-500">Estreno: {{ $movie->release_date->format('d/m/Y') }}</p>
                            </div>
                        @empty
                            @for($i = 0; $i < 4; $i++)
                                <div class="border border-gray-200 rounded-lg p-4 text-center">
                                    <div class="bg-gray-200 h-32 rounded-lg mb-3 flex items-center justify-center">
                                        <i class="fas fa-film text-gray-400 text-2xl"></i>
                                    </div>
                                    <h4 class="font-medium text-gray-900">Próximamente</h4>
                                    <p class="text-sm text-gray-500">Estreno por confirmar</p>
                                </div>
                            @endfor
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
