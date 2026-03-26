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
        Schema::create('loungescards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users');
            $table->foreignId('id_cardflag')->constrained('cardflags');
            $table->string('login')->nullable();
            $table->string('name');
            $table->integer('access_own')->nullable();
            $table->integer('access_guest')->nullable();
            $table->integer('access_own_used')->nullable();
            $table->integer('access_guest_used')->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loungescards');
    }
};
