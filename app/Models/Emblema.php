<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emblema extends Model
{
    use HasFactory;

    protected $table = 'emblemas';

    protected $fillable = [
        'nome',
        'slug',
        'descricao',
        'icone',
        'tipo',
        'condicao',
    ];

    protected $casts = [
        'condicao' => 'array',
    ];

    /**
     * Relacionamento com Conquistas de Usuários
     */
    public function conquistas()
    {
        return $this->hasMany(ConquistaUsuario::class, 'emblema_id');
    }

    /**
     * Usuários que desbloquearam este emblema
     */
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'conquistas_usuarios', 'emblema_id', 'usuario_id')
            ->withTimestamps()
            ->withPivot(['desbloqueado_em', 'visualizado']);
    }
}

