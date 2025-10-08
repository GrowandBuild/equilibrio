<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\RegistroDiario;

class CardHabito extends Component
{
    public $habito;
    public $registro;
    public $quantidade = 0;

    protected $listeners = ['registroAtualizado'];

    public function mount($habito, $registro = null)
    {
        $this->habito = $habito;
        $this->registro = $registro;
        $this->quantidade = $registro ? $registro->quantidade_input : 0;
    }

    public function incrementar()
    {
        $incremento = $this->getIncremento();
        $this->quantidade += $incremento;
        $this->salvar();
    }

    public function decrementar()
    {
        $incremento = $this->getIncremento();
        $this->quantidade = max(0, $this->quantidade - $incremento);
        $this->salvar();
    }

    public function atualizar()
    {
        $this->salvar();
    }

    private function salvar()
    {
        $registro = RegistroDiario::updateOrCreate(
            [
                'habito_id' => $this->habito->id,
                'data' => today(),
            ],
            [
                'usuario_id' => auth()->id(),
                'quantidade_realizada' => $this->quantidade,
            ]
        );

        // Calcula XP
        $xpAntigo = $registro->xp_ganho;
        $registro->calcularXP();
        $registro->save();

        // Atualiza XP do usuário
        $usuario = auth()->user();
        $usuario->inicializarXP(); // Garante que o XP existe
        $usuarioXp = $usuario->xp;
        
        $diferencaXp = $registro->xp_ganho - $xpAntigo;
        if ($diferencaXp != 0) {
            $usuarioXp->adicionarXP($diferencaXp);
        }
        
        $usuarioXp->atualizarSequencia();
        
        $this->registro = $registro->fresh();
        
        // Emite evento para atualizar dashboard
        $this->emit('xpAtualizado', [
            'xp_total' => $usuarioXp->fresh()->xp_total,
            'nivel' => $usuarioXp->fresh()->nivel_atual,
        ]);

        // Mostra notificação
        if ($registro->meta_cumprida) {
            $this->emit('meta-cumprida', [
                'habito' => $this->habito->nome,
                'emoji' => $this->habito->emoji,
            ]);
        }
    }

    private function getIncremento()
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

        return $incrementos[$this->habito->unidade] ?? 1;
    }

    public function render()
    {
        $progresso = 0;
        if ($this->habito->meta > 0) {
            $progresso = min(($this->quantidade / $this->habito->meta) * 100, 100);
        }

        $metaCumprida = false;
        if ($this->habito->tipo === 'bom') {
            $metaCumprida = $this->quantidade >= $this->habito->meta;
        } else {
            $metaCumprida = $this->quantidade <= $this->habito->meta;
        }

        return view('livewire.card-habito', [
            'progresso' => $progresso,
            'metaCumprida' => $metaCumprida,
        ]);
    }
}

