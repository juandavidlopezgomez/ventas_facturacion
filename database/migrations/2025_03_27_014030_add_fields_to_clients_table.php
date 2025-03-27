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
    Schema::table('clients', function (Blueprint $table) {
        $table->string('preferred_bike_type')->nullable()->after('address');
        $table->boolean('is_loyalty_member')->default(false)->after('preferred_bike_type');
        $table->integer('total_purchases')->default(0)->after('is_loyalty_member');
    });
}

public function down()
{
    Schema::table('clients', function (Blueprint $table) {
        $table->dropColumn('preferred_bike_type');
        $table->dropColumn('is_loyalty_member');
        $table->dropColumn('total_purchases');
    });
}
};
