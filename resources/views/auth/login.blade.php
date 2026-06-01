<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MedicClips</title>
    <link rel="stylesheet" href="{{ asset('css/stylesLogin.css') }}">
</head>
<body class="auth-body">

<div class="auth-container">
    <div class="auth-card split">

        <!-- LADO IZQUIERDO -->
        <div class="auth-left">
            <div class="brand">
                <img src="{{ asset('assets/logo.png') }}" class="logo" alt="Logo">
                <h1>MedicClips</h1>
                <p class="slogan">Gestiona tu clínica de forma inteligente</p>
            </div>
        </div>

        <!-- LADO DERECHO -->
        <div class="auth-right">
            <h2>Iniciar sesión</h2>
            <p class="auth-subtitle">Accede a tu cuenta</p>

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

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="ejemplo@correo.com" required autofocus>

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>

                <button type="submit" class="primary">Ingresar</button>
            </form>

            <p class="auth-footer">
                ¿No tienes cuenta?<br>
                <a href="{{ route('registro.paciente') }}">Registrarme como paciente</a>
                &nbsp;·&nbsp;
                <a href="{{ route('registro.empresa') }}">Registrar mi clínica</a>
            </p>
        </div>

    </div>
</div>

</body>
</html>
