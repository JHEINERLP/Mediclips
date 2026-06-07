Manual Tecnico del Sistema MedicClips
Version 1.0

---

CONTENIDO

PRESENTACION
RESUMEN
OBJETIVO
FINALIDAD DEL MANUAL
INTRODUCCION
1. ASPECTOS TECNICOS
   1.1. Herramientas utilizadas para el desarrollo
   1.2. Arquitectura del sistema
   1.3. Estructura del proyecto
2. DIAGRAMAS DE MODELAMIENTO
   2.1. Diagrama de clases (entidades)
   2.2. Diagrama de casos de uso
   2.3. Diccionario de datos
3. ASPECTO TECNICO DEL DESARROLLO DEL SISTEMA
   3.1. Instalacion y configuracion local
   3.2. Variables de entorno
   3.3. Migraciones y datos de prueba
   3.4. Ejecucion del servidor
   3.5. Middleware y seguridad por roles
   3.6. Capa de correo
   3.7. Despliegue y control de versiones
4. REQUERIMIENTOS DEL SOFTWARE
   4.1. Requisitos minimos del servidor de desarrollo
   4.2. Requisitos recomendados para produccion
BIBLIOGRAFIA

---

PRESENTACION

El presente manual tecnico documenta el software MedicClips, una aplicacion web SaaS multi-clinica para gestion de citas medicas, usuarios (administrador, medico, paciente, farmaceutico), inventario de medicamentos, reportes clinicos, recetas y entregas de farmacia.

Este documento esta dirigido a desarrolladores, administradores de sistemas y personal tecnico que requiera instalar, mantener, extender o desplegar la solucion. Se describe la arquitectura Laravel 12, el modelo de datos PostgreSQL, la estructura de carpetas, los flujos de autenticacion y las convenciones del codigo fuente ubicado en el repositorio del proyecto.

---

RESUMEN

MedicClips es una aplicacion monolitica desarrollada con Laravel 12 y PHP 8.2+, con interfaz Blade y estilos CSS en public/css. La persistencia se realiza en base de datos relacional (PostgreSQL en entorno de desarrollo documentado; SQLite disponible en .env.example).

El sistema implementa multi-tenancy logico por clinica_id: cada usuario pertenece a una clinica y los datos operativos (medicos, pacientes, citas, medicamentos, etc.) se filtran por ese identificador. Los roles definidos en users.rol son: admin, medico, paciente y farmaceutico.

La capa HTTP incluye controladores RESTful, middleware personalizado (EnsureClinica, CheckRole) y envio de correos mediante UserWelcomeMail y UserInvitationService.

---

OBJETIVO

Documentar de forma clara y estructurada los componentes tecnicos de MedicClips para facilitar el mantenimiento, la instalacion local, la comprension del modelo de datos y la evolucion del software por parte del equipo de desarrollo.

---

FINALIDAD DEL MANUAL

Instruir al lector sobre como esta construido MedicClips, que tecnologias utiliza, como configurar el entorno de desarrollo, como interpretar el esquema de base de datos y como realizar cambios de forma segura respetando el aislamiento por clinica y los permisos por rol.

---

INTRODUCCION

El manual se divide en cuatro bloques principales, alineados con la guia tecnica de referencia:

- ASPECTOS TECNICOS: Stack, arquitectura y estructura de directorios.
- DIAGRAMAS DE MODELAMIENTO: Entidades, actores y diccionario de datos.
- DESARROLLO DEL SISTEMA: Pasos de instalacion, migraciones, servidor y despliegue.
- REQUERIMIENTOS: Hardware y software minimos.

---

1. ASPECTOS TECNICOS

MedicClips centraliza la operacion de una clinica: registro de empresa (tenant), gestion de personal, agenda de citas, atencion clinica (reportes y recetas) y dispensacion de medicamentos con control de inventario.

1.1. HERRAMIENTAS UTILIZADAS PARA EL DESARROLLO

