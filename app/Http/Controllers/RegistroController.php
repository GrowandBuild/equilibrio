<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habito;
use App\Models\RegistroDiario;
use App\Models\UsuarioXp;
use App\Models\Emblema;
use App\Models\ConquistaUsuario;
use Carbon\Carbon;

class RegistroController extends Controller
{
    /**
     * Tela de registro diário
     */
    public function index()
    {
        $usuario = auth()->user();
        $habitos = $usuario->habitosAtivos;
        
        // Registros de hoje
        $registros = RegistroDiario::where('usuario_id', $usuario->id)
            ->whereDate('data', today())
            ->get()
            ->keyBy('habito_id');
        
        // Combina hábitos com registros
        $habitosComRegistro = $habitos->map(function ($habito) use ($registros) {
            return [
                'habito' => $habito,
                'registro' => $registros->get($habito->id),
                'quantidade' => $registros->get($habito->id)->quantidade_realizada ?? 0,
            ];
        });
        
        return view('registros.index', compact('habitosComRegistro'));
    }

    /**
     * Atualiza/cria registro de um hábito
     */
    public function atualizar(Request $request, Habito $habito)
    {
        // Verifica se é do usuário
        if ($habito->usuario_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'quantidade' => 'required|numeric|min:0',
        ]);

        // Busca ou cria registro de hoje
        $registro = RegistroDiario::updateOrCreate(
            [
                'habito_id' => $habito->id,
                'data' => today(),
            ],
            [
                'usuario_id' => auth()->id(),
                'quantidade_realizada' => $validated['quantidade'],
            ]
        );

        // Calcula XP
        $xpAntigo = $registro->xp_ganho;
        $registro->calcularXP();
        $registro->save();
        
        // Atualiza XP do usuário
        $usuario = auth()->user();
        $usuarioXp = $usuario->xp;
        $diferencaXp = $registro->xp_ganho - $xpAntigo;
        
        if ($diferencaXp != 0) {
            $usuarioXp->adicionarXP($diferencaXp);
        }
        
        // Atualiza sequência
        $usuarioXp->atualizarSequencia();
        
        // Verifica emblemas
        $this->verificarEmblemas($usuario, $usuarioXp);

