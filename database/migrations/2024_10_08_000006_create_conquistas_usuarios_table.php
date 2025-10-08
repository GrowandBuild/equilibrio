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
        Schema::create('conquistas_usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('emblema_id')->constrained('emblemas')->onDelete('cascade');
            $table->timestamp('desbloqueado_em');
            $table->boolean('visualizado')->default(false);
            $table->timestamps();
            
            $table->unique(['usuario_id', 'emblema_id']);
            $table->index(['usuario_id', 'visualizado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conquistas_usuarios');
    }
};

