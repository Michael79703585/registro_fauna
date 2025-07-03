<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" autocomplete="on">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email"
                          class="block mt-1 w-full"
                          type="email"
                          name="email"
                          :value="old('email')"
                          required
                          autofocus
                          autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 relative mb-6">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative">
                <x-text-input id="password"
                              class="block mt-1 w-full pr-10"
                              type="password"
                              name="password"
                              required
                              autocomplete="current-password" />
                <!-- Botón para mostrar/ocultar contraseña -->
                <button type="button"
                        onclick="togglePassword('password')"
                        class="absolute right-3 top-2.5 text-gray-500 hover:text-indigo-600 focus:outline-none"
                        tabindex="-1"
                        aria-label="Toggle password visibility">👁️</button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>


            <x-primary-button type="submit" class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</x-guest-layout>
