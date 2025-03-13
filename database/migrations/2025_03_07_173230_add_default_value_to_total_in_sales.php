<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Modificar la columna total para agregar un valor por defecto
            $table->decimal('total', 10, 2)->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Revertir el cambio (eliminar el valor por defecto y mantener la definición original)
            $table->decimal('total', 10, 2)->change();
        });
    }
};