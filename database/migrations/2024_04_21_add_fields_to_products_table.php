<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('unit')->default('Kg')->after('quantity');
            $table->enum('status', ['available', 'pending', 'sold'])->default('available')->after('unit');
            $table->string('type')->after('status');
            // Drop the category column as we're using type instead
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('category');
            $table->dropColumn(['unit', 'status', 'type']);
        });
    }
};
