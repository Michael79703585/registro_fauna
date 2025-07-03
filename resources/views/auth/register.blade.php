<x-guest-layout>
  {{-- CSS de Select2 --}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <div class="min-h-screen flex items-center justify-center px-4">
    <form method="POST" action="{{ route('register') }}" novalidate
      class="w-full max-w-md bg-white p-6 rounded-lg shadow-md space-y-5">
      @csrf

      <!-- Título -->
      <h2 class="text-3xl sm:text-4xl font-extrabold text-center text-green-800 uppercase tracking-wider drop-shadow-md break-words">
        REGÍSTRATE
      </h2>
      <hr class="border-t-2 border-green-600" />

      <!-- Nombre -->
      <div>
        <x-input-label for="name" :value="__('NOMBRE')" />
        <x-text-input id="name" name="name" type="text" class="block mt-1 w-full"
          :value="old('name')" required autofocus autocomplete="name" placeholder="Ingrese su nombre completo" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
      </div>

      <!-- Email -->
      <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="block mt-1 w-full"
          :value="old('email')" required autocomplete="username" placeholder="ejemplo@correo.com" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>

     <!-- Institución -->
<div class="mb-4">
  <label for="institucion_id" class="block text-sm font-medium text-gray-700 mb-1">
    {{ __('INSTITUCIÓN') }}
  </label>
  
  <select id="institucion_id" name="institucion_id"
    class="select2 w-full border border-gray-300 rounded-lg shadow-sm
           focus:border-green-600 focus:ring-2 focus:ring-green-200 text-sm"
    required>
    <option value="" disabled selected>Seleccione una institución</option>
    @foreach ($instituciones as $inst)
      <option value="{{ $inst->id }}">{{ $inst->nombre }}</option>
    @endforeach
  </select>

  <x-input-error :messages="$errors->get('institucion_id')" class="mt-2 text-sm text-red-600" />
</div>

<style>
  /* Evitar que el texto visible en Select2 se desborde */
  .select2-container--default .select2-selection--single {
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    height: 2.5rem;
    line-height: 2.5rem;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    $('#institucion_id').select2({
      placeholder: 'Seleccione o escriba una institución',
      allowClear: true,
      width: '100%',
      templateResult: function (data) {
        if (!data.id) { return data.text; }
        return $('<span>').css('white-space', 'normal').text(data.text);
      },
      templateSelection: function (data) {
        if (!data.id) { return data.text; }
        return $('<span>').text(data.text);
      }
    });
  });
</script>



      <!-- Cargo -->
      <div>
        <x-input-label for="cargo" :value="__('CARGO')" />
        <x-text-input id="cargo" name="cargo" type="text" class="block mt-1 w-full"
          :value="old('cargo')" required autocomplete="off" placeholder="Ej. Gerente, Técnico, etc." />
        <x-input-error :messages="$errors->get('cargo')" class="mt-2" />
      </div>

      <!-- Rol -->
      <div>
        <x-input-label for="rol" :value="__('ROL')" />
        <select id="rol" name="rol"
          class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-green-600 focus:ring focus:ring-green-200 focus:ring-opacity-50"
          required>
          <option value="" disabled selected>Seleccione un rol</option>
          <option value="Medico veterinario zootecnista">Médico veterinario zootecnista</option>
          <option value="Biologo">Biólogo</option>
          <option value="Administrador">Administrador</option>
          <option value="Policia">Policía</option>
          <option value="Otro">Otro</option>
        </select>
        <x-input-error :messages="$errors->get('rol')" class="mt-2" />
      </div>

      <!-- Contraseña -->
      <div class="relative">
        <x-input-label for="password" :value="__('Password')" />
        <div class="relative">
          <x-text-input id="password" name="password" type="password" class="block mt-1 w-full pr-10"
            required autocomplete="new-password" placeholder="********" />
          <button type="button" onclick="togglePassword('password')"
            class="absolute right-3 top-2.5 text-gray-500 hover:text-green-600 focus:outline-none" tabindex="-1"
            aria-label="Toggle password visibility">👁️</button>
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>

      <!-- Confirmar Contraseña -->
      <div class="relative">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
        <div class="relative">
          <x-text-input id="password_confirmation" name="password_confirmation" type="password"
            class="block mt-1 w-full pr-10" required autocomplete="new-password" placeholder="********" />
          <button type="button" onclick="togglePassword('password_confirmation')"
            class="absolute right-3 top-2.5 text-gray-500 hover:text-green-600 focus:outline-none" tabindex="-1"
            aria-label="Toggle password visibility">👁️</button>
        </div>
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
      </div>

      <!-- Enlaces y botón -->
      <div class="flex items-center justify-between">
        <a href="{{ route('login') }}"
          class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
          {{ __('¿Ya estás registrado?') }}
        </a>

        <x-primary-button class="bg-green-700 hover:bg-green-800">
          {{ __('REGISTRAR') }}
        </x-primary-button>
      </div>
    </form>
  </div>

  {{-- Scripts de Select2 y funciones --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    function togglePassword(id) {
      const input = document.getElementById(id);
      input.type = input.type === 'password' ? 'text' : 'password';
    }

    document.addEventListener('DOMContentLoaded', function () {
      $('#institucion_id').select2({
        placeholder: 'Seleccione o escriba una institución',
        allowClear: true,
        width: '100%'
      });
    });
  </script>
</x-guest-layout>
