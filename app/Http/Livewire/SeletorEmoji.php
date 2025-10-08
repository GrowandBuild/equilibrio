<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SeletorEmoji extends Component
{
    public $emojiSelecionado = '🎯';
    public $pesquisa = '';
    public $mostrarModal = false;

    public function mount($emoji = '🎯')
    {
        $this->emojiSelecionado = $emoji;
    }

    public function abrirModal()
    {
        $this->mostrarModal = true;
    }

    public function fecharModal()
    {
        $this->mostrarModal = false;
        $this->pesquisa = '';
    }

    public function selecionarEmoji($emoji)
    {
        $this->emojiSelecionado = $emoji;
        $this->fecharModal();
        $this->emit('emojiSelecionado', $emoji);
    }

    public function getEmojisSugeridos()
    {
        return [
            'Saúde' => ['💧', '🏃', '🧘', '😴', '💊', '🦷', '🧴', '🩺', '💉', '🏥'],
            'Exercício' => ['💪', '🏋️', '🚴', '🏊', '⚽', '🏃‍♀️', '🤸', '🧗', '⛹️', '🤾'],
            'Alimentação' => ['🍎', '🥗', '🥤', '🍽️', '🥑', '🥕', '🫐', '🥦', '🍊', '🥬'],
            'Produtividade' => ['📚', '✍️', '💻', '📝', '🎯', '⏰', '📊', '📈', '💼', '🗂️'],
            'Lazer' => ['🎮', '📺', '🎵', '🎨', '🎬', '🎪', '🎲', '🎭', '🎹', '🎸'],
            'Social' => ['👥', '💬', '📱', '☎️', '✉️', '🤝', '💑', '👨‍👩‍👧', '🫂', '🤗'],
            'Vícios' => ['🚬', '🍺', '☕', '🍷', '🎰', '📱', '🍫', '🍕', '🍔', '🍰'],
            'Outros' => ['🎯', '✨', '⭐', '🔥', '💎', '🏆', '🎁', '🌟', '💫', '⚡'],
        ];
    }

    public function render()
    {
        $emojis = $this->getEmojisSugeridos();
        
        // Filtrar por pesquisa (implementar se necessário)
        
        return view('livewire.seletor-emoji', compact('emojis'));
    }
}

