<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        if (DB::getDriverName() === 'sqlite') {
            try {
                DB::statement('PRAGMA foreign_keys=OFF;');
                DB::statement('DROP TABLE IF EXISTS users_temp;');
                DB::statement('CREATE TABLE users_temp AS SELECT * FROM users;');
                Schema::dropIfExists('users');
                Schema::create('users', function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->string('email')->unique();
                    $table->string('password');
                    $table->string('role')->default('customer');
                    $table->string('phone')->nullable();
                    $table->rememberToken();
                    $table->timestamps();
                });
                DB::statement('INSERT INTO users (id, name, email, password, role, phone, remember_token, created_at, updated_at) SELECT id, name, email, password, role, phone, remember_token, created_at, updated_at FROM users_temp;');
                Schema::dropIfExists('users_temp');
                DB::statement('PRAGMA foreign_keys=ON;');
            } catch (\Throwable $e) {
                // Ignore if migration already ran
            }
        }
    }

    public function down(): void {
        //
    }
};
