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
        Schema::create('seller_statuses', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('user_id');
            $table->enum('status' , ['not accepted' , 'accepted'])->default('not accepted');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_statuses');
    }
};
