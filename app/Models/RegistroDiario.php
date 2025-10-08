<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroDiario extends Model
{
    use HasFactory;

    protected $table = 'registros_diarios';

    protected $fillable = [
        'habito_id',
        'usuario_id',
        'data',
        'quantidade_realizada',
        'meta_cumprida',
        'xp_ganho',
    ];

    protected $casts = [
        'data' => 'date',
        'quantidade_realizada' => 'decimal:2',
        'meta_cumprida' => 'boolean',
        'xp_ganho' => 'integer',
    ];

    /**
     * Relacionamento com Hábito
     */
    public function habito()
    {
        return $this->belongsTo(Habito::class, 'habito_id');
    }

    /**
     * Relacionamento com Usuário
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Calcula XP baseado no desempenho
     */
    public function calcularXP()
    {
        $habito = $this->habito;
        $quantidade = $this->quantidade_realizada;
        $meta = $habito->meta;
        $xp = 0;

        if ($habito->tipo === 'bom') {
            // Hábito bom
            if ($quantidade >= $meta) {
                $xp = 100; // Meta cumprida
                if ($quantidade > $meta) {
                    $xp += 50; // Bônus por exceder
                }
                $this->meta_cumprida = true;
            } else {
                $xp = 0; // Não atingiu meta
                $this->meta_cumprida = false;
            }
        } else {
            // Hábito ruim
            if ($quantidade <= $meta) {
                $xp = 100; // Dentro do limite
                $this->meta_cumprida = true;
            } else {
                $xp = -50; // Excedeu o limite
                $this->meta_cumprida = false;
            }
        }

        $this->xp_ganho = $xp;
        return $xp;
    }

    /**
     * Percentual de progresso
     */
    public function getProgressoAttribute()
    {
        $habito = $this->habito;
        if (!$habito || $habito->meta == 0) return 0;

        $percentual = ($this->quantidade_realizada / $habito->meta) * 100;
        return min($percentual, 100);
    }

    /**
     * Status visual (sucesso, alerta, erro)
     */
    public function getStatusAttribute()
    {
        if ($this->meta_cumprida) {
            return 'sucesso';
        }
        
        $progresso = $this->progresso;
        if ($progresso >= 70) {
            return 'alerta';
        }
        
        return 'erro';
    }

    /**
     * Retorna a quantidade realizada formatada baseada na unidade do hábito
     */
    public function getQuantidadeFormatadaAttribute()
    {
        $unidadesInteiras = ['vezes', 'unidades', 'porções', 'páginas', 'repetições', 'passos', 'copos'];
        
        if (in_array($this->habito->unidade, $unidadesInteiras)) {
            return number_format($this->quantidade_realizada, 0, ',', '.');
        }
        
        return number_format($this->quantidade_realizada, 2, ',', '.');
    }

    /**
     * Retorna o valor da quantidade para input baseado na unidade do hábito
     */
    public function getQuantidadeInputAttribute()
    {
        $unidadesInteiras = ['vezes', 'unidades', 'porções', 'páginas', 'repetições', 'passos', 'copos'];
        
        if (in_array($this->habito->unidade, $unidadesInteiras)) {
            return number_format($this->quantidade_realizada, 0, '.', '');
        }
        
        return number_format($this->quantidade_realizada, 2, '.', '');
    }
}

