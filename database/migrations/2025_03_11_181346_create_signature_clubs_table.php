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
        Schema::create('signature_clubs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_program')->constrained('programs')->onDelete('cascade');
            $table->date('inicial_date')->nullable();
            $table->date('final_date')->nullable();
            $table->integer('points');
            $table->decimal('club_value', 8, 2);
            $table->integer('day');
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signature_clubs');
    }
};
