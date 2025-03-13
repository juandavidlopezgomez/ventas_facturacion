<aside class="w-64 bg-gray-900 p-4 transition-all duration-300 h-full">
    <h2 class="text-2xl font-bold mb-6 text-white">Menú</h2>
    <ul class="space-y-2">
        <li><a href="{{ route('dashboard') }}" class="block p-2 hover:bg-gray-800 rounded transition-colors {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">Dashboard</a></li>
        <li><a href="{{ route('clients.index') }}" class="block p-2 hover:bg-gray-800 rounded transition-colors {{ request()->routeIs('clients.*') ? 'bg-gray-700' : '' }}">Clientes</a></li>
        <li><a href="{{ route('products.index') }}" class="block p-2 hover:bg-gray-800 rounded transition-colors {{ request()->routeIs('products.*') ? 'bg-gray-700' : '' }}">Productos</a></li>
        <li><a href="{{ route('sales.index') }}" class="block p-2 hover:bg-gray-800 rounded transition-colors {{ request()->routeIs('sales.*') ? 'bg-gray-700' : '' }}">Ventas</a></li>
        <li><a href="{{ route('invoices.index') }}" class="block p-2 hover:bg-gray-800 rounded transition-colors {{ request()->routeIs('invoices.*') ? 'bg-gray-700' : '' }}">Facturas</a></li>
    </ul>
</aside>