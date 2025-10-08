<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habito;

class HabitoController extends Controller
{
    /**
     * Lista todos os hábitos
     */
    public function index()
    {
        $habitos = auth()->user()->habitosAtivos;
        $habitosArquivados = auth()->user()->habitos()->where('ativo', false)->get();
        
        return view('habitos.index', compact('habitos', 'habitosArquivados'));
    }

    /**
     * Formulário de criação
     */
    public function create()
    {
        $emojis = $this->getEmojisSugeridos();
        $unidades = $this->getUnidades();
        
        return view('habitos.create', compact('emojis', 'unidades'));
    }

    /**
     * Salva novo hábito
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:bom,ruim',
            'emoji' => 'required|string|max:10',
            'meta' => 'required|numeric|min:0',
            'unidade' => 'required|string|max:50',
            'descricao' => 'nullable|string|max:500',
            'frequencia_tipo' => 'required|in:diaria,semanal,mensal,dias_especificos,intervalo_dias',
            'frequencia_config' => 'nullable|array',
        ]);

        $validated['usuario_id'] = auth()->id();
        $validated['ordem'] = Habito::where('usuario_id', auth()->id())->max('ordem') + 1;

        Habito::create($validated);

        return redirect()->route('habitos.index')
            ->with('success', 'Hábito criado com sucesso! 🎉');
    }

    /**
     * Formulário de edição
     */
    public function edit(Habito $habito)
    {
        // Verifica se é do usuário
        if ($habito->usuario_id !== auth()->id()) {
            abort(403);
        }

        $emojis = $this->getEmojisSugeridos();
        $unidades = $this->getUnidades();
        
        return view('habitos.edit', compact('habito', 'emojis', 'unidades'));
    }

    /**
     * Atualiza hábito
     */
    public function update(Request $request, Habito $habito)
    {
        // Verifica se é do usuário
        if ($habito->usuario_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:bom,ruim',
            'emoji' => 'required|string|max:10',
            'meta' => 'required|numeric|min:0',
            'unidade' => 'required|string|max:50',
            'descricao' => 'nullable|string|max:500',
            'frequencia_tipo' => 'required|in:diaria,semanal,mensal,dias_especificos,intervalo_dias',
            'frequencia_config' => 'nullable|array',
        ]);

        $habito->update($validated);

        return redirect()->route('habitos.index')
            ->with('success', 'Hábito atualizado com sucesso! ✨');
    }

    /**
     * Arquiva/desativa hábito
     */
    public function arquivar(Habito $habito)
    {
        // Verifica se é do usuário
        if ($habito->usuario_id !== auth()->id()) {
            abort(403);
        }

        $habito->update(['ativo' => false]);

        return redirect()->route('habitos.index')
            ->with('success', 'Hábito arquivado com sucesso!');
    }

    /**
     * Reativa hábito
     */
    public function reativar(Habito $habito)
    {
        // Verifica se é do usuário
        if ($habito->usuario_id !== auth()->id()) {
            abort(403);
        }

        $habito->update(['ativo' => true]);

        return redirect()->route('habitos.index')
            ->with('success', 'Hábito reativado com sucesso! 🎉');
    }

    /**
     * Exclui hábito (só se não tiver registros)
     */
    public function destroy(Habito $habito)
    {
        // Verifica se é do usuário
        if ($habito->usuario_id !== auth()->id()) {
            abort(403);
        }

        // Verifica se pode excluir
        if ($habito->temRegistros()) {
            return redirect()->route('habitos.index')
                ->with('error', 'Não é possível excluir um hábito que já tem registros. Você pode apenas arquivá-lo.');
        }

        $habito->delete();

        return redirect()->route('habitos.index')
            ->with('success', 'Hábito excluído com sucesso!');
    }

    /**
     * Atualiza ordem dos hábitos
     */
    public function reordenar(Request $request)
    {
        $ordens = $request->input('ordens', []);
        
        foreach ($ordens as $id => $ordem) {
            Habito::where('id', $id)
                ->where('usuario_id', auth()->id())
                ->update(['ordem' => $ordem]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Emojis sugeridos
     */
    private function getEmojisSugeridos()
    {
        return [
            'Saúde' => ['💧', '🏃', '🧘', '😴', '💊', '🦷', '🧴'],
            'Exercício' => ['💪', '🏋️', '🚴', '🏊', '⚽', '🏃‍♀️', '🤸'],
            'Alimentação' => ['🍎', '🥗', '🥤', '🍽️', '🥑', '🥕', '🫐'],
            'Produtividade' => ['📚', '✍️', '💻', '📝', '🎯', '⏰', '📊'],
            'Lazer' => ['🎮', '📺', '🎵', '🎨', '🎬', '🎪', '🎲'],
            'Social' => ['👥', '💬', '📱', '☎️', '✉️', '🤝', '💑'],
            'Vícios' => ['🚬', '🍺', '☕', '🍷', '🎰', '📱', '🍫'],
            'Outros' => ['🎯', '✨', '⭐', '🔥', '💎', '🏆', '🎁'],
        ];
    }

    /**
     * Unidades disponíveis
     */
    private function getUnidades()
    {
        return [
            'Quantidade' => ['unidades', 'vezes', 'porções'],
            'Volume' => ['litros', 'ml', 'copos'],
            'Tempo' => ['minutos', 'horas'],
            'Distância' => ['km', 'metros', 'passos'],
            'Peso' => ['kg', 'gramas'],
            'Outros' => ['páginas', 'calorias', 'repetições'],
        ];
    }
}

