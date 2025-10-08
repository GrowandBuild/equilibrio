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
            // Hábito bom - quanto mais, melhor
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
            // Hábito ruim - meta é o LIMITE MÁXIMO
            if ($quantidade == $meta) {
                // Exatamente no limite - meta cumprida
                $xp = 100;
                $this->meta_cumprida = true;
            } elseif ($quantidade < $meta) {
                // Abaixo do limite - meta cumprida com bônus
                $xp = 100 + (($meta - $quantidade) * 25); // Bônus por ficar abaixo
                $this->meta_cumprida = true;
            } else {
                // Acima do limite - PUNIÇÃO!
                $excesso = $quantidade - $meta;
                $xp = -50 - ($excesso * 25); // -50 base + -25 por cada unidade excedida
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

        if ($habito->tipo === 'bom') {
            // Hábito bom - quanto mais, melhor
            $percentual = ($this->quantidade_realizada / $habito->meta) * 100;
            return min($percentual, 100);
        } else {
            // Hábito ruim - meta é o limite máximo
            if ($this->quantidade_realizada <= $habito->meta) {
                // Dentro do limite - progresso baseado em quanto está abaixo
                $percentual = (($habito->meta - $this->quantidade_realizada) / $habito->meta) * 100;
                return min($percentual, 100);
            } else {
                // Excedeu o limite - progresso negativo
                return 0;
            }
        }
    }

    /**
     * Status visual (sucesso, alerta, erro)
     */
    public function getStatusAttribute()
    {
        $habito = $this->habito;
        
        if ($habito->tipo === 'bom') {
            // Hábito bom
            if ($this->meta_cumprida) {
                return 'sucesso';
            }
            
            $progresso = $this->progresso;
            if ($progresso >= 70) {
                return 'alerta';
            }
            
            return 'erro';
        } else {
            // Hábito ruim
            if ($this->quantidade_realizada > $habito->meta) {
                return 'erro'; // Excedeu o limite
            } elseif ($this->quantidade_realizada == $habito->meta) {
                return 'alerta'; // No limite exato
            } else {
                return 'sucesso'; // Abaixo do limite (bom!)
            }
        }
    }

    /**
     * Retorna a quantidade realizada formatada baseada na unidade do hábito
     */
    public function getQuantidadeFormatadaAttribute()
    {
        $unidadesInteiras = ['vezes', 'unidades', 'porções', 'páginas', 'repetições', 'passos', 'copos', 'minutos', 'horas', 'calorias', 'gramas'];
        
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
        $unidadesInteiras = ['vezes', 'unidades', 'porções', 'páginas', 'repetições', 'passos', 'copos', 'minutos', 'horas', 'calorias', 'gramas'];
        
        if (in_array($this->habito->unidade, $unidadesInteiras)) {
            return number_format($this->quantidade_realizada, 0, '.', '');
        }
        
        return number_format($this->quantidade_realizada, 2, '.', '');
    }
}

