Manual de Usuario — MedicClips (Administrador de Clínica)
Versión 1.0

---

## Alcance
Este documento describe el uso de **MedicClips** desde el perfil **Administrador de Clínica (Admin)**, que es el usuario que se registra por primera vez para crear una clínica y luego administra:

- Usuarios (médicos, pacientes, farmacéuticos)
- Especialidades
- Horarios médicos
- Inventario de medicamentos
- Citas médicas
- Reportes clínicos, recetas y entregas de medicamentos
- Configuración básica de la clínica

---

## Tabla de Contenido
INTRODUCCIÓN  
1. ENTRADA AL SISTEMA (LOGIN)  
2. REGISTRO DE CLÍNICA (ADMIN)  
3. DASHBOARD (PANEL PRINCIPAL)  
4. GESTIÓN DE MÉDICOS  
5. GESTIÓN DE PACIENTES  
6. GESTIÓN DE FARMACÉUTICOS  
7. GESTIÓN DE ESPECIALIDADES  
8. GESTIÓN DE HORARIOS  
9. GESTIÓN DE MEDICAMENTOS  
10. GESTIÓN DE CITAS  
11. REPORTES CLÍNICOS  
12. RECETAS  
13. ENTREGAS DE MEDICAMENTOS  
14. CONFIGURACIÓN DE MI CLÍNICA  
15. CORREOS (AVISO Y REENVÍO)  
16. CERRAR SESIÓN  

---

## INTRODUCCIÓN
MedicClips es una aplicación web para gestionar una clínica en un solo lugar. El **Administrador de Clínica** es el perfil que configura la clínica, registra usuarios y controla la operación (citas, inventario, reportes, recetas y entregas).

En el menú lateral (sidebar) del sistema, el Admin tiene acceso a los módulos principales:

- Médicos
- Pacientes
- Farmacéuticos
- Especialidades
- Horarios
- Medicamentos
- Citas
- Reportes
- Recetas
- Entregas
- Mi Clínica

> Nota: Otros perfiles (médico, paciente, farmacéutico) ven solo los módulos que les corresponden.

---

## 1. ENTRADA AL SISTEMA (LOGIN)
1. Abra la aplicación y diríjase a la pantalla de inicio de sesión:  
   `http://127.0.0.1:8000/login`
2. Ingrese su **correo** y **contraseña**.
3. Presione el botón **Ingresar**.

Si el usuario y contraseña son válidos, será redirigido al **Dashboard**.

---

## 2. REGISTRO DE CLÍNICA (ADMIN)
Para crear una clínica y el primer usuario Admin:
1. Abra el formulario de registro de empresa/clínica:  
   `http://127.0.0.1:8000/registro-empresa`
2. Complete:
   - **Nombre de la empresa**
   - **Subdominio** (único)
   - **Correo empresarial** (se usará como usuario admin)
   - **Contraseña**
   - **Plan** (básico / pro / premium)
   - **Método de pago** (selección)
3. Presione **Crear Cuenta**.

Resultado:
- Se crea la **Clínica**
- Se crea el usuario **Admin** asociado a esa clínica
- Se genera un registro de transacción de pago inicial
- Se envía un **correo de confirmación** (en desarrollo queda en logs)

---

## 3. DASHBOARD (PANEL PRINCIPAL)
En el Dashboard el Admin observa indicadores y accesos rápidos, por ejemplo:
- Cantidad de médicos y pacientes
- Citas pendientes
- Alertas de stock bajo (si aplica)

Recomendación: use el Dashboard como punto de inicio para navegar a cada módulo desde el menú lateral.

---

## 4. GESTIÓN DE MÉDICOS
Ruta del módulo: **Médicos** (menú lateral)

### 4.1 Listado de médicos
La pantalla muestra nombre, correo, especialidad, licencia y acciones:
- Ver
- Editar
- Reenviar correo
- Eliminar

### 4.2 Crear médico
1. Clic en **Nuevo médico**
2. Complete:
   - Nombre
   - Email
   - Contraseña (la define el admin)
   - Especialidad
   - Número de licencia
   - Biografía (opcional)
3. Clic en **Guardar**

Resultado:
- Se crea un `User` con rol `medico`
- Se crea el perfil `Medico`
- Se envía **correo de aviso** al médico (sin contraseña)

### 4.3 Reenviar correo
En el listado de médicos, clic en **Reenviar correo** para reenviar el aviso (no cambia contraseñas).

