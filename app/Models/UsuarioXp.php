<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioXp extends Model
{
    use HasFactory;

    protected $table = 'usuarios_xp';

    protected $fillable = [
        'usuario_id',
        'xp_total',
        'nivel_atual',
        'sequencia_dias_atual',
        'ultima_atividade',
        'melhor_sequencia_inicio',
        'melhor_sequencia_dias',
    ];

    protected $casts = [
        'xp_total' => 'integer',
        'sequencia_dias_atual' => 'integer',
        'melhor_sequencia_dias' => 'integer',
        'ultima_atividade' => 'date',
        'melhor_sequencia_inicio' => 'date',
    ];

    /**
     * Relacionamento com Usuário
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Níveis disponíveis
     */
    public static function niveis()
    {
        return [
            ['nome' => 'Iniciante', 'xp_min' => 0, 'xp_max' => 1000],
            ['nome' => 'Constante', 'xp_min' => 1000, 'xp_max' => 5000],
            ['nome' => 'Disciplinado', 'xp_min' => 5000, 'xp_max' => 15000],
            ['nome' => 'Mestre do Equilíbrio', 'xp_min' => 15000, 'xp_max' => PHP_INT_MAX],
        ];
    }

    /**
     * Calcula nível baseado no XP total
     */
    public function calcularNivel()
    {
        foreach (self::niveis() as $nivel) {
            if ($this->xp_total >= $nivel['xp_min'] && $this->xp_total < $nivel['xp_max']) {
                $this->nivel_atual = $nivel['nome'];
                return $nivel;
            }
        }
        return end(self::niveis());
    }

    /**
     * Adiciona XP
     */
    public function adicionarXP($xp)
    {
        $this->xp_total += $xp;
        $this->calcularNivel();
        $this->save();
    }

    /**
     * Atualiza sequência
     */
    public function atualizarSequencia()
    {
        $hoje = today();
        $ontem = today()->subDay();

        if (!$this->ultima_atividade) {
            // Primeira atividade
            $this->sequencia_dias_atual = 1;
            $this->ultima_atividade = $hoje;
        } elseif ($this->ultima_atividade->eq($ontem)) {
            // Continuou a sequência
            $this->sequencia_dias_atual++;
            $this->ultima_atividade = $hoje;
        } elseif ($this->ultima_atividade->lt($ontem)) {
            // Quebrou a sequência
            $this->sequencia_dias_atual = 1;
            $this->ultima_atividade = $hoje;
        }
        // Se já registrou hoje, não faz nada

        // Atualiza melhor sequência
        if ($this->sequencia_dias_atual > $this->melhor_sequencia_dias) {
            $this->melhor_sequencia_dias = $this->sequencia_dias_atual;
            $this->melhor_sequencia_inicio = $hoje->copy()->subDays($this->sequencia_dias_atual - 1);
        }

        $this->save();
    }

    /**
     * Progresso até próximo nível
     */
    public function getProgressoNivelAttribute()
    {
        $nivelAtual = null;
        foreach (self::niveis() as $nivel) {
            if ($nivel['nome'] === $this->nivel_atual) {
                $nivelAtual = $nivel;
                break;
            }
        }

        if (!$nivelAtual) return 100;

        $xpNoNivel = $this->xp_total - $nivelAtual['xp_min'];
        $xpNecessario = $nivelAtual['xp_max'] - $nivelAtual['xp_min'];

        if ($xpNecessario >= PHP_INT_MAX) return 100;

        return min(($xpNoNivel / $xpNecessario) * 100, 100);
    }

    /**
     * XP necessário para próximo nível
     */
    public function getXpProximoNivelAttribute()
    {
        $nivelAtual = null;
        foreach (self::niveis() as $nivel) {
            if ($nivel['nome'] === $this->nivel_atual) {
                $nivelAtual = $nivel;
                break;
            }
        }

        if (!$nivelAtual || $nivelAtual['xp_max'] >= PHP_INT_MAX) return 0;

        return $nivelAtual['xp_max'] - $this->xp_total;
    }
}

