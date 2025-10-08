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
        Schema::create('habitos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->string('nome');
            $table->enum('tipo', ['bom', 'ruim']);
            $table->string('emoji')->default('🎯');
            $table->decimal('meta', 10, 2);
            $table->string('unidade'); // litros, minutos, unidades, etc
            $table->text('descricao')->nullable();
            
            // Frequência personalizável
            $table->enum('frequencia_tipo', ['diaria', 'semanal', 'mensal', 'dias_especificos', 'intervalo_dias']);
            $table->json('frequencia_config')->nullable(); // Para dias específicos, intervalos, etc
            
            $table->boolean('ativo')->default(true);
            $table->integer('ordem')->default(0); // Para ordenação customizada
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['usuario_id', 'ativo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitos');
    }
};