        return response()->json([
            'success' => true,
            'registro' => $registro,
            'xp_ganho' => $registro->xp_ganho,
            'meta_cumprida' => $registro->meta_cumprida,
            'progresso' => $registro->progresso,
            'xp_total' => $usuarioXp->xp_total,
            'nivel' => $usuarioXp->nivel_atual,
        ]);
    }

    /**
     * Incrementa quantidade
     */
    public function incrementar(Request $request, Habito $habito)
    {
        // Verifica se é do usuário
        if ($habito->usuario_id !== auth()->id()) {
            abort(403);
        }

        // Busca registro de hoje
        $registro = RegistroDiario::firstOrCreate(
            [
                'habito_id' => $habito->id,
                'data' => today(),
            ],
            [
                'usuario_id' => auth()->id(),
                'quantidade_realizada' => 0,
            ]
        );

        // Define incremento inteligente baseado na unidade
        $incremento = $this->getIncremento($habito->unidade);
        $registro->quantidade_realizada += $incremento;
        
        // Calcula XP
        $xpAntigo = $registro->xp_ganho;
        $registro->calcularXP();
        $registro->save();
        
        // Atualiza XP do usuário
        $this->atualizarXpUsuario($xpAntigo, $registro);

        return response()->json([
            'success' => true,
            'quantidade' => $registro->quantidade_realizada,
            'xp_ganho' => $registro->xp_ganho,
            'meta_cumprida' => $registro->meta_cumprida,
            'progresso' => $registro->progresso,
        ]);
    }

    /**
     * Decrementa quantidade
     */
    public function decrementar(Request $request, Habito $habito)
    {
        // Verifica se é do usuário
        if ($habito->usuario_id !== auth()->id()) {
            abort(403);
        }

        // Busca registro de hoje
        $registro = RegistroDiario::where('habito_id', $habito->id)
            ->whereDate('data', today())
            ->first();

        if (!$registro || $registro->quantidade_realizada <= 0) {
            return response()->json(['success' => false, 'message' => 'Quantidade já está em zero']);
        }

        // Define decremento
        $decremento = $this->getIncremento($habito->unidade);
        $registro->quantidade_realizada = max(0, $registro->quantidade_realizada - $decremento);
        
        // Calcula XP
        $xpAntigo = $registro->xp_ganho;
        $registro->calcularXP();
        $registro->save();
        
        // Atualiza XP do usuário
        $this->atualizarXpUsuario($xpAntigo, $registro);

        return response()->json([
            'success' => true,
            'quantidade' => $registro->quantidade_realizada,
            'xp_ganho' => $registro->xp_ganho,
            'meta_cumprida' => $registro->meta_cumprida,
            'progresso' => $registro->progresso,
        ]);
    }

    /**
     * Retorna incremento inteligente baseado na unidade
     */
    private function getIncremento($unidade)
    {
        $incrementos = [
            'litros' => 0.5,
            'ml' => 100,
            'minutos' => 15,
            'horas' => 0.5,
            'km' => 1,
            'metros' => 100,
            'páginas' => 10,
            'calorias' => 100,
            'gramas' => 50,
            'kg' => 0.5,
        ];

        return $incrementos[$unidade] ?? 1;
    }

    /**
     * Atualiza XP do usuário
     */
    private function atualizarXpUsuario($xpAntigo, $registro)
    {
        $usuario = auth()->user();
        $usuarioXp = $usuario->xp;
        $diferencaXp = $registro->xp_ganho - $xpAntigo;
        
        if ($diferencaXp != 0) {
            $usuarioXp->adicionarXP($diferencaXp);
        }
        
        $usuarioXp->atualizarSequencia();
        $this->verificarEmblemas($usuario, $usuarioXp);
    }

    /**
     * Verifica e desbloqueia emblemas
     */
    private function verificarEmblemas($usuario, $usuarioXp)
    {
        // Emblemas de sequência
        $sequencias = [
            ['slug' => 'sequencia-3-dias', 'dias' => 3],
            ['slug' => 'sequencia-7-dias', 'dias' => 7],
            ['slug' => 'sequencia-14-dias', 'dias' => 14],
            ['slug' => 'sequencia-30-dias', 'dias' => 30],
        ];

        foreach ($sequencias as $seq) {
            if ($usuarioXp->sequencia_dias_atual >= $seq['dias']) {
                $this->desbloquearEmblema($usuario, $seq['slug']);
            }
        }

        // Outros emblemas...
        // Implementar lógica conforme necessário
    }

    /**
     * Desbloqueia emblema para usuário
     */
    private function desbloquearEmblema($usuario, $slug)
    {
        $emblema = Emblema::where('slug', $slug)->first();
        
        if (!$emblema) return;

        // Verifica se já tem
        $jaDesbloqueado = ConquistaUsuario::where('usuario_id', $usuario->id)
            ->where('emblema_id', $emblema->id)
            ->exists();

        if (!$jaDesbloqueado) {
            ConquistaUsuario::create([
                'usuario_id' => $usuario->id,
                'emblema_id' => $emblema->id,
                'desbloqueado_em' => now(),
                'visualizado' => false,
            ]);

            // Adicionar XP bônus
            $bonus = $this->getBonusSequencia($slug);
            $usuario->xp->adicionarXP($bonus);
        }
    }

    /**
     * Retorna bônus de XP por emblema
     */
    private function getBonusSequencia($slug)
    {
        $bonus = [
            'sequencia-3-dias' => 150,
            'sequencia-7-dias' => 300,
            'sequencia-14-dias' => 500,
            'sequencia-30-dias' => 1000,
        ];

        return $bonus[$slug] ?? 0;
    }
}

