# CineLaravel - Sistema de Gestión de Cine

Sistema completo de gestión para cine desarrollado en Laravel con roles de usuario y módulos administrativos.

## Características

- **Autenticación** con JetStream
- **Gestión de Roles**: admin, staff, client
- **Módulo de Películas**: CRUD completo
- **Módulo de Salas**: Tipos standard, IMAX, 4DX
- **Módulo de Funciones**: Gestión de horarios y disponibilidad
- **Validaciones**: Conflictos de horarios en salas

## Instalación

1. ### Clonar repositorio
   ```bash
    git clone https://github.com/tuusuario/cinelaravel.git
    cd cinelaravel 
    ```
2. ### Instalar dependencias ###
   ```bash
        composer install
   ```   
   
3. ### Configurar entorno ###

   ```bash
        cp .env.example .env
        php artisan key:generate
        Configurar base de datos
   ```
   ```bash
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=cinelaravel
        DB_USERNAME=root
        DB_PASSWORD=
        Ejecutar migraciones y seeders
   ```
   ```bash
        php artisan migrate --seed
   ```

4. ### Iniciar servidor ###

   ```bash
        php artisan serve
   ```
### Usuarios de Prueba ###
**Administrador: admin@cinelaravel.com / password**

**Staff: staff@cinelaravel.com / password**

**Cliente: cliente@cinelaravel.com / password**
