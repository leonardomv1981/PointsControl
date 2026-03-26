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
        Schema::create('loungesaccesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_loungescard')->constrained('loungescards');
            $table->date('date')->nullable();
            $table->string('airport', 100)->nullable();
            $table->integer('access_own')->nullable();
            $table->integer('access_guest')->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loungesaccesses');
    }
};