1.1.1. PHP 8.2 o superior
Lenguaje del backend. Laravel 12 requiere PHP ^8.2 con extensiones: BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, Tokenizer, XML.

1.1.2. Laravel Framework 12
Framework MVC. Rutas en routes/web.php, controladores en app/Http/Controllers, modelos Eloquent en app/Models, vistas Blade en resources/views.

1.1.3. Composer
Gestor de dependencias PHP. Archivo composer.json define laravel/framework y paquetes de desarrollo (Pint, Sail, PHPUnit).

1.1.4. PostgreSQL (produccion/desarrollo documentado)
Motor relacional. Tablas definidas en database/migrations. Conexion configurada en .env (DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD).

1.1.5. XAMPP / Apache
Entorno local habitual en Windows. El proyecto puede servirse con php artisan serve (puerto 8000) o virtual host Apache apuntando a public/.

1.1.6. Node.js y Vite (opcional)
package.json incluye Vite y Tailwind para assets; las vistas actuales usan principalmente CSS estatico en public/css.

1.1.7. Git y GitHub
Control de versiones del codigo fuente. Flujo recomendado: rama feature, commit, pull request, merge a main.

1.1.8. Editor (Cursor / Visual Studio Code)
IDE recomendado para edicion de PHP, Blade y configuracion .env.

1.2. ARQUITECTURA DEL SISTEMA

Capas:
- Presentacion: Blade + CSS (public/css/dashboard.css, stylesLogin.css, etc.)
- Aplicacion: Controladores, Middleware, Services (UserInvitationService)
- Dominio: Modelos Eloquent y relaciones
- Infraestructura: PostgreSQL, Mail, Session (driver database), Cache/Jobs (tablas Laravel)

Patron: MVC monolitico. No existe API REST separada (routes/api.php no implementado).

Multi-tenant: Aislamiento por clinica_id en consultas de controladores. Middleware EnsureClinica exige clinica_id en el usuario autenticado.

1.3. ESTRUCTURA DEL PROYECTO

Directorios principales:

- app/Models/          Modelos Eloquent (User, Clinica, Medico, Paciente, Cita, etc.)
- app/Http/Controllers/ Controladores HTTP y Auth
- app/Http/Middleware/   EnsureClinica, CheckRole
- app/Mail/              UserWelcomeMail
- app/Services/          UserInvitationService
- bootstrap/app.php      Registro de middleware y rutas
- database/migrations/   Esquema de base de datos
- database/seeders/      DatabaseSeeder (datos demo)
- resources/views/       Plantillas Blade
- routes/web.php         Definicion de rutas web
- public/                Punto de entrada (index.php), CSS, assets
- storage/logs/          Logs de aplicacion y correo (MAIL_MAILER=log)
- docs/                  Documentacion (manuales)

---

2. DIAGRAMAS DE MODELAMIENTO

2.1. DIAGRAMA DE CLASES (ENTIDADES PRINCIPALES)

Relaciones resumidas:

Clinica 1---* User
Clinica 1---* Medico
Clinica 1---* Paciente
Clinica 1---* Medicamento
Clinica 1---* Cita
Clinica 1---* TransaccionPago

User 1---1 Medico (opcional, rol medico)
User 1---1 Paciente (opcional, rol paciente)
User 1---* EntregaMedicamento (como farmaceutico)

Especialidad 1---* Medico
Medico 1---* Horario
Medico 1---* Cita

Paciente 1---* Cita
Cita 1---1 ReporteClinico
ReporteClinico 1---1 Receta
Receta 1---* EntregaMedicamento
Medicamento 1---* EntregaMedicamento

Funciones por entidad:
- Clinica: Tenant SaaS (nombre, subdominio, plan, estado).
- User: Autenticacion y rol (admin, medico, paciente, farmaceutico).
- Medico / Paciente: Perfiles extendidos del usuario.
- Cita: Agenda medica con estados (pendiente, aceptada, rechazada, cancelada, completada).
- ReporteClinico / Receta: Atencion y prescripcion.
- EntregaMedicamento: Despacho y descuento de stock.

