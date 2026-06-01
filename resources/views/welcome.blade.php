<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedicClips</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
    <div class="logo">
        <img src="{{ asset('assets/logo.png') }}" alt="MedicClips logo">
        <span>MedicClips</span>
    </div>
    <nav>
        <a href="#funcionalidades">Funcionalidades</a>
        <a href="#como-funciona">Cómo funciona</a>
        <a href="#beneficios">Beneficios</a>
        <a href="#planes">Planes</a>
    </nav>
    <div class="nav-buttons">
        <a href="{{ route('login') }}">Iniciar sesión</a>
        <a href="{{ route('registro.paciente') }}">Soy paciente</a>
        <a href="{{ route('registro.empresa') }}" class="btn-start">Comenzar gratis</a>
    </div>
</header>

<!-- HERO -->
<section class="hero">
    <h1>Gestiona tu clínica de forma inteligente</h1>
    <p>Administra citas, pacientes, doctores y pagos en un solo lugar con nuestra plataforma segura y moderna.</p>
    
    <div class="hero-buttons">
        <a href="{{ route('registro.empresa') }}" class="btn-hero-primary">Comenzar gratis</a>
        <a href="{{ route('registro.paciente') }}" class="secondary" style="text-decoration:none;display:inline-block;">Registrarme como paciente</a>
    </div>

    <div class="hero-image">
        <img src="https://via.placeholder.com/800x400" alt="dashboard">
    </div>
</section>

<!-- SERVICIOS / FUNCIONALIDADES -->
<section class="services" id="funcionalidades">
    <h2>Todo lo que necesitas en un solo lugar</h2>
    <div class="cards">
        <div class="card">
            <img src="{{ asset('assets/clinicas1.png') }}" class="card-icon" alt="Gestión de clínicas">
            <h3>Gestión de clínicas</h3>
            <p>Controla múltiples sedes desde una sola plataforma de forma rápida y eficiente.</p>
        </div>
        <div class="card">
            <img src="{{ asset('assets/medico1.png') }}" class="card-icon" alt="Gestión de doctores">
            <h3>Gestión de doctores</h3>
            <p>Administra perfiles, horarios y especialidades del equipo médico.</p>
        </div>
        <div class="card">
            <img src="{{ asset('assets/personas1.png') }}" class="card-icon" alt="Gestión de pacientes">
            <h3>Gestión de pacientes</h3>
            <p>Organiza historia clínica y seguimiento de pacientes.</p>
        </div>
        <div class="card">
            <img src="{{ asset('assets/citas1.png') }}" class="card-icon" alt="Citas médicas">
            <h3>Citas médicas</h3>
            <p>Agendamiento eficiente y control de agendas médicas sin duplicidades.</p>
        </div>
        <div class="card">
            <img src="{{ asset('assets/pagos1.png') }}" class="card-icon" alt="Pagos y suscripciones">
            <h3>Pagos y suscripciones</h3>
            <p>Controla los costos mensuales y administra la facturación del SaaS.</p>
        </div>
        <div class="card">
            <img src="{{ asset('assets/noti1.png') }}" class="card-icon" alt="Notificaciones">
            <h3>Notificaciones</h3>
            <p>Notifica a tus pacientes y médicos sobre el estado de sus citas.</p>
        </div>
    </div>
</section>

<!-- SEGURIDAD -->
<section class="security" id="como-funciona">
    <div class="security-container">
        <div class="security-text">
            <h2>Plataforma segura y rápida</h2>
            <p>Arquitectura moderna, cifrado y alto rendimiento.</p>
            <ul>
                <li>Arquitectura Multi-tenant aislada</li>
                <li>Cifrado y protección de expedientes médicos</li>
                <li>Navegación fluida y en tiempo real</li> 
            </ul>
        </div>
        <div class="security-image">
            <img src="{{ asset('assets/medicina.jpg') }}" alt="Seguridad">
        </div>
    </div>
</section>

