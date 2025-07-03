<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Fuente profesional -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />

    @vite('resources/css/app.css')

    <style>
    body, html {
        height: 100%;
        margin: 0;
        font-family: 'Inter', sans-serif;
        font-size: 16px; /* tamaño base más grande */
        color: #1a1a1a;
    }

    body {
        background-image: url('/imagenes/paraba-1.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        min-height: 100vh;
    }

    /* Contenedor del formulario */
    .form-container {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 420px;
        background: white;
        padding: 2.5rem 2.5rem;
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    /* Tipografía general */
    label,
    input,
    select,
    button,
    a,
    p,
    span {
        font-family: 'Inter', sans-serif;
        font-size: 1.05rem;
    }

    /* Títulos */
    h1, h2, h3 {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        color: #166534; /* verde oscuro */
        text-align: center;
        margin-bottom: 1.5rem;
        font-size: 2rem;
        letter-spacing: 0.03em;
    }

    /* Inputs y selects */
    input, select {
        font-size: 1.05rem;
        padding: 0.75rem 1rem;
    }

    /* Botones */
    button {
        font-size: 1.125rem;
        font-weight: 600;
    }

    /* Enlaces */
    a {
        font-size: 0.95rem;
        font-weight: 500;
    }
</style>

</head>
<body>
    <div class="form-container">
        {{ $slot }}
    </div>
</body>
</html>
