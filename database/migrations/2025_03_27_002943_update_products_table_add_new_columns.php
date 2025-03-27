<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Añade los nuevos campos solo si no existen
            if (!Schema::hasColumn('products', 'barcode')) {
                $table->string('barcode')->nullable()->unique()->after('image');
            }
            
            if (!Schema::hasColumn('products', 'barcode_image')) {
                $table->string('barcode_image')->nullable()->after('barcode');
            }
            
            // Opcional: cambiar propiedades de campos existentes si es necesario
            $table->string('image')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Código para revertir los cambios
            if (Schema::hasColumn('products', 'barcode')) {
                $table->dropColumn('barcode');
            }
            
            if (Schema::hasColumn('products', 'barcode_image')) {
                $table->dropColumn('barcode_image');
            }
        });
    }
};