<!-- BENEFICIOS -->
<section class="benefits" id="beneficios">
    <h2>¿Por qué elegir MedicClips?</h2>

    <div class="benefits-grid">
        <div class="benefit-card">
            <img src="{{ asset('assets/1b.png') }}" class="icon" alt="Ahorro">
            <h3>Ahorro de tiempo</h3>
            <p>Controla múltiples sedes desde una sola plataforma de forma rápida y eficiente.</p>
        </div>
        <div class="benefit-card">
            <img src="{{ asset('assets/2b.png') }}" class="icon" alt="Automatización">
            <h3>Automatización</h3>
            <p>Administra perfiles, horarios y especialidades del equipo médico.</p>
        </div>
        <div class="benefit-card">
            <img src="{{ asset('assets/3b.png') }}" class="icon" alt="Seguridad">
            <h3>Seguridad de datos</h3>
            <p>Organiza historia clínica y seguimiento de pacientes de forma privada.</p>
        </div>
        <div class="benefit-card">
            <img src="{{ asset('assets/4b.png') }}" class="icon" alt="Fácil">
            <h3>Fácil de usar</h3>
            <p>Interfaz intuitiva y moderna para todo tu equipo.</p>
        </div>
    </div>
</section>

<!-- PLANES -->
<section class="plans" id="planes">
    <h2>Planes simples y transparentes</h2>
    <p class="subtitle">Elige el plan que mejor se adapte a tu clínica</p>

    <div class="plan-cards">
        <div class="plan">
            <h3>Básico</h3>
            <p class="price">$0 <span>/ mes</span></p>
            <ul>
                <li>✔ 1 clínica</li>
                <li>✔ Gestión de pacientes</li>
                <li>✔ Agenda básica</li>
                <li>✔ Soporte limitado</li>
            </ul>
            <a href="{{ route('registro.empresa') }}?plan=basico" class="btn-plan-secondary">Empezar</a>
        </div>

        <div class="plan active">
            <h3>Pro</h3>
            <p class="price">$49 <span>/ mes</span></p>
            <ul>
                <li>✔ Clínicas ilimitadas</li>
                <li>✔ Gestión completa</li>
                <li>✔ Agenda avanzada</li>
                <li>✔ Notificaciones automáticas</li>
                <li>✔ Soporte prioritario</li>
            </ul>
            <a href="{{ route('registro.empresa') }}?plan=pro" class="btn-plan-primary">Elegir plan</a>
        </div>

        <div class="plan">
            <h3>Empresarial</h3>
            <p class="price">$149 <span>/ mes</span></p>
            <ul>
                <li>✔ Todo del plan Pro</li>
                <li>✔ Multiusuarios</li>
                <li>✔ Reportes avanzados</li>
                <li>✔ Integraciones</li>
                <li>✔ Soporte 24/7</li>
            </ul>
            <a href="{{ route('registro.empresa') }}?plan=premium" class="btn-plan-secondary">Contactar</a>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-brand">
            <div class="logo-name">
                <img src="{{ asset('assets/logo.png') }}" alt="MedicClips Logo" class="footer-logo">
                <h3>MedicClips</h3>
            </div>
            <p class="footer-desc">
                Plataforma moderna para la gestión de clínicas, diseñada 
                para optimizar procesos y mejorar la atención médica.
            </p>
        </div>

        <div class="footer-links">
            <h4>Producto</h4>
            <a href="#funcionalidades">Funcionalidades</a>
            <a href="#planes">Planes</a>
            <a href="#como-funciona">Seguridad</a>
        </div>

        <div class="footer-links">
            <h4>Compañía</h4>
            <a href="#">Nosotros</a>
            <a href="#">Contacto</a>
            <a href="#">Soporte</a>
        </div>

        <div class="footer-links">
            <h4>Legal</h4>
            <a href="#">Privacidad</a>
            <a href="#">Términos</a>
        </div>
    </div>

    <p class="copy">© 2026 MedicClips. Todos los derechos reservados.</p>
</footer>

</body>
</html>
