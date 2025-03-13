@extends('layouts.app')

@section('header-title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <!-- Card 1: Ventas Totales -->
        <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-gray-500">Ventas Totales</h3>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#00C853]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-9c-1.657 0-3 .895-3 2s1.343 2 3 2m0 0c1.11 0 2.08.402 2.599 1M13 16h4" />
                </svg>
            </div>
            <p class="text-lg font-semibold text-gray-900">$18,500</p>
            <p class="text-xs text-gray-500">+2% desde el mes pasado</p>
        </div>

        <!-- Card 2: Facturas Emitidas -->
        <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-gray-500">Facturas Emitidas</h3>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#00C853]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <p class="text-lg font-semibold text-gray-900">150</p>
            <p class="text-xs text-gray-500">+1% desde el mes pasado</p>
        </div>

        <!-- Card 3: Productos Vendidos -->
        <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-gray-500">Productos Vendidos</h3>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#00C853]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <p class="text-lg font-semibold text-gray-900">600</p>
            <p class="text-xs text-gray-500">+3% desde el mes pasado</p>
        </div>

        <!-- Card 4: Clientes Activos -->
        <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-gray-500">Clientes Activos</h3>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#00C853]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <p class="text-lg font-semibold text-gray-900">200</p>
            <p class="text-xs text-gray-500">+1% desde el mes pasado</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4" style="max-height: 200px; overflow: hidden;">
        <!-- Gráfico 1: Ventas Mensuales (Líneas) -->
        <div class="bg-white p-4 rounded-lg shadow-md" style="height: 100%; overflow: hidden;">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Ventas Mensuales</h3>
            <canvas id="ventasMensualesChart" class="w-full" style="max-height: 120px;"></canvas>
        </div>

        <!-- Gráfico 2: Facturas Emitidas por Mes (Barras) -->
        <div class="bg-white p-4 rounded-lg shadow-md" style="height: 100%; overflow: hidden;">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Facturas Emitidas por Mes</h3>
            <canvas id="facturasMensualesChart" class="w-full" style="max-height: 120px;"></canvas>
        </div>

        <!-- Gráfico 3: Productos Más Vendidos (Dona) -->
        <div class="bg-white p-4 rounded-lg shadow-md" style="height: 100%; overflow: hidden;">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Productos Más Vendidos</h3>
            <canvas id="productosVendidosChart" class="w-full" style="max-height: 120px;"></canvas>
        </div>

        <!-- Gráfico 4: Clientes Más Frecuentes (Barras Horizontales) -->
        <div class="bg-white p-4 rounded-lg shadow-md" style="height: 100%; overflow: hidden;">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Clientes Más Frecuentes</h3>
            <canvas id="clientesFrecuentesChart" class="w-full" style="max-height: 120px;"></canvas>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Gráfico 1: Ventas Mensuales (Líneas)
            const ventasMensualesCtx = document.getElementById('ventasMensualesChart').getContext('2d');
            new Chart(ventasMensualesCtx, {
                type: 'line',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    datasets: [{
                        label: 'Ventas ($)',
                        data: [15000, 15100, 15200, 15300, 15400, 15500, 15600, 15700, 15800, 15900, 16000, 16100],
                        borderColor: '#00C853',
                        backgroundColor: 'rgba(0, 200, 83, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#00C853',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#00C853'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 2,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 20000,
                            grid: { color: 'rgba(0, 0, 0, 0.05)' },
                            ticks: { color: '#6B7280', font: { size: 10 }, stepSize: 5000 }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#6B7280', font: { size: 10 } }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // Gráfico 2: Facturas Emitidas por Mes (Barras)
            const facturasMensualesCtx = document.getElementById('facturasMensualesChart').getContext('2d');
            new Chart(facturasMensualesCtx, {
                type: 'bar',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    datasets: [{
                        label: 'Facturas',
                        data: [120, 121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131],
                        backgroundColor: '#00C853',
                        borderColor: '#00C853',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 2,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 150,
                            grid: { color: 'rgba(0, 0, 0, 0.05)' },
                            ticks: { color: '#6B7280', font: { size: 10 }, stepSize: 50 }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#6B7280', font: { size: 10 } }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // Gráfico 3: Productos Más Vendidos (Dona)
            const productosVendidosCtx = document.getElementById('productosVendidosChart').getContext('2d');
            new Chart(productosVendidosCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Bicicletas Urbanas', 'Bicicletas de Montaña', 'Accesorios', 'Repuestos', 'Ropa Deportiva'],
                    datasets: [{
                        label: 'Productos',
                        data: [200, 150, 100, 75, 50],
                        backgroundColor: [
                            '#00C853',
                            '#4CAF50',
                            '#81C784',
                            '#A5D6A7',
                            '#C8E6C9'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 1,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { color: '#6B7280', font: { size: 10 } }
                        }
                    }
                }
            });

            // Gráfico 4: Clientes Más Frecuentes (Barras Horizontales)
            const clientesFrecuentesCtx = document.getElementById('clientesFrecuentesChart').getContext('2d');
            new Chart(clientesFrecuentesCtx, {
                type: 'bar',
                data: {
                    labels: ['Juan Pérez', 'María Gómez', 'Carlos López', 'Ana Martínez', 'Luis Rodríguez'],
                    datasets: [{
                        label: 'Compras',
                        data: [20, 19, 18, 17, 16],
                        backgroundColor: '#00C853',
                        borderColor: '#00C853',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 2,
                    scales: {
                        x: {
                            beginAtZero: true,
                            max: 25,
                            grid: { color: 'rgba(0, 0, 0, 0.05)' },
                            ticks: { color: '#6B7280', font: { size: 10 }, stepSize: 5 }
                        },
                        y: {
                            grid: { display: false },
                            ticks: { color: '#6B7280', font: { size: 10 } }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        </script>
    @endpush
@endsection