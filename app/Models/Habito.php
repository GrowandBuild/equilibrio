<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Habito extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'habitos';

    protected $fillable = [
        'usuario_id',
        'nome',
        'tipo',
        'emoji',
        'meta',
        'unidade',
        'descricao',
        'frequencia_tipo',
        'frequencia_config',
        'ativo',
        'ordem',
    ];

    protected $casts = [
        'meta' => 'decimal:2',
        'frequencia_config' => 'array',
        'ativo' => 'boolean',
        'ordem' => 'integer',
    ];

    /**
     * Relacionamento com Usuário
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relacionamento com Registros Diários
     */
    public function registros()
    {
        return $this->hasMany(RegistroDiario::class, 'habito_id');
    }

    /**
     * Registro de hoje
     */
    public function registroHoje()
    {
        return $this->hasOne(RegistroDiario::class, 'habito_id')
            ->whereDate('data', today());
    }

    /**
     * Verifica se hábito tem registros
     */
    public function temRegistros()
    {
        return $this->registros()->exists();
    }

    /**
     * Cor automática baseada no tipo
     */
    public function getCorAttribute()
    {
        return $this->tipo === 'bom' ? '#10B981' : '#EF4444';
    }

    /**
     * Scope para hábitos ativos
     */
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Scope para ordenação customizada
     */
    public function scopeOrdenados($query)
    {
        return $query->orderBy('ordem', 'asc')->orderBy('created_at', 'asc');
    }

    /**
     * Formata a meta baseado na unidade
     */
    public function getMetaFormatadaAttribute()
    {
        $unidadesInteiras = ['vezes', 'unidades', 'porções', 'páginas', 'repetições', 'passos', 'copos', 'minutos', 'horas', 'calorias', 'gramas'];
        
        if (in_array($this->unidade, $unidadesInteiras)) {
            return number_format($this->meta, 0, ',', '.');
        }
        
        return number_format($this->meta, 2, ',', '.');
    }

    /**
     * Retorna o step apropriado para input baseado na unidade
     */
    public function getStepAttribute()
    {
        $unidadesInteiras = ['vezes', 'unidades', 'porções', 'páginas', 'repetições', 'passos', 'copos', 'minutos', 'horas', 'calorias', 'gramas'];
        
        if (in_array($this->unidade, $unidadesInteiras)) {
            return '1';
        }
        
        return '0.1';
    }

    /**
     * Retorna o valor formatado para input baseado na unidade
     */
    public function getValorInputAttribute()
    {
        $unidadesInteiras = ['vezes', 'unidades', 'porções', 'páginas', 'repetições', 'passos', 'copos', 'minutos', 'horas', 'calorias', 'gramas'];
        
        if (in_array($this->unidade, $unidadesInteiras)) {
            return number_format($this->meta, 0, '.', '');
        }
        
        return number_format($this->meta, 2, '.', '');
    }
}

