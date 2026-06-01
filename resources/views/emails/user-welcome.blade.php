<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #334155; }
        .container { max-width: 560px; margin: 0 auto; padding: 24px; }
        .header { background: #2b6df6; color: white; padding: 20px; border-radius: 8px 8px 0 0; text-align: center; }
        .body { background: #f8fafc; padding: 24px; border: 1px solid #e2e8f0; border-top: none; border-radius: 0 0 8px 8px; }
        .btn { display: inline-block; background: #2b6df6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin-top: 16px; }
        .muted { color: #64748b; font-size: 0.9em; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1 style="margin:0;">MedicClips</h1>
    </div>
    <div class="body">
        <p>Hola <strong>{{ $user->name }}</strong>,</p>

        @if($isSelfRegistration)
            <p>Tu registro como <strong>{{ ucfirst($user->rol) }}</strong> en la clínica <strong>{{ $clinica->nombre }}</strong> se completó correctamente.</p>
            <p>Ya puedes iniciar sesión con el correo y la contraseña que registraste.</p>
        @else
            <p>Se ha creado tu cuenta en <strong>{{ $clinica->nombre }}</strong> como <strong>{{ ucfirst($user->rol) }}</strong>.</p>
            <p>Inicia sesión con tu correo <strong>{{ $user->email }}</strong> y la contraseña que te asignó el administrador.</p>
        @endif

        <a href="{{ route('login') }}" class="btn">Iniciar sesión</a>

        <p class="muted" style="margin-top:24px;">Si no esperabas este correo, puedes ignorarlo.</p>
    </div>
</div>
</body>
</html>
