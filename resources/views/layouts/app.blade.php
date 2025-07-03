<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Panel de Control - Fauna Silvestre')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery (requerido por Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



    <!-- App CSS & JS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Alpine.js v3.13.0 (estable y funcional) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/cdn.min.js"></script>

    <!-- Bootstrap JS Bundle (Popper incluido) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #3b82f6;
            --accent-color: #10b981;
            --dark-bg: #1f2937;
            --light-bg: #f9fafb;
            --text-main: #1e293b;
            --text-light: #f9f9f9;
            --card-bg: rgba(255, 255, 255, 0.95);
            --btn-primary-bg: #2563eb;
            --btn-primary-hover: #1e40af;
            --btn-secondary-bg: #10b981;
            --btn-secondary-hover: #047857;
        }

        html, body {
             max-width: 100vw;
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-main);
            scroll-behavior: smooth;
            overflow-x: hidden; /* Previene scroll horizontal */
        }

        aside {
            width: 320px;
            background: linear-gradient(160deg, var(--dark-bg), #111827);
            color: var(--text-light);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            box-shadow: 4px 0 12px rgba(0,0,0,0.3);
            /* Imagen de fondo añadida */
            background-image: url('/imagenes/jaguar-2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        aside::before {
            content: "";
            position: absolute;
            inset: 0;
            background-color: rgba(17, 24, 39, 0.7);
            z-index: 0;
        }

        aside > div:first-child,
        aside nav {
            position: relative;
            z-index: 1;
        }

        aside > div:first-child {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            padding: 2rem;
            font-size: 1.75rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            user-select: none;
        }

        aside nav {
            flex: 1;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        aside nav a,
        aside nav button {
            padding: 0.75rem 1.4rem;
            border-radius: 12px;
            background-color: transparent;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
            color: var(--text-light);
            font-weight: 600;
            font-size: 1rem;
            border: 2px solid transparent;
            cursor: pointer;
            user-select: none;
        }

        aside nav a:hover,
        aside nav button:hover {
            background-color: var(--accent-color);
            color: #111;
            box-shadow: 0 0 14px var(--accent-color);
            border-color: var(--accent-color);
        }

        aside nav a.active,
        aside nav button.active {
            background-color: var(--primary-color);
            color: #fff;
            box-shadow: 0 0 14px var(--primary-color);
            border-color: var(--primary-color);
        }

        header {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            color: var(--text-light);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
            padding: 1rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            user-select: none;
        }

        header h1 {
            font-size: 2.25rem;
            font-weight: 900;
            letter-spacing: 1px;
            margin: 0;
        }

        header p.subtitle {
            font-size: 1.1rem;
            color: #dbeafe;
            margin-top: 0.3rem;
            font-weight: 500;
        }

        .main-content-bg {
            flex: 1; /* Ocupa el espacio restante */
            min-width: 0; /* Evita overflow en flexbox */
            overflow-y: auto;
            background: linear-gradient(135deg, #e0f2fe, #ffffff);
            padding: 3rem 2rem;
            background-image: url('/imagenes/imagen-1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-color: rgba(0, 0, 0, 0.3);
            background-blend-mode: darken;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .content-wrapper {
            background-color: var(--card-bg);
            padding: 3rem 3.5rem;
            border-radius: 20px;
            box-shadow: 0 16px 36px rgba(0,0,0,0.12);
            width: 100%;
            max-width: 980px;
            animation: fadeIn 0.7s ease-out;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .welcome-message {
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 0.2rem;
            letter-spacing: 1.2px;
            user-select: none;
        }

        .welcome-subtext {
            font-size: 1.3rem;
            color: #334155;
            text-align: center;
            margin-bottom: 2rem;
            font-weight: 500;
            line-height: 1.5;
            user-select: none;
        }

        .message-box textarea {
            width: 100%;
            padding: 1.2rem 1.4rem;
            border-radius: 14px;
            border: 1.5px solid #cbd5e1;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            resize: vertical;
            transition: border-color 0.3s ease;
            outline-offset: 2px;
        }
        .message-box textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 6px var(--primary-color);
            outline: none;
        }

        .btns {
            display: flex;
            gap: 1.2rem;
            justify-content: flex-end;
            margin-top: 0.7rem;
        }

        .btn-send, .btn-receive {
            padding: 0.75rem 1.8rem;
            border-radius: 14px;
            font-weight: 700;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.12);
            user-select: none;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            justify-content: center;
        }

        .btn-send {
            background-color: var(--btn-primary-bg);
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.5);
        }
        .btn-send:hover {
            background-color: var(--btn-primary-hover);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.7);
        }

        .btn-receive {
            background-color: var(--btn-secondary-bg);
            box-shadow: 0 6px 14px rgba(16, 185, 129, 0.5);
        }
        .btn-receive:hover {
            background-color: var(--btn-secondary-hover);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.7);
        }

        /* Dropdown styling */
        .dropdown-menu a {
            display: block;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
            user-select: none;
        }
        .dropdown-menu a:hover {
            background-color: var(--accent-color);
            color: #111;
        }

        /* User info styling */
        .user-info {
            text-align: right;
            color: #dbeafe;
            user-select: none;
        }
        .user-info p.text-sm {
            margin: 0;
            font-weight: 600;
            opacity: 0.85;
        }
        .user-info p.name {
            margin: 0;
            font-weight: 900;
            font-size: 1.15rem;
            color: #fffafa;
        }
        .user-info .institution {
            margin-top: 0.1rem;
            font-weight: 600;
            color: #ffffff;
        }

        .profile-btn {
            background: transparent;
            border: 2px solid #fff;
            color: #fff;
            padding: 0.4rem 1rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
            user-select: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }
        .profile-btn:hover {
            background: #fff;
            color: var(--primary-color);
            border-color: var(--primary-color);
            box-shadow: 0 0 14px var(--primary-color);
        }

    </style>
</head>
<body>
    @if(session('success'))
        <div class="fixed top-5 right-5 bg-green-600 text-white font-semibold px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in-down">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex min-h-screen overflow-auto">
        <aside>
            <div>🐾 <span>Fauna Control</span></div>
            <nav>
                <x-sidebar-link route="fauna.index" icon="📋" label="Registros" />
                <x-sidebar-link route="historial.index" icon="🩺" label="Historial clínico" />
                <x-sidebar-link route="transferencias.index" icon="🔁" label="Transferencias" />
                <x-sidebar-link route="transferencias.recepciones" icon="📥" label="Recepciones" />
                <x-sidebar-link route="liberaciones.index" icon="🕊️" label="Liberaciones" />
                <x-sidebar-link route="partes.index" icon="🧬" label="Registro de partes y/o derivados" />

                <!-- Menú desplegable Eventos -->
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open"
            class="w-full flex items-center justify-between px-4 py-2 rounded-xl bg-gray-700 hover:bg-gray-600 transition text-left text-white font-semibold shadow-md">
        📅 Eventos
        <i :class="open ? 'bi bi-chevron-up' : 'bi bi-chevron-down'" class="ml-2 transition-all"></i>
    </button>

    <div x-show="open" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute z-50 mt-2 w-56 bg-gray-800 shadow-lg rounded-xl p-3 space-y-2">
        
        <a href="{{ route('eventos.create', ['tipo' => 'Nacimiento']) }}"
           class="block px-4 py-2 rounded-lg font-medium text-white hover:bg-blue-600 transition 
           {{ request()->routeIs('eventos.create') && request()->get('tipo') === 'Nacimiento' ? 'bg-blue-700' : 'bg-blue-500' }}">
           🐣 Nacimiento
        </a>

        <a href="{{ route('eventos.create', ['tipo' => 'Fuga']) }}"
           class="block px-4 py-2 rounded-lg font-medium text-white hover:bg-yellow-500 transition
           {{ request()->routeIs('eventos.create') && request()->get('tipo') === 'Fuga' ? 'bg-yellow-600' : 'bg-yellow-400' }}">
           🏃‍♂️ Fuga
        </a>

        <a href="{{ route('eventos.create', ['tipo' => 'Deceso']) }}"
           class="block px-4 py-2 rounded-lg font-medium text-white hover:bg-red-600 transition
           {{ request()->routeIs('eventos.create') && request()->get('tipo') === 'Deceso' ? 'bg-red-700' : 'bg-red-500' }}">
           ⚰️ Deceso
        </a>

        <a href="{{ route('eventos.todos') }}"
           class="block px-4 py-2 rounded-lg font-medium text-white hover:bg-gray-700 transition
           {{ request()->routeIs('eventos.todos') ? 'bg-gray-800' : 'bg-gray-600' }}">
           📋 Todos
        </a>
    </div>
</div>

<!-- Enlace solo para admin -->
@if (auth()->check() && auth()->user()->email === 'michaelleon2109@gmail.com')
    <a href="{{ route('admin.dashboard') }}" 
       class="mt-4 block px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-semibold shadow-md transition flex items-center gap-2">
       🔑 Admin Panel
    </a>
@endif

<!-- Botón de cerrar sesión -->
<form method="POST" action="{{ route('logout') }}" class="mt-6">
    @csrf
    <button type="submit"
            class="w-full flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl shadow transition">
        🚪 Cerrar sesión
    </button>
</form>

            </nav>
        </aside>

        <div class="main-content-bg">
            <main class="content-wrapper">
                <header>
                    <div>
                        <h1>@yield('title', 'Panel de Control')</h1>
                        <p class="subtitle">Gestión integral de fauna silvestre</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="user-info">
                            @if(Auth::check())
                                <p class="text-sm">Conectado como:</p>
                                <p class="name">👤 {{ Auth::user()->name }}</p>
                                <div class="text-sm text-gray-300">
                                </div>
                            @endif
                            @if(isset($institucion))
                                <p class="institution">🏢 {{ $institucion->nombre ?? '' }}</p>
                            @endif
                        </div>
                        <a href="{{ route('perfil.show') }}" class="profile-btn" title="Ver perfil de usuario">Perfil</a>
                    </div>
                </header>

                @if(request()->routeIs('dashboard'))
                    <div class="welcome-message" aria-live="polite" role="heading">
                        👋 ¡Hola, <span class="text-teal-600">{{ Auth::user()->name }}</span>!
                    </div>
                    <p class="welcome-subtext" aria-live="polite">
                        Bienvenido al Panel de Control. Desde aquí puedes gestionar, monitorear y mantener el seguimiento de la fauna silvestre de forma eficiente y organizada.
                    </p>

                    <!-- Gráfico de registros -->
                    <canvas id="faunaChart" style="max-width: 100%; margin-bottom: 2rem;"></canvas>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const ctx = document.getElementById('faunaChart').getContext('2d');
                            const faunaChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: @json($registrosFechas ?? []),
                                    datasets: [{
                                        label: 'Registros en el tiempo',
                                        data: @json($registrosConteo ?? []),
                                        borderColor: 'rgba(37, 99, 235, 0.9)',
                                        backgroundColor: 'rgba(37, 99, 235, 0.3)',
                                        fill: true,
                                        tension: 0.4,
                                        pointRadius: 4,
                                        pointHoverRadius: 7,
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            display: true,
                                            labels: {
                                                color: '#1e293b',
                                                font: { weight: 'bold', size: 14 }
                                            }
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: { color: '#1e293b', stepSize: 1 },
                                            grid: { color: '#e2e8f0' }
                                        },
                                        x: {
                                            ticks: { color: '#1e293b' },
                                            grid: { color: '#e2e8f0' }
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                @endif

                @yield('content')

            </main>
        </div>
    </div>

    <!-- Select2 JS -->
<!-- jQuery (requerido por Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('#fauna_id').select2({
            placeholder: "-- Selecciona un animal --",
            allowClear: true,
            width: '100%'
        });

    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Coordenadas iniciales (puedes cambiar a tu zona deseada)
        let defaultLat = -17.398354;
        let defaultLng = -65.174774;

        // Si ya hay coordenadas en el input, úsalas
        const coordInput = document.getElementById('coordenadas');
        if (coordInput.value) {
            const [lat, lng] = coordInput.value.split(',').map(coord => parseFloat(coord.trim()));
            if (!isNaN(lat) && !isNaN(lng)) {
                defaultLat = lat;
                defaultLng = lng;
            }
        }

        // Crear el mapa
        const map = L.map('map').setView([defaultLat, defaultLng], 13);

        // Agregar el mapa base
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Crear marcador inicial
        let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        // Actualiza input cuando se mueva el marcador
        marker.on('dragend', function (e) {
            const position = marker.getLatLng();
            coordInput.value = `${position.lat.toFixed(6)},${position.lng.toFixed(6)}`;
        });

        // Clic en el mapa para mover el marcador
        map.on('click', function (e) {
            const { lat, lng } = e.latlng;
            marker.setLatLng([lat, lng]);
            coordInput.value = `${lat.toFixed(6)},${lng.toFixed(6)}`;
        });
    });
</script>

<!-- Bootstrap JS (para dropdowns, modals, etc) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Inicializar Select2 -->
<script>
  $(document).ready(function() {
    $('#institucion_id').select2({
      placeholder: 'Seleccione o escriba una institución',
      allowClear: true,
      width: '100%'
    });
  });
</script>

</body>
</html>
