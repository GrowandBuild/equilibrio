<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'foto',
        'biografia',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relacionamento com Hábitos
     */
    public function habitos()
    {
        return $this->hasMany(Habito::class, 'usuario_id');
    }

    /**
     * Hábitos ativos
     */
    public function habitosAtivos()
    {
        return $this->hasMany(Habito::class, 'usuario_id')->where('ativo', true)->ordenados();
    }

    /**
     * Relacionamento com Registros Diários
     */
    public function registros()
    {
        return $this->hasMany(RegistroDiario::class, 'usuario_id');
    }

    /**
     * Registros de hoje
     */
    public function registrosHoje()
    {
        return $this->hasMany(RegistroDiario::class, 'usuario_id')
            ->whereDate('data', today())
            ->with('habito');
    }

    /**
     * Relacionamento com XP
     */
    public function xp()
    {
        return $this->hasOne(UsuarioXp::class, 'usuario_id');
    }

    /**
     * Relacionamento com Conquistas
     */
    public function conquistas()
    {
        return $this->hasMany(ConquistaUsuario::class, 'usuario_id');
    }

    /**
     * Relacionamento com Emblemas desbloqueados
     */
    public function emblemas()
    {
        return $this->belongsToMany(Emblema::class, 'conquistas_usuarios', 'usuario_id', 'emblema_id')
            ->withTimestamps()
            ->withPivot(['desbloqueado_em', 'visualizado']);
    }

    /**
     * Inicializa XP do usuário
     */
    public function inicializarXP()
    {
        if (!$this->xp) {
            UsuarioXp::create([
                'usuario_id' => $this->id,
                'xp_total' => 0,
                'nivel_atual' => 'Iniciante',
                'sequencia_dias_atual' => 0,
            ]);
            $this->load('xp'); // Recarrega o relacionamento
        }
        
        return $this->xp;
    }

    /**
     * URL da foto ou avatar padrão
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto_perfil) {
            return asset('storage/' . $this->foto_perfil);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7c3aed&background=f3f4f6';
    }
}
