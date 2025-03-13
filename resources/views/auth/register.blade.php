<x-guest-layout>
    <!-- Contenedor principal -->
    <div class="min-h-screen flex items-center justify-center p-4" 
         x-data="darkModeData"
         :class="{'bg-black dark': darkMode, 'bg-white': !darkMode}">
        
        <!-- Selector de tema -->
        <div class="absolute top-4 right-4">
            <button @click="toggleDarkMode()" 
                    class="p-2 rounded-full bg-gray-700 text-white hover:bg-gray-600 transition-colors">
                <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </button>
        </div>
        
        <!-- Tarjeta de registro -->
        <div class="w-full max-w-md rounded-lg overflow-hidden shadow-2xl border-2 border-green-500 animate-pulse-slow"
             :class="darkMode ? 'bg-gray-800 text-white' : 'bg-white text-gray-800'">
            
            <!-- Logo y nombre de la aplicación -->
            <div class="flex justify-center mt-8 mb-4">
                <div class="h-12 w-12 bg-red-500 rounded-lg flex items-center justify-center shadow-lg transform -rotate-12 hover:rotate-0 transition-transform duration-300 animate-float">
                    <div :class="darkMode ? 'bg-gray-800' : 'bg-white'" class="h-8 w-8 rounded"></div>
                </div>
                <h1 class="text-2xl font-bold ml-3 self-center">Mi Aplicación</h1>
            </div>
            
            <!-- Título -->
            <div class="px-8 pb-3">
                <h2 class="text-xl font-bold text-center">Crear cuenta</h2>
                <p :class="darkMode ? 'text-gray-400' : 'text-gray-600'" class="text-sm text-center">Regístrate para acceder a todas las funciones</p>
            </div>

            <!-- Formulario -->
            <div class="px-8 pt-2 pb-8">
                <form method="POST" action="{{ route('register') }}" x-data="{ loading: false }" @submit="loading = true">
                    @csrf

                    <!-- Nombre -->
                    <div class="mb-4">
                        <label for="name" :class="darkMode ? 'text-gray-300' : 'text-gray-700'" class="block text-sm font-medium mb-1">Nombre</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" 
                                   :class="darkMode ? 'bg-gray-700 text-white' : 'bg-gray-100 text-gray-800'"
                                   class="pl-10 w-full border-green-500 rounded-lg focus:border-green-600 focus:ring focus:ring-green-500 focus:ring-opacity-50 transition-all duration-300 hover:border-green-400">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Correo Electrónico -->
                    <div class="mb-4">
                        <label for="email" :class="darkMode ? 'text-gray-300' : 'text-gray-700'" class="block text-sm font-medium mb-1">Correo Electrónico</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                                   :class="darkMode ? 'bg-gray-700 text-white' : 'bg-gray-100 text-gray-800'"
                                   class="pl-10 w-full border-green-500 rounded-lg focus:border-green-600 focus:ring focus:ring-green-500 focus:ring-opacity-50 transition-all duration-300 hover:border-green-400">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-4">
                        <label for="password" :class="darkMode ? 'text-gray-300' : 'text-gray-700'" class="block text-sm font-medium mb-1">Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                   :class="darkMode ? 'bg-gray-700 text-white' : 'bg-gray-100 text-gray-800'"
                                   class="pl-10 w-full border-green-500 rounded-lg focus:border-green-600 focus:ring focus:ring-green-500 focus:ring-opacity-50 transition-all duration-300 hover:border-green-400">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div class="mb-6">
                        <label for="password_confirmation" :class="darkMode ? 'text-gray-300' : 'text-gray-700'" class="block text-sm font-medium mb-1">Confirmar Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                   :class="darkMode ? 'bg-gray-700 text-white' : 'bg-gray-100 text-gray-800'"
                                   class="pl-10 w-full border-green-500 rounded-lg focus:border-green-600 focus:ring focus:ring-green-500 focus:ring-opacity-50 transition-all duration-300 hover:border-green-400">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Botón de Registro -->
                    <div class="mb-4">
                        <button type="submit" :disabled="loading"
                                class="register-button w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-lg text-sm font-medium text-white bg-red-600 overflow-hidden relative hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300">
                            <span x-show="!loading" class="relative z-10">Registrarme</span>
                            <span x-show="loading" class="flex items-center relative z-10">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Procesando...
                            </span>
                            <div class="button-ripple animate-ripple absolute"></div>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Pie de Página -->
            <div :class="darkMode ? 'bg-black' : 'bg-white'" class="px-6 py-4 border-t border-green-500">
                <p :class="darkMode ? 'text-gray-400' : 'text-gray-600'" class="text-sm text-center">
                    ¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="font-medium text-green-400 hover:text-green-300 transition-colors duration-200 hover:underline">Iniciar sesión</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Estilos adicionales -->
    <style>
        body {
            transition: background-color 0.3s ease;
        }

        /* Pulsado lento para el borde verde */
        @keyframes pulse-slow {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }
            50% {
                box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
            }
        }

        .animate-pulse-slow {
            animation: pulse-slow 2s infinite;
        }

        /* Animación flotante para el logo */
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(-12deg);
            }
            50% {
                transform: translateY(-10px) rotate(-8deg);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        /* Animación para los inputs al enfocarse */
        input:focus {
            animation: borderGlow 1.5s infinite alternate;
        }

        @keyframes borderGlow {
            from {
                border-color: rgb(16, 185, 129);
            }
            to {
                border-color: rgb(52, 211, 153);
            }
        }

        /* Efecto ripple para el botón */
        @keyframes ripple {
            0% {
                width: 0;
                height: 0;
                opacity: 0.7;
            }
            100% {
                width: 500px;
                height: 500px;
                opacity: 0;
            }
        }

        .register-button {
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .register-button:hover {
            transform: translateY(-3px);
        }

        .button-ripple {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            pointer-events: none;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
        }

        .animate-ripple {
            animation: ripple 1s linear infinite;
        }
    </style>

    <!-- Script para cargar la preferencia de tema y efectos de interacción -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('darkModeData', () => ({
                darkMode: localStorage.getItem('darkMode') === 'false' ? false : true,
                
                init() {
                    this.applyTheme();
                    
                    // Configurar el efecto ripple para el botón
                    const buttons = document.querySelectorAll('.register-button');
                    
                    buttons.forEach(button => {
                        button.addEventListener('mouseenter', function(e) {
                            const ripple = this.querySelector('.button-ripple');
                            ripple.classList.add('animate-ripple');
                        });
                        
                        button.addEventListener('mouseleave', function(e) {
                            const ripple = this.querySelector('.button-ripple');
                            ripple.classList.remove('animate-ripple');
                        });
                    });
                },
                
                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('darkMode', this.darkMode);
                    this.applyTheme();
                },
                
                applyTheme() {
                    // Aplica el tema al body
                    document.body.style.backgroundColor = this.darkMode ? '#000000' : '#ffffff';
                    
                    // Aplicar o quitar la clase dark según corresponda
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            }));
        });
    </script>
</x-guest-layout>