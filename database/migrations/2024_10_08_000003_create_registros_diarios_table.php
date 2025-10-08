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
        Schema::create('registros_diarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('habito_id')->constrained('habitos')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->date('data');
            $table->decimal('quantidade_realizada', 10, 2)->default(0);
            $table->boolean('meta_cumprida')->default(false);
            $table->integer('xp_ganho')->default(0);
            $table->timestamps();
            
            // Índices para consultas rápidas
            $table->unique(['habito_id', 'data']);
            $table->index(['usuario_id', 'data']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_diarios');
    }
};

