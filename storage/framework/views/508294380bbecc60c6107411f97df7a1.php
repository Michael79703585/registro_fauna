<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Fauna Silvestre - Bienvenido</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>

  <!-- Alpine.js -->
  <script src="https://unpkg.com/alpinejs" defer></script>

  <!-- Google Fonts: Montserrat -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #f8f9fc;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .line-clamp-3 {
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    @keyframes fadeInUp {
      0% {
        opacity: 0;
        transform: translateY(30px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-in {
      animation: fadeInUp 1.2s ease-out both;
    }
  </style>
</head>

<body class="text-[#1D1D4B] bg-white">

  <!-- NAVBAR -->
  <nav class="bg-[#0082C9] text-white fixed w-full top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <img src="<?php echo e(asset('storage/logo3.png')); ?>" class="h-10" alt="Logo Gobernación" />
      <ul class="flex space-x-6 text-sm font-semibold">
        
        <li><a href="<?php echo e(route('publicaciones.index')); ?>" class="hover:underline">Publicaciones</a></li>
        <li><a href="#contacto" class="hover:underline">Contacto</a></li>
        <?php if(auth()->guard()->guest()): ?>
        <li><a href="<?php echo e(route('login')); ?>" class="hover:underline">Iniciar Sesión</a></li>
        <li><a href="<?php echo e(route('register')); ?>" class="hover:underline">Registrarse</a></li>
        <?php else: ?>
        <li><a href="<?php echo e(route('dashboard')); ?>" class="hover:underline">Panel</a></li>
        <li>
          <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Salir</a>
          <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="hidden"><?php echo csrf_field(); ?></form>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <!-- INICIO -->
  <section id="inicio" class="relative w-full h-screen overflow-hidden font-[Montserrat]">
    <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover z-0">
      <source src="<?php echo e(asset('storage/video3.mp4')); ?>" type="video/mp4" />
      Tu navegador no soporta el video en HTML5.
    </video>
    <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-black/10 to-black/30 z-10"></div>
    <div class="relative z-20 flex flex-col items-center h-full pt-32 px-6 text-center">
      <div class="bg-white/20 backdrop-blur-lg border border-white/30 rounded-2xl px-10 py-8 shadow-lg max-w-3xl w-full">
        <h1 class="text-2xl md:text-4xl font-extrabold text-white mb-3 leading-tight tracking-wide drop-shadow-md">
          SISTEMA DE Registro Único de Fauna Silvestre
        </h1>
        <p class="text-sm md:text-base text-white/90 mb-8 leading-relaxed tracking-wide">
          Gestión integral para el monitoreo y protección de la fauna silvestre en el departamento de Cochabamba.
        </p>
      </div>
    </div>
  </section>

  <!-- FOOTER: Basado en la imagen proporcionada -->
  <footer id="contacto" class="bg-[#0082C9] text-white pt-10 pb-6 mt-20">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-6 text-sm text-center md:text-left">
      
      <!-- Información de contacto -->
<div class="normal-case">
  <h2 class="font-bold text-base mb-2 uppercase">INFORMACIÓN DE CONTACTO</h2>
  <p>Av. Aroma N°: O-327 - Plaza San Sebastián Edificio del Organo Ejecutivo</p>
  <p class="mt-2">Teléfonos: 591 4 4500530</p>
  <p class="mt-2 break-words">Email: gobernaciondecochabamba@gobernaciondecochabamba.bo</p>
</div>


      <!-- Logo y lema -->
      <div class="flex flex-col items-center justify-center">
        <img src="<?php echo e(asset('storage/logo3.png')); ?>" alt="Logo Gobernación" class="h-16 mb-2">
       
      </div>

      <!-- Canales de comunicación -->
<div class="normal-case">
  <h2 class="font-bold text-base mb-2 uppercase">CANALES DE COMUNICACIÓN</h2>
  <div class="flex justify-center md:justify-start gap-4 mt-2 text-xl">
    <a href="https://x.com/i/flow/login?redirect_after_login=%2FGobernacionCbba" target="_blank" aria-label="X / Twitter"><i data-feather="twitter"></i></a>
    <a href="https://www.facebook.com/GobernacionDeCochabamba" target="_blank" aria-label="Facebook"><i data-feather="facebook"></i></a>
    <a href="https://www.tiktok.com/@gobernaciondecochabamba" target="_blank" aria-label="TikTok"><i data-feather="music"></i></a>
    <a href="https://www.youtube.com/@gobernaciondecochabamba8326" target="_blank" aria-label="YouTube"><i data-feather="youtube"></i></a>
    <a href="https://www.instagram.com/gobernaciondecochabamba/" target="_blank" aria-label="Instagram"><i data-feather="instagram"></i></a>
    <a href="https://gobernaciondecochabamba.bo/web/gobernaciontv" target="_blank" aria-label="TV"><i data-feather="tv"></i></a>
  </div>
</div>


    <!-- Línea separadora -->
    <div class="border-t border-white/30 my-4 mx-6"></div>

    <!-- Créditos -->
    <p class="text-center text-xs">&copy; 2025, Gobierno Autónomo Departamental de Cochabamba</p>
  </footer>

  <script>
    feather.replace(); // Carga íconos Feather
  </script>

</body>
</html>
<?php /**PATH C:\laragon\www\registro_fauna\resources\views/welcome.blade.php ENDPATH**/ ?>