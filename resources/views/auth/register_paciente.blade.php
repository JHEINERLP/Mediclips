<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Paciente - MedicClips</title>
    <link rel="stylesheet" href="{{ asset('css/stylesfromlogin.css') }}">
</head>
<body>

<div class="container">

    <div class="form-side">
        <div class="form-box">

            <div class="logo">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo">
            </div>

            <h2>Registro de Paciente</h2>
            <p style="color:#666;font-size:0.9em;margin-bottom:20px;">Elige tu clínica, ingresa tu correo y contraseña.</p>

            @if ($errors->any())
                <div class="alert alert-danger" style="color: #ff4a4a; margin-bottom: 15px; font-size: 0.9em; text-align: left;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('registro.paciente.guardar') }}">
                @csrf

                <label for="clinica_id">Clínica</label>
                <select id="clinica_id" name="clinica_id" required>
                    <option value="">-- Selecciona una clínica --</option>
                    @foreach($clinicas as $clinica)
                        <option value="{{ $clinica->id }}" @selected(old('clinica_id') == $clinica->id)>
                            {{ $clinica->nombre }}
                        </option>
                    @endforeach
                </select>
                @if($clinicas->isEmpty())
                    <p style="color:#ff4a4a;font-size:0.85em;">No hay clínicas activas disponibles en este momento.</p>
                @endif

                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="tu@correo.com" required>

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" required>

                <label for="password_confirmation">Confirmar contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>

                <button type="submit" @disabled($clinicas->isEmpty())>Registrarme</button>
            </form>

            <p style="margin-top: 15px; font-size: 0.9em; text-align: center; color: #666;">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" style="color: #4f46e5; text-decoration: none; font-weight: bold;">Iniciar sesión</a>
            </p>
            <p style="font-size: 0.85em; text-align: center; color: #999;">
                ¿Eres una clínica?
                <a href="{{ route('registro.empresa') }}" style="color: #4f46e5;">Registrar empresa</a>
            </p>

        </div>
    </div>

    <div class="image-side">
        <div class="info">
            <h1>Tu salud, más cerca</h1>
            <p>
                Regístrate en la clínica de tu preferencia con tu correo y contraseña,
                y empieza a agendar citas en línea.
            </p>
        </div>
    </div>

</div>

</body>
</html>
