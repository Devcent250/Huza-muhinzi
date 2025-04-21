<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cooperatives', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('location');
            $table->string('registration_number')->unique();
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->timestamps();
        });

        // Add cooperative_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('cooperative_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['cooperative_id']);
            $table->dropColumn('cooperative_id');
        });

        Schema::dropIfExists('cooperatives');
    }
};
