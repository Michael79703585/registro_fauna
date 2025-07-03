<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Fauna Silvestre - Bienvenido</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');

    body {
      font-family: 'Inter', sans-serif;
      background-image: url('https://www.opinion.com.bo/asset/thumbnail,992,558,center,center/media/opinion/images/2021/12/02/2021120223503580141.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }

    /* Animación para el texto del título */
    @keyframes glow {
      0%, 100% {
        text-shadow:
          0 0 5px #facc15,
          0 0 10px #fbbf24,
          0 0 20px #f59e0b,
          0 0 30px #b45309,
          0 0 40px #92400e;
      }
      50% {
        text-shadow:
          0 0 10px #fde68a,
          0 0 20px #fbbf24,
          0 0 30px #f97316,
          0 0 40px #b45309,
          0 0 50px #78350f;
      }
    }

    /* Animación para el icono */
    @keyframes bounce {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-10px);
      }
    }
  </style>
</head>

<body class="text-gray-900 bg-white">

  <!-- NAVBAR -->
  <nav class="bg-green-950 text-white fixed w-full top-0 z-50 shadow-lg">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <div class="text-2xl font-extrabold tracking-wider flex items-center gap-2">
        <span class="text-yellow-400 animate-bounce">🐾</span>
        <span class="text-white">Fauna Silvestre</span>
      </div>
      <ul class="flex space-x-6 font-medium text-lg">
        <li><a href="#inicio" class="hover:text-yellow-400 transition duration-200">Inicio</a></li>
        <li><a href="#publicaciones" class="hover:text-yellow-400 transition duration-200">Publicaciones</a></li>
        <li><a href="#videos" class="hover:text-yellow-400 transition duration-200">Videos</a></li>
        <li><a href="#contacto" class="hover:text-yellow-400 transition duration-200">Contacto</a></li>

        @guest
        <li><a href="{{ route('login') }}" class="hover:text-yellow-400 transition duration-200">Iniciar Sesión</a></li>
        <li><a href="{{ route('register') }}" class="hover:text-yellow-400 transition duration-200">Registrarse</a></li>
        @else
        <li><a href="{{ route('dashboard') }}" class="hover:text-yellow-400 transition duration-200">Panel</a></li>
        <li>
          <a href="{{ route('logout') }}" class="hover:text-red-400 transition"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Salir
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
          </form>
        </li>
        @endguest
      </ul>
    </div>
  </nav>

  <!-- INICIO -->
  <section id="inicio"
    class="pt-36 pb-24 bg-cover bg-center relative bg-black/70 text-white overflow-hidden"
    style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/1/10/Andean_condor_-_Tunari_National_Park.jpg');">

    <!-- Overlay negro con opacidad para mejor lectura -->
    <div class="absolute inset-0 bg-black/70 z-10"></div>

    <div class="max-w-5xl mx-auto px-3 text-center relative z-20">
      <h1
        class="text-5xl md:text-6xl font-extrabold mb-6 drop-shadow-xl animate-glow"
        style="animation: glow 3s ease-in-out infinite;">
        Sistema de Registro Único de Fauna Silvestre
        <br />
        <span class="text-yellow-200 tracking-wide font-extrabold" style="text-shadow: 0 0 10px #bdff08;">
          Gobierno Autónomo Departamental de Cochabamba
        </span>
      </h1>
      <p class="text-xl md:text-2xl text-gray-200 drop-shadow-lg max-w-3xl mx-auto animate-fadeIn" style="animation: fadeIn 2s ease forwards;">
        Gestión, protección y seguimiento de fauna silvestre en el Departamento de Cochabamba.
      </p>
    </div>

    <!-- Animación de pájaro volando -->
    <svg class="absolute top-10 left-10 w-20 h-20 animate-bounce" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="filter: drop-shadow(0 0 2px rgba(210, 208, 208, 0.7));">
      <path fill="#FACC15" d="M32 2C28 14 24 26 16 28C24 30 28 42 32 54C36 42 40 30 48 28C40 26 36 14 32 2Z" />
    </svg>

  </section>

 <!-- PUBLICACIONES -->
