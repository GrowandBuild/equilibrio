<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroDiario;
use App\Models\Habito;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InsightsController extends Controller
{
    /**
     * Exibe página de insights
     */
    public function index(Request $request)
    {
        $usuario = auth()->user();
        $periodo = $request->input('periodo', '7'); // 7, 30, 90 dias
        $habitoId = $request->input('habito'); // ID do hábito específico para visualizar
        
        $dataInicio = today()->subDays($periodo - 1);
        $dataFim = today();
        
        // Se um hábito específico foi solicitado, filtra apenas ele
        $queryBase = RegistroDiario::where('usuario_id', $usuario->id);
        if ($habitoId) {
            $queryBase = $queryBase->where('habito_id', $habitoId);
        }
        
        // XP ao longo do período
        $xpPorDia = $queryBase->clone()
            ->whereBetween('data', [$dataInicio, $dataFim])
            ->selectRaw('DATE(data) as dia, SUM(xp_ganho) as total_xp')
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();
        
        // Melhores hábitos (mais XP ganho)
        $melhoresHabitos = RegistroDiario::where('usuario_id', $usuario->id)
            ->whereBetween('data', [$dataInicio, $dataFim])
            ->select('habito_id', DB::raw('SUM(xp_ganho) as total_xp'), DB::raw('COUNT(*) as dias_registrados'))
            ->groupBy('habito_id')
            ->orderByDesc('total_xp')
            ->limit(5)
            ->with('habito')
            ->get();
        
        // Piores hábitos (menos XP ou XP negativo)
        $pioresHabitos = RegistroDiario::where('usuario_id', $usuario->id)
            ->whereBetween('data', [$dataInicio, $dataFim])
            ->select('habito_id', DB::raw('SUM(xp_ganho) as total_xp'), DB::raw('COUNT(*) as dias_registrados'))
            ->groupBy('habito_id')
            ->orderBy('total_xp')
            ->limit(5)
            ->with('habito')
            ->get();
        
        // Taxa de cumprimento geral
        $totalRegistros = RegistroDiario::where('usuario_id', $usuario->id)
            ->whereBetween('data', [$dataInicio, $dataFim])
            ->count();
        
        $metasCumpridas = RegistroDiario::where('usuario_id', $usuario->id)
            ->whereBetween('data', [$dataInicio, $dataFim])
            ->where('meta_cumprida', true)
            ->count();
        
        $taxaCumprimento = $totalRegistros > 0 ? ($metasCumpridas / $totalRegistros) * 100 : 0;
        
        // Comparação com período anterior
        $periodoAnteriorInicio = $dataInicio->copy()->subDays($periodo);
        $periodoAnteriorFim = $dataInicio->copy()->subDay();
        
        $xpPeriodoAtual = RegistroDiario::where('usuario_id', $usuario->id)
            ->whereBetween('data', [$dataInicio, $dataFim])
            ->sum('xp_ganho');
        
        $xpPeriodoAnterior = RegistroDiario::where('usuario_id', $usuario->id)
            ->whereBetween('data', [$periodoAnteriorInicio, $periodoAnteriorFim])
            ->sum('xp_ganho');
        
        $melhoria = 0;
        if ($xpPeriodoAnterior > 0) {
            $melhoria = (($xpPeriodoAtual - $xpPeriodoAnterior) / $xpPeriodoAnterior) * 100;
        } elseif ($xpPeriodoAtual > 0) {
            $melhoria = 100;
        }
        
        // Frases motivacionais
        $frase = $this->getFraseMotivacional($melhoria, $taxaCumprimento, $usuario->xp->sequencia_dias_atual);
        
        // Hábito específico se solicitado
        $habitoEspecifico = null;
        if ($habitoId) {
            $habitoEspecifico = Habito::where('usuario_id', $usuario->id)
                ->where('id', $habitoId)
                ->first();
        }
        
        return view('insights.index', compact(
            'xpPorDia',
            'melhoresHabitos',
            'pioresHabitos',
            'taxaCumprimento',
            'xpPeriodoAtual',
            'melhoria',
            'habitoEspecifico',
            'frase',
            'periodo'
        ));
    }

    /**
     * Retorna frase motivacional baseada no desempenho
     */
    private function getFraseMotivacional($melhoria, $taxaCumprimento, $sequencia)
    {
        $frases = [];

        // Frases baseadas em melhoria
        if ($melhoria > 50) {
            $frases[] = "Incrível! Você melhorou {$melhoria}% em relação ao período anterior! 🚀";
        } elseif ($melhoria > 20) {
            $frases[] = "Ótimo progresso! Você está {$melhoria}% melhor! 💪";
        } elseif ($melhoria > 0) {
            $frases[] = "Evolução constante! Continue assim! ✨";
        } elseif ($melhoria < -20) {
            $frases[] = "Não desanime! Todo começo é difícil. O importante é continuar! 🌱";
        } else {
            $frases[] = "Mantenha o foco! Pequenos passos levam a grandes conquistas! 🎯";
        }

        // Frases baseadas em taxa de cumprimento
        if ($taxaCumprimento >= 90) {
            $frases[] = "Você está cumprindo {$taxaCumprimento}% das suas metas! Incrível! 🏆";
        } elseif ($taxaCumprimento >= 70) {
            $frases[] = "Bom trabalho! {$taxaCumprimento}% de aproveitamento! 👏";
        }

        // Frases baseadas em sequência
        if ($sequencia >= 30) {
            $frases[] = "{$sequencia} dias seguidos! Você é um mestre! 👑";
        } elseif ($sequencia >= 7) {
            $frases[] = "{$sequencia} dias de constância! Continue assim! 🔥";
        } elseif ($sequencia >= 3) {
            $frases[] = "{$sequencia} dias! Você está criando um hábito! 🌟";
        }

        return $frases[array_rand($frases)];
    }
}

