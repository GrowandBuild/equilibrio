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
        Schema::create('usuarios_xp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->integer('xp_total')->default(0);
            $table->string('nivel_atual')->default('Iniciante');
            $table->integer('sequencia_dias_atual')->default(0);
            $table->date('ultima_atividade')->nullable();
            $table->date('melhor_sequencia_inicio')->nullable();
            $table->integer('melhor_sequencia_dias')->default(0);
            $table->timestamps();
            
            $table->unique('usuario_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios_xp');
    }
};

