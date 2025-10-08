<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BarraXp extends Component
{
    public $usuarioXp;
    public $xp_total;
    public $nivel_atual;
    public $progresso_nivel;
    public $xp_proximo_nivel;

    protected $listeners = ['xpAtualizado' => 'atualizarXp'];

    public function mount()
    {
        $this->atualizarDados();
    }

    public function atualizarXp()
    {
        $this->atualizarDados();
        
        $this->dispatchBrowserEvent('xp-ganho-animation');
    }

    private function atualizarDados()
    {
        $this->usuarioXp = auth()->user()->xp;
        $this->usuarioXp->fresh();
        
        $this->xp_total = $this->usuarioXp->xp_total;
        $this->nivel_atual = $this->usuarioXp->nivel_atual;
        $this->progresso_nivel = $this->usuarioXp->progresso_nivel;
        $this->xp_proximo_nivel = $this->usuarioXp->xp_proximo_nivel;
    }

    public function render()
    {
        return view('livewire.barra-xp');
    }
}