<section id="publicaciones" class="py-20 bg-gray-50" x-data="{ abierto: false }">
  <style>
    .line-clamp-3 {
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
    }
  </style>

  <div class="max-w-7xl mx-auto px-6">
    <div class="flex justify-between items-center mb-10">
      <h2 class="text-4xl font-extrabold text-green-900 flex items-center gap-2">📰 Noticias y Publicaciones</h2>
      <button @click="abierto = !abierto"
        class="flex items-center gap-2 text-green-800 font-semibold hover:text-green-600 transition duration-200">
        <svg :class="abierto ? 'rotate-90' : 'rotate-0'"
          class="w-5 h-5 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2"
          viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
        <span x-text="abierto ? 'Cerrar formulario' : 'Nueva publicación'"></span>
      </button>
    </div>

    <!-- FORMULARIO -->
    <div x-show="abierto" x-transition class="mb-12 border border-green-300 rounded-xl bg-green-50 p-8 shadow-xl">
      <form action="{{ route('publicaciones.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div>
          <label for="title_pub" class="block font-semibold text-green-900 mb-2">Título</label>
          <input type="text" name="title" id="title_pub" required
            class="w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 focus:outline-none" />
        </div>
        <div>
          <label for="description_pub" class="block font-semibold text-green-900 mb-2">Descripción</label>
          <textarea name="description" id="description_pub" rows="4" required
            class="w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 focus:outline-none"></textarea>
        </div>
        <div>
          <label for="files_pub" class="block font-semibold text-green-900 mb-2">Imágenes o PDFs</label>
          <input type="file" name="files[]" id="files_pub" accept="image/*,.pdf" multiple required
            class="w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 focus:outline-none" />
        </div>
        <button type="submit"
          class="bg-green-800 hover:bg-green-900 text-white font-bold px-6 py-3 rounded-lg shadow-md w-full transition">
          📤 Publicar
        </button>
      </form>
    </div>

    <!-- LISTADO -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      @forelse ($publicaciones as $publicacion)
        @php
          $archivos = is_array($publicacion->image_path)
              ? $publicacion->image_path
              : json_decode($publicacion->image_path, true);
          $archivo = $archivos[0] ?? '';
          $esPDF = Str::endsWith($archivo, '.pdf');
        @endphp
        <article class="bg-white border border-gray-200 rounded-xl shadow hover:shadow-xl transition flex flex-col">
          @if ($archivo)
            @if ($esPDF)
              <iframe src="{{ asset('storage/' . $archivo) }}" class="h-48 w-full rounded-t-xl" frameborder="0"></iframe>
            @else
              <img src="{{ asset('storage/' . $archivo) }}" alt="{{ $publicacion->title }}"
                class="h-48 w-full object-cover rounded-t-xl"
                onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=Archivo+no+disponible';" />
            @endif
          @endif
          <div class="p-5 flex flex-col flex-grow">
            <h3 class="text-xl font-bold text-green-800 mb-2">{{ $publicacion->title }}</h3>
            <p class="text-gray-700 flex-grow line-clamp-3">{{ Str::limit($publicacion->description, 120, '...') }}</p>
            <div class="mt-4 flex justify-between items-center">
              <a href="{{ route('publication.show', $publicacion->id) }}" class="btn btn-primary">Ver más</a>

              <button onclick="share('{{ $publicacion->title }}', '{{ asset('storage/' . $archivo) }}')"
                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition">
                Compartir
              </button>
            </div>
            <div class="mt-4 flex justify-end gap-3">
              <a href="{{ route('publicaciones.edit', $publicacion->id) }}"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-1 rounded text-sm">Editar</a>
              <form action="{{ route('publicaciones.destroy', $publicacion->id) }}" method="POST"
                onsubmit="return confirm('¿Seguro que deseas eliminar esta publicación?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                  class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded text-sm">Eliminar</button>
              </form>
            </div>
          </div>
        </article>
      @empty
        <p class="text-gray-600 col-span-3 text-center">No hay publicaciones disponibles.</p>
      @endforelse
    </div>
  </div>
</section>

<script>
  function share(title, fileUrl) {
    if (navigator.share) {
      navigator.share({
        title: title,
        text: 'Mira esta publicación interesante:',
        url: fileUrl
      }).catch(console.error);
    } else {
      alert('Tu navegador no soporta compartir. Copia el enlace: ' + fileUrl);
    }
  }
</script>

  <script>
    function share(title, imageUrl) {
      if (navigator.share) {
        navigator.share({
          title: title,
          text: 'Mira esta publicación interesante:',
          url: imageUrl
        }).catch(console.error);
      } else {
        alert('Tu navegador no soporta la función de compartir. Puedes copiar el enlace: ' + imageUrl);
      }
    }
  </script>

  <!-- CONTACTO -->
  <section id="contacto" class="py-20 bg-green-950 text-white">
    <div class="max-w-4xl mx-auto px-6 text-center">
      <h2 class="text-4xl font-extrabold mb-6">📬 Contacto</h2>
      <p class="text-lg mb-4">¿Tienes dudas o sugerencias? Escríbenos:</p>
      <p class="text-lg"><strong>Email:</strong> fauna@gadc.bo</p>
      <p class="text-lg"><strong>Teléfono:</strong> +591 4 4456789</p>
    </div>
  </section>

</body>

</html>
