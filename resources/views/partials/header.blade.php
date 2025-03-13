<header class="bg-gray-800 p-4 flex justify-between items-center shadow-md">
    <h2 class="text-xl font-semibold">@yield('header-title', 'Dashboard')</h2>
    <div class="flex items-center space-x-4">
        <!-- Profile -->
        <div class="flex items-center space-x-2">
            <span>{{ Auth::user()->name }}</span>
            <button id="themeSwitcher" class="p-2 rounded-full bg-gray-700 hover:bg-gray-600 transition-colors">
                <i class="fas fa-adjust text-white"></i> <!-- Icono de tema -->
            </button>
        </div>
        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="p-2 rounded-full bg-red-600 hover:bg-red-500 transition-colors text-white">
                <i class="fas fa-sign-out-alt"></i> <!-- Icono de logout -->
            </button>
        </form>
    </div>
</header>