### 4.4 Editar y eliminar
- **Editar** permite actualizar datos del médico y (opcionalmente) asignar nueva contraseña.
- **Eliminar** borra el usuario y el perfil del médico.

---

## 5. GESTIÓN DE PACIENTES
Ruta del módulo: **Pacientes** (menú lateral)

### 5.1 Crear paciente (por admin)
1. Clic en **Nuevo paciente**
2. Complete:
   - Nombre
   - Email
   - Contraseña (la define el admin)
   - Fecha nacimiento / Género (si están disponibles)
   - Datos opcionales (grupo sanguíneo, contacto emergencia)
3. Clic en **Guardar**

Resultado:
- Se crea un `User` con rol `paciente`
- Se crea el perfil `Paciente`
- Se envía **correo de aviso** (sin contraseña)

### 5.2 Autoregistro de paciente (público)
Los pacientes también pueden crear su cuenta en:
`http://127.0.0.1:8000/registro-paciente`

Allí el paciente selecciona:
- Clínica
- Correo
- Contraseña

### 5.3 Reenviar correo
Desde el listado: **Reenviar correo** al paciente.

---

## 6. GESTIÓN DE FARMACÉUTICOS
Ruta del módulo: **Farmacéuticos**

### 6.1 Crear farmacéutico
1. Clic **Nuevo farmacéutico**
2. Complete:
   - Nombre
   - Email
   - Contraseña (la define el admin)
3. Clic **Guardar**

Resultado:
- Se crea un `User` con rol `farmaceutico`
- Se envía **correo de aviso**

### 6.2 Reenviar correo / editar / eliminar
Disponible desde el listado.

---

## 7. GESTIÓN DE ESPECIALIDADES
Ruta del módulo: **Especialidades**

Permite:
- Crear especialidades (ej. Cardiología, Pediatría)
- Editar
- Eliminar (si no tiene médicos asociados)

---

## 8. GESTIÓN DE HORARIOS
Ruta del módulo: **Horarios**

Permite registrar horarios por médico:
- Médico
- Día de la semana (1 a 7)
- Hora inicio / hora fin

---

## 9. GESTIÓN DE MEDICAMENTOS
Ruta del módulo: **Medicamentos**

Permite administrar inventario por clínica:
- Crear medicamento (Nombre, SKU, Stock, Descripción)
- Editar
- Eliminar

Recomendación: Mantenga el stock actualizado para evitar entregas con stock insuficiente.

---

## 10. GESTIÓN DE CITAS
Ruta del módulo: **Citas**

### 10.1 Agendar cita
1. Clic en **Agendar cita**
2. Seleccione:
   - Paciente
   - Médico
   - Fecha y hora (debe ser igual o posterior a “ahora”)
   - Motivo
3. Clic **Agendar**

### 10.2 Cambiar estado
En el detalle de la cita puede cambiarse a:
- pendiente
- aceptada
- rechazada
- cancelada
- completada

### 10.3 Crear reporte desde cita completada
Si una cita está **completada**, el sistema permite crear el **reporte clínico**.

---

## 11. REPORTES CLÍNICOS
Ruta: **Reportes**

Permite:
- Crear reporte asociándolo a una cita completada
- Registrar diagnóstico y plan de tratamiento
- Editar y consultar reportes

---

## 12. RECETAS
Ruta: **Recetas**

Una receta se crea desde un reporte clínico.
Permite registrar instrucciones generales y consultar entregas asociadas.

---

## 13. ENTREGAS DE MEDICAMENTOS
Ruta: **Entregas**

Permite:
- Seleccionar receta
- Seleccionar medicamento
- Cantidad entregada

El stock del medicamento se descuenta automáticamente.

---

## 14. CONFIGURACIÓN DE MI CLÍNICA
Ruta: **Mi Clínica**

Permite actualizar:
- Nombre
- Subdominio
- Plan
- Estado

---

## 15. CORREOS (AVISO Y REENVÍO)
El sistema envía correos en acciones como:
- Registro de clínica (confirmación)
- Creación de usuarios por admin (aviso)
- Autoregistro de paciente (confirmación)
- Reenvío manual desde listados (Reenviar correo)

En desarrollo, el correo suele configurarse con `MAIL_MAILER=log`, por lo que los correos quedan en:
`storage/logs/laravel.log`

---

## 16. CERRAR SESIÓN
En la parte superior derecha del Dashboard, presione **Salir**.

