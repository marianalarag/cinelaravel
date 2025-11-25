<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'CineLaravel - Admin' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/c3672ea99d.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Flowbite -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    <!-- Styles para alertas -->
    <style>
        .alert-transition {
            transition: all 0.3s ease-in-out;
        }
        .alert-hidden {
            opacity: 0;
            transform: translateY(-10px);
            height: 0;
            margin: 0;
            padding: 0;
            border: 0;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
<!-- Navigation -->
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="flex ms-2 md:me-24">
                    <img src="https://www.pngplay.com/wp-content/uploads/6/Cinema-Icon-PNG-Clipart-Background.png" class="h-8 me-3" alt="CineLaravel Logo" />
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap">CineLaravel</span>
                </a>
            </div>
            <div class="flex items-center">
                <!-- User Menu -->
                <div class="ms-3 relative">
                    <button id="user-menu-button" type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                        <span class="sr-only">Open user menu</span>
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        @else
                            <div class="size-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </button>

                    <!-- Dropdown menu -->
                    <div id="user-dropdown" class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow">
                        <div class="px-4 py-3">
                            <span class="block text-sm text-gray-900">{{ Auth::user()->name }}</span>
                            <span class="block text-sm text-gray-500 truncate">{{ Auth::user()->email }}</span>
                        </div>
                        <ul class="py-2" aria-labelledby="user-menu-button">
                            <li>
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-circle mr-2 w-4"></i>
                                    Mi Perfil
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-tachometer-alt mr-2 w-4"></i>
                                    Dashboard
                                </a>
                            </li>
                        </ul>
                        <div class="py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2 w-4"></i>
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar -->
@include('layouts.partials.admin-sidebar')

<!-- Main Content -->
<div class="p-4 sm:ml-64">
    <div class="mt-14">
        <!-- Alertas de sesión -->
        @if(session('success'))
            <div id="success-alert" class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 alert-transition">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">
                            {{ session('success') }}
                        </h3>
                    </div>
                    <div class="ml-auto pl-3">
                        <button type="button" class="text-green-600 hover:text-green-800" onclick="hideAlert('success-alert')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div id="error-alert" class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 alert-transition">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            {{ session('error') }}
                        </h3>
                    </div>
                    <div class="ml-auto pl-3">
                        <button type="button" class="text-red-600 hover:text-red-800" onclick="hideAlert('error-alert')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div id="warning-alert" class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4 alert-transition">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">
                            {{ session('warning') }}
                        </h3>
                    </div>
                    <div class="ml-auto pl-3">
                        <button type="button" class="text-yellow-600 hover:text-yellow-800" onclick="hideAlert('warning-alert')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div id="info-alert" class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4 alert-transition">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">
                            {{ session('info') }}
                        </h3>
                    </div>
                    <div class="ml-auto pl-3">
                        <button type="button" class="text-blue-600 hover:text-blue-800" onclick="hideAlert('info-alert')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Breadcrumb -->
        @if(isset($breadcrumbs) && count($breadcrumbs))
            <nav class="mb-6 bg-white p-4 rounded-lg shadow-sm border">
                <ol class="flex flex-wrap text-gray-600 text-sm">
                    @foreach($breadcrumbs as $item)
                        <li class="flex items-center">
                            @unless ($loop->first)
                                <span class="px-2 text-gray-400">/</span>
                            @endunless

                            @isset($item['href'])
                                <a href="{{ $item['href'] }}" class="hover:text-blue-600 transition-colors">
                                    {{ $item['name'] }}
                                </a>
                            @else
                                <span class="font-semibold text-gray-900">{{ $item['name'] }}</span>
                            @endisset
                        </li>
                    @endforeach
                </ol>
            </nav>
        @endif

        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $headerTitle ?? 'Panel de Administración' }}</h1>
                @isset($headerDescription)
                    <p class="text-gray-600 mt-1">{{ $headerDescription }}</p>
                @endisset
            </div>
            <div class="flex items-center space-x-2">
                {{ $actions ?? '' }}
            </div>
        </div>

        <!-- Page Content -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            {{ $slot }}
        </div>
    </div>
</div>

<script>
    // Función para ocultar alertas con animación
    function hideAlert(alertId) {
        const alert = document.getElementById(alertId);
        if (alert) {
            alert.classList.add('alert-hidden');
            setTimeout(() => {
                alert.remove();
            }, 300);
        }
    }

    // Auto-ocultar alertas después de 5 segundos
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('[id$="-alert"]');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert && alert.parentNode) {
                    hideAlert(alert.id);
                }
            }, 5000);
        });
    });

    // Inicializar componentes de Flowbite manualmente si es necesario
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar dropdowns manualmente si Flowbite no lo hace automáticamente
        const dropdownButtons = document.querySelectorAll('[data-dropdown-toggle]');
        dropdownButtons.forEach(button => {
            button.addEventListener('click', function() {
                const dropdownId = this.getAttribute('data-dropdown-toggle');
                const dropdown = document.getElementById(dropdownId);
                if (dropdown) {
                    dropdown.classList.toggle('hidden');
                }
            });
        });

        // Cerrar dropdown al hacer clic fuera
        document.addEventListener('click', function(event) {
            const dropdowns = document.querySelectorAll('[data-dropdown-toggle]');
            dropdowns.forEach(button => {
                const dropdownId = button.getAttribute('data-dropdown-toggle');
                const dropdown = document.getElementById(dropdownId);
                if (dropdown && !button.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });
    });
</script>

@stack('modals')
</body>
</html>
