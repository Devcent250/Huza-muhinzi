<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, modify the enum to allow NULL temporarily
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'cooperative_member', 'supplier', 'farmer') NULL");

        // Update existing cooperative_member roles to farmer
        DB::statement("UPDATE users SET role = 'farmer' WHERE role = 'cooperative_member'");

        // Now set it back to NOT NULL with the new enum values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'supplier', 'farmer') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, modify the enum to allow NULL temporarily
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'cooperative_member', 'supplier', 'farmer') NULL");

        // Update existing farmer roles back to cooperative_member
        DB::statement("UPDATE users SET role = 'cooperative_member' WHERE role = 'farmer'");

        // Now set it back to NOT NULL with the original enum values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'cooperative_member', 'supplier') NOT NULL");
    }
};
