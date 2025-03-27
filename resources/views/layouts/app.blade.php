<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session()->get('theme', 'dark') }}" 
     x-data="{ theme: localStorage.getItem('theme') || 'dark', isSidebarOpen: true, isSidebarCollapsed: false }" 
     x-init="() => { 
         localStorage.setItem('theme', theme); 
         $watch('theme', value => localStorage.setItem('theme', value)) 
     }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Facturación')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-sans bg-white text-gray-800 transition-colors duration-300 ease-in-out">
    @auth
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar único (colapsado y expandido) -->
            <aside class="fixed top-0 left-0 h-full bg-gradient-to-b from-[#00C853] to-[#00695C] shadow-lg z-40 transition-all duration-300 ease-in-out"
                   :class="{
                       'w-20': isSidebarCollapsed || !isSidebarOpen,
                       'w-64': !isSidebarCollapsed && isSidebarOpen,
                       'translate-x-0': isSidebarOpen,
                       'w-0 -translate-x-full': !isSidebarOpen
                   }">
                <div class="py-4 px-4 flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <div class="logo-container w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 fill-[#00C853]">
                                <path d="M19.5 3.5L18 2l-1.5 1.5L15 2l-1.5 1.5L12 2l-1.5 1.5L9 2 7.5 3.5 6 2 4.5 3.5 3 2v20l1.5-1.5L6 22l1.5-1.5L9 22l1.5-1.5L12 22l1.5-1.5L15 22l1.5-1.5L18 22l1.5-1.5L21 22V2l-1.5 1.5z"/>
                                <path d="M6.5 6h11v2h-11zM6.5 10h11v2h-11zM6.5 14h4v2h-4z"/>
                            </svg>
                        </div>
                        <h2 x-show="!isSidebarCollapsed && isSidebarOpen" class="text-xl font-bold text-white tracking-wide">EcoInvoice</h2>
                    </div>
                    <button x-show="!isSidebarCollapsed && isSidebarOpen" 
                            @click="isSidebarCollapsed = !isSidebarCollapsed" 
                            class="p-1 rounded-lg hover:bg-white/20 text-white transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                        </svg>
                    </button>
                </div>
                <div class="h-px bg-white/30 mx-3 mb-5"></div>
                <nav class="px-4">
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('dashboard') }}" 
                               class="menu-item group flex items-center justify-center {{ request()->routeIs('dashboard') ? 'menu-item-active' : '' }}">
                                <span class="icon-wrapper w-10 h-10 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="menu-icon w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                    </svg>
                                </span>
                                <span x-show="!isSidebarCollapsed && isSidebarOpen" class="menu-text font-semibold text-white">Dashboard</span>
                                <span class="menu-hover-indicator"></span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('clients.index') }}" 
                               class="menu-item group flex items-center justify-center {{ request()->routeIs('clients.*') ? 'menu-item-active' : '' }}">
                                <span class="icon-wrapper w-10 h-10 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="menu-icon w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </span>
                                <span x-show="!isSidebarCollapsed && isSidebarOpen" class="menu-text font-semibold text-white">Clientes</span>
                                <span class="menu-hover-indicator"></span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="absolute bottom-5 w-full flex justify-center">
                    <button x-show="isSidebarCollapsed || !isSidebarOpen" 
                            @click="isSidebarOpen = true; isSidebarCollapsed = !isSidebarCollapsed" 
                            class="p-2 rounded-full hover:bg-white/20 text-white transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 ml-20 transition-all duration-300 ease-in-out overflow-auto bg-gray-50 p-6 rounded-lg shadow-lg"
                 :class="{
                     'ml-64': !isSidebarCollapsed && isSidebarOpen
                 }">
                <header class="sticky top-0 z-10 backdrop-blur-md bg-white/90 mb-6 px-6 py-3 flex justify-between items-center rounded-lg shadow-md">
                    <div class="flex items-center">
                        <button @click="isSidebarOpen = !isSidebarOpen" class="mr-4 p-2 rounded-lg hover:bg-green-100 lg:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800">@yield('header-title', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center gap-2 bg-green-50 px-3 py-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#00C853]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                        </div>
                        <button @click="theme = theme === 'dark' ? 'light' : 'dark'" 
                                class="p-2 rounded-lg hover:bg-green-100 transition-colors">
                            <svg x-show="theme === 'dark'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <svg x-show="theme === 'light'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-2 rounded-lg hover:bg-red-100 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </header>
                <div class="space-y-6">
                    @yield('content')
                </div>
            </div>
        </div>
    @else
        <div class="min-h-screen flex items-center justify-center bg-gray-50">
            @yield('content')
        </div>
    @endauth

    <style>
    /* Base styles */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f5f7fa;
    }

    /* Custom scrollbar */
    aside {
        overflow-y: auto;
        overflow-x: hidden;
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
    }

    aside::-webkit-scrollbar {
        width: 4px;
    }

    aside::-webkit-scrollbar-track {
        background: transparent;
    }

    aside::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.3);
        border-radius: 20px;
    }

    /* Menu items (colapsado y expandido) */
    .menu-item {
        display: flex;
        align-items: center;
        padding: 0.5rem;
        border-radius: 12px;
        color: white;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        margin-bottom: 5px;
        background-color: transparent;
    }

    .menu-item:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .menu-item-active {
        background-color: rgba(255, 255, 255, 0.3);
    }

    .icon-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }

    .menu-item:hover .icon-wrapper {
        background: rgba(255, 255, 255, 0.3);
    }

    .menu-icon {
        width: 1.25rem;
        height: 1.25rem;
        stroke: white;
        transition: all 0.3s ease;
    }

    .menu-item:hover .menu-icon {
        transform: scale(1.1);
    }

    .menu-text {
        margin-left: 0.75rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .menu-hover-indicator {
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 0;
        background: white;
        transition: width 0.3s ease;
    }

    .menu-item:hover .menu-hover-indicator {
        width: 100%;
    }

    /* Header styles */
    header {
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .theme-toggle-btn:hover, .logout-btn:hover {
        background-color: rgba(0, 0, 0, 0.1);
    }

    /* Logo animation */
    .logo-container {
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .logo-container:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    /* Content styles */
    .bg-gray-50 {
        background-color: #f5f7fa;
    }

    .rounded-lg {
        border-radius: 12px;
    }

    .shadow-lg {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    </style>

    @stack('scripts')
</body>
</html>