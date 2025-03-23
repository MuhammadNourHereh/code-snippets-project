<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('password'); // Laravel uses 'password' by convention
            $table->timestamps(); // Creates 'created_at' and 'updated_at'
            $table->softDeletes(); // Creates 'deleted_at' for soft deletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
