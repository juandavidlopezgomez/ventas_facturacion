<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Incluir rutas de autenticación provistas por Laravel Breeze
require __DIR__ . '/auth.php';

// Grupo de rutas protegidas por autenticación y verificación de email
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Clientes
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

    // Productos
    Route::resource('products', ProductController::class);
    Route::get('products/export/{format}', [ProductController::class, 'export'])->name('products.export');

    // Ventas
    Route::resource('sales', SaleController::class);
    Route::get('/sales/export', [SaleController::class, 'export'])->name('sales.export');
    Route::resource('invoices', InvoiceController::class);
    Route::get('/sales/print', [SalesController::class, 'print'])->name('sales.print');
    Route::get('/sales/{id}/cancel', [SalesController::class, 'cancel'])->name('sales.cancel');

    // Facturas
    Route::resource('invoices', InvoiceController::class);
    Route::post('/sales/{sale}/generate-invoice', [InvoiceController::class, 'generate'])->name('sales.generate-invoice');
});
