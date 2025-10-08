<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habito;
use App\Models\RegistroDiario;
use App\Models\UsuarioXp;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();
        
        // Inicializa XP se necessário
        $usuario->inicializarXP();
        
        // Dados do usuário
        $usuarioXp = $usuario->xp;
        
        // Hábitos ativos
        $habitos = $usuario->habitosAtivos;
        
        // Registros de hoje
        $registrosHoje = $usuario->registrosHoje;
        
        // Cria array com todos hábitos e seus registros
        $habitosComRegistro = $habitos->map(function ($habito) use ($registrosHoje) {
            $registro = $registrosHoje->firstWhere('habito_id', $habito->id);
            return [
                'habito' => $habito,
                'registro' => $registro,
            ];
        });
        
        // Estatísticas do dia
        $metasCumpridasHoje = $registrosHoje->where('meta_cumprida', true)->count();
        $xpGanhoHoje = $registrosHoje->sum('xp_ganho');
        
        // Conquistas recentes (últimas 5)
        $conquistasRecentes = $usuario->conquistas()
            ->with('emblema')
            ->orderBy('desbloqueado_em', 'desc')
            ->limit(5)
            ->get();
        
        // Conquistas não visualizadas
        $conquistasNovas = $usuario->conquistas()
            ->where('visualizado', false)
            ->with('emblema')
            ->get();
        
        return view('dashboard', compact(
            'usuario',
            'usuarioXp',
            'habitos',
            'metasCumpridasHoje',
            'xpGanhoHoje',
            'conquistasRecentes',
            'conquistasNovas'
        ));
    }
}

