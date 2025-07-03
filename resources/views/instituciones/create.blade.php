<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Institución</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Registrar Nueva Institución</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('instituciones.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" class="w-full border p-2 rounded" required>
                @error('nombre') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Dirección</label>
                <input type="text" name="direccion" value="{{ old('direccion') }}" class="w-full border p-2 rounded">
                @error('direccion') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono') }}" class="w-full border p-2 rounded">
                @error('telefono') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Guardar Institución
            </button>
        </form>
    </div>
</body>
</html>
