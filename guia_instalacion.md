# 🏥 MedicClips — Guía de Instalación Completa

> Plataforma SaaS Multi-Tenant para gestión de clínicas médicas.  
> Construida con **Laravel 12**, **PostgreSQL** y **Vite**.

---

## ✅ Requisitos Previos

Antes de comenzar, asegúrate de tener instaladas las siguientes herramientas:

| Herramienta | Versión mínima | Descarga |
|---|---|---|
| **PHP** | 8.2+ | https://windows.php.net/download |
| **Composer** | 2.x | https://getcomposer.org/download |
| **PostgreSQL** | 14+ | https://www.postgresql.org/download |
| **Node.js** | 18+ | https://nodejs.org |
| **Git** | Cualquiera | https://git-scm.com/download |

> [!IMPORTANT]
> Asegúrate de que `php`, `composer` y `node` estén disponibles en el PATH del sistema.  
> Puedes verificarlo abriendo una terminal y ejecutando: `php -v`, `composer -V`, `node -v`

---

## 🚀 Instalación Paso a Paso

### 1. Clonar el repositorio

```bash
git clone https://github.com/JHEINERLP/Mediclips-.git
cd Mediclips-
```

---

### 2. Instalar dependencias PHP

```bash
composer install
```

---

### 3. Instalar dependencias de Node.js

```bash
npm install
```

---

### 4. Crear el archivo de entorno

```bash
# En Windows (CMD)
copy .env.example .env

# En Windows (PowerShell) / Mac / Linux
cp .env.example .env
```

---

### 5. Generar la clave de la aplicación

```bash
php artisan key:generate
```

---

### 6. Configurar la base de datos PostgreSQL

Abre **pgAdmin** o la terminal de PostgreSQL y ejecuta:

```sql
CREATE DATABASE "Mediclips";
```

Luego abre el archivo `.env` y configura tus credenciales:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=Mediclips
DB_USERNAME=postgres
DB_PASSWORD=tu_contraseña_aqui
```

---

### 7. Ejecutar las migraciones

Esto creará todas las tablas en la base de datos:

```bash
php artisan migrate
```

Las tablas que se crean son:

| Tabla | Descripción |
|---|---|
| `clinicas` | Tenants / clínicas registradas |
| `users` | Usuarios del sistema |
| `especialidades` | Especialidades médicas |
| `medicos` | Perfiles de médicos |
| `horarios` | Horarios de atención |
| `pacientes` | Perfiles de pacientes |
| `medicamentos` | Inventario de medicamentos |
| `citas` | Citas médicas |
| `reportes_clinicos` | Reportes de consultas |
| `recetas` | Recetas médicas |
| `entregas_medicamentos` | Entregas de medicamentos |
| `transaccion_pagos` | Pagos y suscripciones |

---

### 8. Cargar datos de demostración (Seeder)

Para poblar la base de datos con datos de prueba realistas:

```bash
php artisan db:seed
```

> [!TIP]
> Si quieres limpiar todo y empezar desde cero con datos frescos:
> ```bash
> php artisan migrate:fresh --seed
> ```

Esto carga automáticamente:
- **5 Clínicas** con datos completos
- **160 Usuarios** (admins, médicos, pacientes, farmacéuticos)
- **50 Médicos** con especialidades y horarios
- **100 Pacientes** con fichas clínicas
- **200 Citas** (pendientes, completadas, canceladas)
- **150 Medicamentos** en inventario
- **69 Reportes clínicos** y recetas
- **88 Entregas** de medicamentos

---

### 9. Compilar los assets (CSS/JS)

```bash
npm run build
```

---

### 10. Iniciar el servidor de desarrollo

```bash
php artisan serve
```

Abre tu navegador en: **http://127.0.0.1:8000**

---

## 🔐 Credenciales de Acceso (Datos Demo)

Todos los usuarios demo pertenecen a **Clínica Médica Demo**.  
La contraseña es **`password`** para todos.

| Rol | Email | Contraseña | Acceso |
|---|---|---|---|
| 🛡️ **Administrador** | `admin@demo.com` | `password` | Dashboard completo + gestión total |
| 🩺 **Médico** | `medico@demo.com` | `password` | Citas, reportes clínicos, recetas |
| 🧑 **Paciente** | `paciente@demo.com` | `password` | Consulta de sus propias citas |
| 💊 **Farmacéutico** | `farmaceutico@demo.com` | `password` | Medicamentos y entregas |

> [!NOTE]
> Para acceder al login: **http://127.0.0.1:8000/login**

---

## 🌐 Páginas Disponibles

| Página | URL |
|---|---|
| 🏠 Landing Page | http://127.0.0.1:8000 |
| 🔐 Iniciar Sesión | http://127.0.0.1:8000/login |
| 📋 Registro de Empresa | http://127.0.0.1:8000/registro-empresa |
| 🧑 Registro de Paciente | http://127.0.0.1:8000/registro-paciente |
| 📊 Dashboard | http://127.0.0.1:8000/dashboard *(requiere login)* |

---

## 🛠️ Comandos Útiles

```bash
# Iniciar servidor de desarrollo
php artisan serve

