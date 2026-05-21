<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empresa - MedicClips</title>
    <link rel="stylesheet" href="{{ asset('css/stylesfromlogin.css') }}">
</head>
<body>

<div class="container">

    <!-- IZQUIERDA -->
    <div class="form-side">
        <div class="form-box">

            <!-- LOGO -->
            <div class="logo">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo empresa">
            </div>

            <h2>Registro de Empresa</h2>

            <!-- Alertas de Error de Laravel -->
            @if ($errors->any())
                <div class="alert alert-danger" style="color: #ff4a4a; margin-bottom: 15px; font-size: 0.9em; text-align: left;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('registro.empresa.guardar') }}">
                @csrf

                <label for="nombre_empresa">Nombre de la empresa</label>
                <input type="text" id="nombre_empresa" name="nombre_empresa" value="{{ old('nombre_empresa') }}" placeholder="Ej: Clínica SaludPlus" required>

                <label for="nit">NIT o identificación</label>
                <input type="text" id="nit" name="nit" value="{{ old('nit') }}" placeholder="Ej: 900123456" required>

                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" placeholder="Ej: Calle 10 #20-30" required>

                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}" placeholder="Ej: 3001234567" required>

                <label for="email">Correo empresarial (Usuario Administrador)</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="empresa@email.com" required>

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="********" required>

                <!-- PLAN -->
                <label for="plan">Selecciona tu plan</label>
                <select id="plan" name="plan" required>
                    <option value="">-- Elegir plan --</option>
                    <option value="basico" {{ request('plan') === 'basico' ? 'selected' : '' }}>Básico</option>
                    <option value="pro" {{ request('plan') === 'pro' || !request('plan') ? 'selected' : '' }}>Pro</option>
                    <option value="premium" {{ request('plan') === 'premium' ? 'selected' : '' }}>Premium</option>
                </select>

                <!-- METODO DE PAGO -->
                <label for="pago">Método de pago</label>
                <select id="pago" name="pago" required>
                    <option value="">-- Elegir método --</option>
                    <option value="tarjeta">Tarjeta (crédito/débito)</option>
                    <option value="nequi">Nequi</option>
                    <option value="daviplata">Daviplata</option>
                    <option value="transferencia">Transferencia bancaria</option>
                </select>

                <button type="submit">Crear Cuenta</button>

            </form>

            <p style="margin-top: 15px; font-size: 0.9em; text-align: center; color: #666;">
                ¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}" style="color: #4f46e5; text-decoration: none; font-weight: bold;">Iniciar sesión</a>
            </p>

        </div>
    </div>

    <!-- DERECHA -->
    <div class="image-side">
        <div class="info">
            <h1>Gestiona tu empresa fácil</h1>
            <p>
                Controla usuarios, servicios y operaciones desde un solo lugar.
                Una solución rápida, segura y diseñada para crecer contigo.
            </p>
        </div>
    </div>

</div>

</body>
</html>
