<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-tachometer-alt w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : '' }}"></i>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>

            <!-- Películas -->
            <li>
                <a href="{{ route('admin.movies.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('admin.movies.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-film w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ request()->routeIs('admin.movies.*') ? 'text-blue-600' : '' }}"></i>
                    <span class="ms-3">Películas</span>
                </a>
            </li>

            <!-- Salas -->
            <li>
                <a href="{{ route('admin.halls.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('admin.halls.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-theater-masks w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ request()->routeIs('admin.halls.*') ? 'text-blue-600' : '' }}"></i>
                    <span class="ms-3">Salas</span>
                </a>
            </li>

            <!-- Funciones -->
            <li>
                <a href="{{ route('admin.showtimes.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('admin.showtimes.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-calendar-alt w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ request()->routeIs('admin.showtimes.*') ? 'text-blue-600' : '' }}"></i>
                    <span class="ms-3">Funciones</span>
                </a>
            </li>

            <!-- Géneros -->
            <li>
                <a href="{{ route('admin.genres.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('admin.genres.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-tags w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ request()->routeIs('admin.genres.*') ? 'text-blue-600' : '' }}"></i>
                    <span class="ms-3">Géneros</span>
                </a>
            </li>

            <!-- Reservas -->
            <li>
                <a href="{{ route('admin.bookings.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('admin.bookings.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-ticket-alt w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ request()->routeIs('admin.bookings.*') ? 'text-blue-600' : '' }}"></i>
                    <span class="ms-3">Reservas</span>
                </a>
            </li>

            <!-- Usuarios -->
            <li>
                <a href="{{ route('admin.users.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-users w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ request()->routeIs('admin.users.*') ? 'text-blue-600' : '' }}"></i>
                    <span class="ms-3">Usuarios</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