# Ver todas las rutas registradas
php artisan route:list

# Rehacer migraciones + recargar datos demo
php artisan migrate:fresh --seed

# Solo recargar datos demo (sin borrar tablas)
php artisan db:seed

# Ver estado de las migraciones
php artisan migrate:status

# Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Consola interactiva de Laravel
php artisan tinker
```

---

## 📁 Estructura del Proyecto

```
Mediclips/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Controladores (Dashboard, Citas, Médicos…)
│   │   └── Middleware/        # EnsureClinica, RoleMiddleware
│   └── Models/                # Clinica, User, Medico, Paciente…
├── database/
│   ├── migrations/            # Migraciones de BD
│   └── seeders/
│       └── DatabaseSeeder.php # Datos de demostración
├── public/
│   ├── assets/                # Imágenes y recursos gráficos
│   └── css/                   # Hojas de estilo
├── resources/
│   └── views/
│       ├── welcome.blade.php          # Landing page
│       ├── dashboard/                 # Vistas del panel
│       └── auth/
│           ├── login.blade.php
│           ├── register_company.blade.php
│           └── register_paciente.blade.php
└── routes/
    └── web.php                # Rutas de la aplicación
```

---

## ⚙️ Variables de Entorno Importantes

| Variable | Descripción | Valor por defecto |
|---|---|---|
| `APP_NAME` | Nombre de la aplicación | `Laravel` |
| `APP_ENV` | Entorno de ejecución | `local` |
| `APP_DEBUG` | Modo debug | `true` |
| `APP_URL` | URL base | `http://localhost` |
| `DB_CONNECTION` | Motor de BD | `pgsql` |
| `DB_HOST` | Host de PostgreSQL | `127.0.0.1` |
| `DB_PORT` | Puerto de PostgreSQL | `5432` |
| `DB_DATABASE` | Nombre de la BD | `Mediclips` |
| `DB_USERNAME` | Usuario de PostgreSQL | `postgres` |
| `DB_PASSWORD` | Contraseña de PostgreSQL | *(tu contraseña)* |
| `SESSION_DRIVER` | Driver de sesiones | `database` |

---

## ❗ Solución de Problemas Comunes

### Error: `SQLSTATE[08006] Connection refused`
→ PostgreSQL no está corriendo. Inicia el servicio desde pgAdmin o ejecuta:
```bash
# Windows (como administrador)
net start postgresql-x64-14
```

### Error: `Class not found` o `Target class does not exist`
→ Limpia y recarga el autoloader:
```bash
composer dump-autoload
php artisan config:clear
```

### Error: `The page has expired due to inactivity` (en formularios)
→ La sesión de base de datos no está configurada. Ejecuta:
```bash
php artisan migrate
```

### La imagen no aparece en la página
→ Verifica que el archivo exista en `public/assets/` y que la ruta en el blade use `{{ asset('assets/nombre.jpg') }}`.

---

## 👥 Equipo de Desarrollo

Otro proyecto de Goldsam— **MedicClips SaaS** © 2026