2.2. DIAGRAMA DE CASOS DE USO

Actores:
- Visitante: Registro de empresa, registro de paciente, login.
- Admin de clinica: CRUD medicos, pacientes, farmaceuticos, especialidades, horarios, medicamentos, citas, reportes, recetas, entregas, configuracion clinica.
- Medico: Citas propias, reportes, recetas.
- Paciente: Citas propias, agendar cita.
- Farmaceutico: Medicamentos, entregas.

Casos de uso principales:
- Registrar clinica y administrador
- Autenticarse y cerrar sesion
- Gestionar usuarios por rol
- Agendar y cambiar estado de citas
- Crear reporte clinico desde cita completada
- Emitir receta y registrar entrega de medicamento
- Reenviar correo de aviso a usuarios

2.3. DICCIONARIO DE DATOS

Tabla: clinicas
- id (bigint, PK)
- nombre (string)
- subdominio (string, unique)
- logo_ruta, banner_ruta (string, nullable)
- plan_suscripcion (string, default basico)
- estado (string, default activo)
- vigente_hasta (timestamp, nullable)
- created_at, updated_at

Tabla: users
- id (bigint, PK)
- clinica_id (FK clinicas, nullable)
- name, email (unique), password (hashed)
- email_verified_at (nullable)
- rol (string: admin, medico, paciente, farmaceutico)
- remember_token
- timestamps

Tabla: especialidades
- id, nombre, descripcion, timestamps

Tabla: medicos
- id, user_id (FK unique), clinica_id (FK), especialidad_id (FK)
- numero_licencia, biografia (nullable), timestamps

Tabla: pacientes
- id, usuario_id (FK users unique), clinica_id (FK)
- fecha_nacimiento (date, nullable), genero (nullable)
- grupo_sanguineo, contacto_emergencia (nullable), timestamps

Tabla: horarios
- id, medico_id (FK), dia_semana (1-7), hora_inicio, hora_fin (time), timestamps

Tabla: medicamentos
- id, clinica_id (FK), nombre, codigo_sku, stock (integer), descripcion (nullable)
- unique(clinica_id, codigo_sku), timestamps

Tabla: citas
- id, clinica_id, paciente_id, medico_id (FKs)
- fecha_hora (timestamp), estado (string), motivo (text), timestamps

Tabla: reportes_clinicos
- id, cita_id (FK unique), diagnostico, plan_tratamiento (text), timestamps

Tabla: recetas
- id, reporte_clinico_id (FK unique), instrucciones_generales (nullable), timestamps

Tabla: entregas_medicamentos
- id, receta_id, medicamento_id, farmaceutico_id (FK users)
- cantidad_entregada, entregado_at, timestamps

Tabla: transacciones_pagos
- id, clinica_id (FK), monto (decimal), estado_pago, pagado_at (nullable), timestamps

Tablas Laravel: sessions, cache, jobs, failed_jobs, password_reset_tokens.

---

3. ASPECTO TECNICO DEL DESARROLLO DEL SISTEMA

3.1. INSTALACION Y CONFIGURACION LOCAL

Requisitos previos: PHP 8.2+, Composer, PostgreSQL (o SQLite), Git, Node.js (opcional).

Pasos:

1) Clonar el repositorio en la carpeta de trabajo (ej. C:\xampp\htdocs\Mediclips).

2) Instalar dependencias PHP:
   composer install

3) Copiar entorno:
   copy .env.example .env   (Windows)
   cp .env.example .env     (Linux/Mac)

4) Generar clave de aplicacion:
   php artisan key:generate

5) Configurar base de datos en .env (ejemplo PostgreSQL):
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=Mediclips
   DB_USERNAME=postgres
   DB_PASSWORD=tu_clave

6) Crear la base de datos vacia en PostgreSQL antes de migrar.

7) Ejecutar migraciones y seeder:
   php artisan migrate:fresh --seed

