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
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade'); // Relación con venta
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relación con producto
            $table->integer('quantity'); // Cantidad vendida
            $table->decimal('price', 8, 2); // Precio unitario
            $table->decimal('subtotal', 8, 2); // Subtotal (quantity * price)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
