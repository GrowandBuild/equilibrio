<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConquistaUsuario extends Model
{
    use HasFactory;

    protected $table = 'conquistas_usuarios';

    protected $fillable = [
        'usuario_id',
        'emblema_id',
        'desbloqueado_em',
        'visualizado',
    ];

    protected $casts = [
        'desbloqueado_em' => 'datetime',
        'visualizado' => 'boolean',
    ];

    /**
     * Relacionamento com Usuário
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relacionamento com Emblema
     */
    public function emblema()
    {
        return $this->belongsTo(Emblema::class, 'emblema_id');
    }
}

