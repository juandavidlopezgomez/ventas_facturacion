<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Código único del producto
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2); // Precio con 2 decimales
            $table->integer('stock')->default(0); // Stock inicial en 0
            $table->string('image')->nullable(); // Ruta de la imagen
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Relación con categorías
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null'); // Relación con proveedores
            $table->date('expiration_date')->nullable(); // Fecha de caducidad
            $table->boolean('status')->default(true); // Estado activo/inactivo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
