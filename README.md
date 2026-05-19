# Integrador - Sistema de Gestión de Envíos

## Requisitos previos
- PHP 8.2 o superior
- Composer
- MySQL (XAMPP o similar)
- Node.js y npm

## Instalación paso a paso

### 1. Clonar el repositorio
```bash
git clone <url-del-repo>
cd integrador
```

### 2. Instalar dependencias PHP
```bash
composer install
```

### 3. Crear el archivo de configuración
```bash
cp .env.example .env
```

### 4. Editar el archivo `.env`
Abre el archivo `.env` y configura estas líneas con tus datos:
```
APP_KEY=                        <- se genera en el paso 5, dejar vacío
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pasoc               <- crear esta BD en MySQL
DB_USERNAME=root
DB_PASSWORD=                    <- tu contraseña de MySQL (XAMPP = vacío)
DB_BACKUP_CONNECTION=sqlite
SESSION_DRIVER=file
```

### 5. Generar la clave de la aplicación
```bash
php artisan key:generate
```

### 6. Crear la base de datos en MySQL
Entra a phpMyAdmin y crea una base de datos llamada: pasoc

### 7. Correr las migraciones (crea todas las tablas)
```bash
php artisan migrate
```

### 8. Crear el archivo de backup SQLite
```bash
php artisan migrate --database=sqlite_backup
```
Este archivo actúa como base de datos de respaldo/replicación local.

### 9. Limpiar caché
```bash
php artisan config:clear
php artisan cache:clear
```

## Acceder al sistema
http://localhost/integrador/public/login

## Notas importantes
- El archivo .env NUNCA se sube a GitHub, cada integrante debe configurar el suyo
- La carpeta vendor/ NUNCA se sube a GitHub, se genera con: composer install
- El archivo database/backup.sqlite se crea en el paso 8 y funciona como replicación local
