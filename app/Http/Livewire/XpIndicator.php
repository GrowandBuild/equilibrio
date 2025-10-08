<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UsuarioXp;

class XpIndicator extends Component
{
    public $usuarioXp;
    public $xpTotal = 0;
    public $nivelAtual = 'Iniciante';
    public $progressoNivel = 0;
    public $xpProximoNivel = 0;

    protected $listeners = ['xpAtualizado'];

    public function mount()
    {
        $this->carregarDados();
    }

    public function xpAtualizado($data)
    {
        $this->xpTotal = $data['xp_total'];
        $this->nivelAtual = $data['nivel'];
        $this->calcularProgresso();
    }

    private function carregarDados()
    {
        $usuario = auth()->user();
        $this->usuarioXp = $usuario->inicializarXP();
        
        // Verificação de segurança
        if (!$this->usuarioXp) {
            $this->xpTotal = 0;
            $this->nivelAtual = 'Iniciante';
            $this->progressoNivel = 0;
            $this->xpProximoNivel = 500;
            return;
        }
        
        $this->xpTotal = $this->usuarioXp->xp_total ?? 0;
        $this->nivelAtual = $this->usuarioXp->nivel_atual ?? 'Iniciante';
        $this->calcularProgresso();
    }

    private function calcularProgresso()
    {
        $niveis = [
            'Iniciante' => 0,
            'Aprendiz' => 500,
            'Praticante' => 1500,
            'Experiente' => 3500,
            'Mestre' => 7000,
            'Lenda' => 15000,
        ];

        $nivelAtual = $this->nivelAtual;
        $niveisArray = array_keys($niveis);
        $indiceAtual = array_search($nivelAtual, $niveisArray);
        
        if ($indiceAtual === false || $indiceAtual >= count($niveisArray) - 1) {
            // Se é o último nível ou não encontrado
            $this->progressoNivel = 100;
            $this->xpProximoNivel = 0;
        } else {
            $nivelAtualXp = $niveis[$nivelAtual];
            $proximoNivel = $niveisArray[$indiceAtual + 1];
            $proximoNivelXp = $niveis[$proximoNivel];
            
            $this->xpProximoNivel = $proximoNivelXp - $this->xpTotal;
            $this->progressoNivel = min(100, (($this->xpTotal - $nivelAtualXp) / ($proximoNivelXp - $nivelAtualXp)) * 100);
        }
    }

    public function render()
    {
        return view('livewire.xp-indicator');
    }
}
