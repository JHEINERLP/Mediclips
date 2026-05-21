# 🏥 MedicClips - Guía de Instalación

Plataforma SaaS Multi-Tenant para gestión de clínicas médicas construida con **Laravel + PostgreSQL**.

---

## ✅ Requisitos Previos

Instala las siguientes herramientas antes de comenzar:

| Herramienta | Versión mínima | Descarga |
|-------------|---------------|----------|
| PHP | 8.2+ | https://windows.php.net/download |
| Composer | 2.x | https://getcomposer.org/download |
| PostgreSQL | 14+ | https://www.postgresql.org/download |
| Git | cualquiera | https://git-scm.com/download |

> **Importante:** Asegúrate de que `php` y `composer` estén en el PATH del sistema.

---

## 🚀 Instalación paso a paso

### 1. Clonar el repositorio

```bash
git clone https://github.com/JHEINERLP/Mediclips-.git
cd Mediclips-
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Crear el archivo de entorno

```bash
copy .env.example .env
```

Luego abre `.env` y configura tus credenciales de PostgreSQL:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=Mediclips
DB_USERNAME=postgres
DB_PASSWORD=tu_contraseña
```

### 4. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 5. Crear la base de datos en PostgreSQL

Abre **pgAdmin** o la terminal de PostgreSQL y ejecuta:

```sql
CREATE DATABASE "Mediclips";
```

### 6. Ejecutar las migraciones

```bash
php artisan migrate
```

Esto creará automáticamente las siguientes tablas:
- `clinicas` — Tenants / clínicas registradas
- `users` — Usuarios del sistema (admins, médicos, pacientes)
- `especialidades` — Especialidades médicas
- `medicos` — Perfiles de médicos
- `sessions`, `cache`, `jobs` — Tablas internas de Laravel

### 7. Arrancar el servidor de desarrollo

```bash
php artisan serve
```

Abre el navegador en: **http://127.0.0.1:8000**

---

## 🌐 Páginas disponibles

| Página | URL |
|--------|-----|
| 🏠 Landing Page | http://127.0.0.1:8000 |
| 🔐 Iniciar Sesión | http://127.0.0.1:8000/login |
| 📋 Registro de Empresa | http://127.0.0.1:8000/registro-empresa |

---

## 🛠️ Comandos útiles

```bash
# Ver todas las rutas registradas
php artisan route:list

# Rehacer todas las migraciones desde cero
php artisan migrate:fresh

# Ver estado de las migraciones
php artisan migrate:status

# Limpiar caché
php artisan config:clear
php artisan cache:clear

# Consola interactiva de Laravel
php artisan tinker
```

---

## 📁 Estructura del Proyecto

```
Mediclips/
├── app/
│   └── Models/
│       ├── Clinica.php        # Modelo de clínica (tenant)
│       ├── Especialidad.php   # Especialidades médicas
│       ├── Medico.php         # Perfil de médico
│       └── User.php           # Usuario del sistema
├── database/
│   └── migrations/            # Migraciones de BD
├── public/
│   ├── assets/                # Imágenes y recursos gráficos
│   └── css/                   # Hojas de estilo
├── resources/
│   └── views/
│       ├── welcome.blade.php          # Landing page
│       └── auth/
│           ├── login.blade.php        # Inicio de sesión
│           └── register_company.blade.php  # Registro de empresa
└── routes/
    └── web.php                # Rutas de la aplicación
```

---

## ⚙️ Variables de entorno importantes

| Variable | Descripción | Valor por defecto |
|----------|-------------|-------------------|
| `APP_NAME` | Nombre de la app | MedicClips |
| `APP_ENV` | Entorno | local |
| `APP_DEBUG` | Modo debug | true |
| `DB_CONNECTION` | Motor de BD | pgsql |
| `DB_DATABASE` | Nombre de la BD | Mediclips |
| `SESSION_DRIVER` | Driver de sesiones | database |

---

## 👥 Equipo de Desarrollo

Proyecto académico — MedicClips SaaS © 2026
