# Univida - Sistema de Apoyo Psicológico

## Requisitos Previos
- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js y npm (para assets)
- XAMPP o servidor web similar

## Pasos de Instalación

1. **Clonar el Repositorio**
```bash
git clone https://github.com/caro-maguz/Univida.git
cd Univida
```

2. **Instalar Dependencias de PHP**
```bash
composer install
```

3. **Configurar el Entorno**
   - Copiar el archivo de ejemplo de variables de entorno:
   ```bash
   cp .env.example .env
   ```
   - Generar la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```
   - Editar el archivo `.env` con la configuración de tu base de datos:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=univida
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña
   ```

4. **Crear la Base de Datos**
   - Crear una base de datos nueva llamada `univida` (o el nombre que hayas configurado en `.env`)
   - Asegurarte que el usuario tenga permisos sobre la base de datos

5. **Ejecutar las Migraciones**
```bash
php artisan migrate
```

6. **Ejecutar los Seeders**
```bash
php artisan db:seed --class=TipoViolenciaSeeder
```

7. **Instalar Dependencias de Frontend y Compilar Assets** (si es necesario)
```bash
npm install
npm run dev
```

8. **Iniciar el Servidor de Desarrollo**
```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`

## Estructura de la Base de Datos
El sistema incluye las siguientes tablas principales:
- `usuario`: Usuarios del sistema
- `psicologo`: Psicólogos registrados
- `reporte`: Reportes de casos
- `tipo_violencia`: Categorías de violencia
- `chat`: Sistema de chat
- `mensajes`: Mensajes del chat

## Roles y Accesos
- **Usuario**: Puede crear reportes y acceder al chat de apoyo
- **Psicólogo**: Puede ver reportes, marcarlos como resueltos y participar en chats
- **Administrador**: Gestión completa del sistema

## Problemas Comunes y Soluciones

### Error de Permisos
Si encuentras errores de permisos en storage o cache:
```bash
chmod -R 775 storage bootstrap/cache
```

### Error de Clave de Aplicación
Si la aplicación muestra error de clave:
```bash
php artisan key:generate
```

### Limpiar Caché
Si encuentras comportamientos inesperados:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

## Soporte
Para reportar problemas o sugerir mejoras, por favor crear un issue en el repositorio.

## Licencia
Este proyecto es software propietario. Todos los derechos reservados.