8) Instalar dependencias front (opcional):
   npm install
   npm run build

3.2. VARIABLES DE ENTORNO RELEVANTES

- APP_URL: URL base (http://127.0.0.1:8000)
- APP_DEBUG: true en desarrollo, false en produccion
- DB_*: Conexion a base de datos
- SESSION_DRIVER=database (sesiones en tabla sessions)
- MAIL_MAILER: log (desarrollo) o smtp (produccion)
- MAIL_FROM_ADDRESS, MAIL_FROM_NAME: Remitente de correos

3.3. MIGRACIONES Y DATOS DE PRUEBA

Comando: php artisan migrate
Revertir: php artisan migrate:rollback
Recrear todo: php artisan migrate:fresh --seed

El DatabaseSeeder crea:
- Clinica demo, especialidades, admin@demo.com, medico@demo.com, paciente@demo.com, farmaceutico@demo.com
- Contrasena demo: password

3.4. EJECUCION DEL SERVIDOR

Desarrollo:
   php artisan serve

Acceso: http://127.0.0.1:8000
Login: http://127.0.0.1:8000/login
Registro empresa: /registro-empresa
Registro paciente: /registro-paciente
Health check Laravel: /up

Produccion: configurar Apache/Nginx con DocumentRoot en public/ y permisos de escritura en storage/ y bootstrap/cache/.

3.5. MIDDLEWARE Y SEGURIDAD POR ROLES

Registrados en bootstrap/app.php:
- clinica: App\Http\Middleware\EnsureClinica
- role: App\Http\Middleware\CheckRole

Rutas protegidas con auth + clinica. Subgrupos con role:admin, role:admin,medico, etc.

Los controladores validan clinica_id en recursos (authorizeMedico, authorizePaciente, etc.) para evitar acceso cruzado entre clinicas.

3.6. CAPA DE CORREO

Clases:
- app/Mail/UserWelcomeMail.php
- app/Services/UserInvitationService.php

Vista de correo: resources/views/emails/user-welcome.blade.php

En desarrollo con MAIL_MAILER=log los mensajes aparecen en storage/logs/laravel.log.

3.7. DESPLIEGUE Y CONTROL DE VERSIONES

Flujo Git recomendado:
1. git pull origin main
2. composer install --no-dev --optimize-autoloader (produccion)
3. php artisan migrate --force
4. php artisan config:cache
5. php artisan route:cache
6. php artisan view:cache

No versionar .env ni vendor/. Commits descriptivos por modulo (ej. feat(citas): validacion fecha).

---

4. REQUERIMIENTOS DEL SOFTWARE

4.1. REQUISITOS MINIMOS (DESARROLLO)

- Sistema operativo: Windows 10/11, Linux o macOS
- Procesador: Intel Core i3 o equivalente
- RAM: 4 GB (8 GB recomendado)
- Disco: 2 GB libres (proyecto + vendor + node_modules)
- PHP 8.2+, Composer 2.x, PostgreSQL 13+ (o SQLite 3)
- Navegador: Chrome, Firefox o Edge actualizado
- Resolucion: 1280 x 720 pixeles minimo

4.2. REQUISITOS RECOMENDADOS (PRODUCCION)

- Servidor: 2 vCPU, 4 GB RAM minimo
- PHP-FPM 8.2+ con OPcache habilitado
- PostgreSQL 14+ con backups automaticos
- HTTPS (certificado TLS)
- SMTP para correo transaccional
- Supervisor o systemd para colas (QUEUE_CONNECTION=database) si se usan jobs

---

BIBLIOGRAFIA

- Laravel Documentation. https://laravel.com/docs
- PHP Manual. https://www.php.net/manual/
- PostgreSQL Documentation. https://www.postgresql.org/docs/
- Composer. https://getcomposer.org/doc/
- Git Documentation. https://git-scm.com/doc

Fuente: Documentacion tecnica del proyecto MedicClips.
