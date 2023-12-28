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
        Schema::create('users', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id()->autoIncrement();
            $table->string('user_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('age');
            $table->enum('gender' , ['male' , 'female']);
            $table->string('email')->unique();
            $table->bigInteger('phone_number');
            $table->string('password');
            $table->string('address');
            $table->bigInteger('post_code');
            $table->string('province');
            $table->string('city');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->enum('status' , ['enable' , 'disable'])->default('enable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
