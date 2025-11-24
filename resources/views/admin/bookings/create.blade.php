<x-admin-layout
    title="Crear Reserva - CineLaravel"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Reservas', 'href' => route('admin.bookings.index')],
        ['name' => 'Crear Reserva']
    ]"
    headerTitle="Crear Nueva Reserva"
    headerDescription="Complete el formulario para crear una nueva reserva"
>
    <div class="text-center py-12">
        <i class="fas fa-ticket-alt text-6xl text-gray-400 mb-4"></i>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Módulo en Desarrollo</h3>
        <p class="text-gray-500">La creación de reservas estará disponible próximamente.</p>
    </div>
</x-admin-layout>
