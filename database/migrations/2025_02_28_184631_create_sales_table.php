<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Asegurar que las columnas existan y estén correctamente definidas
            if (!Schema::hasColumn('sales', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('sales', 'client_id')) {
                $table->foreignId('client_id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('sales', 'total')) {
                $table->decimal('total', 10, 2);
            }
            if (!Schema::hasColumn('sales', 'tax')) {
                $table->decimal('tax', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('sales', 'discount')) {
                $table->decimal('discount', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('sales', 'payment_method')) {
                $table->string('payment_method')->nullable();
            }
            if (!Schema::hasColumn('sales', 'is_invoiced')) {
                $table->boolean('is_invoiced')->default(false);
            }
            if (!Schema::hasColumn('sales', 'sale_date')) {
                $table->date('sale_date')->nullable();
            }
            if (!Schema::hasColumn('sales', 'status')) {
                $table->string('status')->default('pending');
            }
            if (!Schema::hasColumn('sales', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'tax', 'discount', 'payment_method', 'is_invoiced', 'sale_date', 'status']);
            $table->dropSoftDeletes();
        });
    }
};