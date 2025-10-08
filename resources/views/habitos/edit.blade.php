<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('habitos.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-900">Editar Hábito</h2>
                <p class="text-sm text-gray-600 mt-1">{{ $habito->nome }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($habito->temRegistros())
                <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-lg mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-amber-800">
                                <strong>Atenção:</strong> Este hábito possui registros diários. 
                                Alterações podem afetar o histórico de progresso e estatísticas.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <form action="{{ route('habitos.update', $habito) }}" method="POST">
                    @csrf
                    @method('PUT')

                        {{-- Emoji --}}
                        <div class="mb-6">
                            <label for="emoji" class="block text-sm font-medium text-gray-700 mb-2">
                                Emoji do Hábito
                            </label>
                            
                            {{-- Barra de Pesquisa Inteligente --}}
                            <div class="mb-4 relative">
                                <div class="relative">
                                    <input type="text" 
                                           id="emoji-search" 
                                           placeholder="Digite qualquer coisa... (água, café, exercício, livro, etc.)"
                                           class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-lg">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Emojis em Tempo Real --}}
                            <div id="emoji-results" class="grid grid-cols-8 gap-2 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-4 bg-gray-50">
                                <!-- Emojis aparecerão aqui automaticamente -->
                            </div>

                            <input type="hidden" name="emoji" id="emoji" value="{{ old('emoji', $habito->emoji) }}">
                            @error('emoji')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    {{-- Nome --}}
                    <div class="mb-6">
                        <label for="nome" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nome do Hábito *
                        </label>
                        <input type="text" 
                               name="nome" 
                               id="nome" 
                               value="{{ old('nome', $habito->nome) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('nome')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tipo --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Tipo de Hábito *
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-500 transition-colors">
                                <input type="radio" name="tipo" value="bom" class="sr-only peer" required 
                                       {{ old('tipo', $habito->tipo) == 'bom' ? 'checked' : '' }}>
                                <div class="flex items-center w-full peer-checked:text-green-600">
                                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-2xl">✅</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold">Bom</p>
                                        <p class="text-xs text-gray-500">Quanto mais, melhor</p>
                                    </div>
                                </div>
                                <div class="absolute inset-0 border-2 border-green-500 rounded-lg opacity-0 peer-checked:opacity-100"></div>
                            </label>

                            <label class="relative flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-red-500 transition-colors">
                                <input type="radio" name="tipo" value="ruim" class="sr-only peer" 
                                       {{ old('tipo', $habito->tipo) == 'ruim' ? 'checked' : '' }}>
                                <div class="flex items-center w-full peer-checked:text-red-600">
                                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-2xl">❌</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold">Ruim</p>
                                        <p class="text-xs text-gray-500">Deve ser limitado</p>
                                    </div>
                                </div>
                                <div class="absolute inset-0 border-2 border-red-500 rounded-lg opacity-0 peer-checked:opacity-100"></div>
                            </label>
                        </div>
                    </div>

                    {{-- Meta e Unidade --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Meta Diária *
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <input type="number" 
                                   name="meta" 
                                   step="{{ $habito->step }}"
                                   min="0"
                                   value="{{ old('meta', $habito->valor_input) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            
                            <select name="unidade" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <optgroup label="Quantidade">
                                    <option value="unidades" {{ $habito->unidade == 'unidades' ? 'selected' : '' }}>Unidades</option>
                                    <option value="vezes" {{ $habito->unidade == 'vezes' ? 'selected' : '' }}>Vezes</option>
                                    <option value="porções" {{ $habito->unidade == 'porções' ? 'selected' : '' }}>Porções</option>
                                </optgroup>
                                <optgroup label="Volume">
                                    <option value="litros" {{ $habito->unidade == 'litros' ? 'selected' : '' }}>Litros</option>
                                    <option value="ml" {{ $habito->unidade == 'ml' ? 'selected' : '' }}>ML</option>
                                    <option value="copos" {{ $habito->unidade == 'copos' ? 'selected' : '' }}>Copos</option>
                                </optgroup>
                                <optgroup label="Tempo">
                                    <option value="minutos" {{ $habito->unidade == 'minutos' ? 'selected' : '' }}>Minutos</option>
                                    <option value="horas" {{ $habito->unidade == 'horas' ? 'selected' : '' }}>Horas</option>
                                </optgroup>
                                <optgroup label="Outros">
                                    <option value="páginas" {{ $habito->unidade == 'páginas' ? 'selected' : '' }}>Páginas</option>
                                    <option value="km" {{ $habito->unidade == 'km' ? 'selected' : '' }}>KM</option>
                                    <option value="calorias" {{ $habito->unidade == 'calorias' ? 'selected' : '' }}>Calorias</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    {{-- Frequência --}}
                    <div class="mb-6">
                        <label for="frequencia_tipo" class="block text-sm font-semibold text-gray-700 mb-2">
                            Frequência *
                        </label>
                        <select name="frequencia_tipo" id="frequencia_tipo" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="diaria" {{ $habito->frequencia_tipo == 'diaria' ? 'selected' : '' }}>Diária</option>
                            <option value="semanal" {{ $habito->frequencia_tipo == 'semanal' ? 'selected' : '' }}>Semanal</option>
                            <option value="mensal" {{ $habito->frequencia_tipo == 'mensal' ? 'selected' : '' }}>Mensal</option>
                        </select>
                    </div>

                    {{-- Descrição --}}
                    <div class="mb-8">
                        <label for="descricao" class="block text-sm font-semibold text-gray-700 mb-2">
                            Descrição (Opcional)
                        </label>
                        <textarea name="descricao" id="descricao" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('descricao', $habito->descricao) }}</textarea>
                    </div>

                    {{-- Botões --}}
                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('habitos.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-semibold">
                            Cancelar
                        </a>
                        <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-semibold">
                            Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emojiInput = document.getElementById('emoji');
            const searchInput = document.getElementById('emoji-search');
            const emojiResults = document.getElementById('emoji-results');
            
            // Base de dados MASSIVA de emojis com múltiplas palavras-chave
            const emojiDatabase = [
                // Água e Bebidas
                { emoji: '💧', keywords: ['água', 'agua', 'water', 'gota', 'drop', 'hidratação', 'hidratacao', 'beber', 'drink'] },
                { emoji: '🌊', keywords: ['água', 'agua', 'water', 'onda', 'wave', 'mar', 'oceano', 'liquido', 'líquido'] },
                { emoji: '💦', keywords: ['água', 'agua', 'water', 'gota', 'drop', 'suor', 'sweat', 'molhado', 'wet'] },
                { emoji: '☕', keywords: ['café', 'cafe', 'coffee', 'bebida', 'drink', 'quente', 'hot', 'energia', 'energy'] },
                { emoji: '🍵', keywords: ['chá', 'cha', 'tea', 'bebida', 'drink', 'quente', 'hot', 'verde', 'green'] },
                { emoji: '🥤', keywords: ['bebida', 'drink', 'refrigerante', 'soda', 'suco', 'juice', 'líquido', 'liquido'] },
                { emoji: '🧊', keywords: ['gelo', 'ice', 'frio', 'cold', 'cubo', 'crystal', 'água', 'agua'] },
                
                // Exercícios e Esportes
                { emoji: '🏃', keywords: ['correr', 'run', 'corrida', 'running', 'exercício', 'exercicio', 'cardio', 'fitness'] },
                { emoji: '🏃‍♀️', keywords: ['correr', 'run', 'corrida', 'running', 'mulher', 'woman', 'exercício', 'exercicio'] },
                { emoji: '🏃‍♂️', keywords: ['correr', 'run', 'corrida', 'running', 'homem', 'man', 'exercício', 'exercicio'] },
                { emoji: '💪', keywords: ['musculação', 'musculacao', 'muscle', 'força', 'forca', 'strength', 'treino', 'workout'] },
                { emoji: '🏋️', keywords: ['musculação', 'musculacao', 'muscle', 'peso', 'weight', 'academia', 'gym', 'treino'] },
                { emoji: '🚴', keywords: ['bicicleta', 'bike', 'ciclismo', 'cycling', 'pedalar', 'pedal', 'exercício', 'exercicio'] },
                { emoji: '🏊', keywords: ['nadar', 'swim', 'natação', 'natacao', 'piscina', 'pool', 'água', 'agua'] },
                { emoji: '🤸', keywords: ['ginástica', 'ginastica', 'gymnastics', 'acrobacia', 'flexibilidade', 'flexibility'] },
                { emoji: '🧘', keywords: ['meditação', 'meditacao', 'meditation', 'yoga', 'paz', 'peace', 'relaxar', 'relax'] },
                { emoji: '⚽', keywords: ['futebol', 'soccer', 'bola', 'ball', 'esporte', 'sport', 'jogo', 'game'] },
                { emoji: '🏀', keywords: ['basquete', 'basketball', 'bola', 'ball', 'esporte', 'sport', 'jogo', 'game'] },
                { emoji: '🎾', keywords: ['tênis', 'tenis', 'tennis', 'raquete', 'racket', 'esporte', 'sport'] },
                
                // Livros e Estudo
                { emoji: '📚', keywords: ['livro', 'book', 'livros', 'books', 'leitura', 'reading', 'estudo', 'study'] },
                { emoji: '📖', keywords: ['livro', 'book', 'aberto', 'open', 'leitura', 'reading', 'página', 'page'] },
                { emoji: '📝', keywords: ['escrever', 'write', 'escrita', 'writing', 'nota', 'note', 'anotar', 'anotação'] },
                { emoji: '✍️', keywords: ['escrever', 'write', 'escrita', 'writing', 'mão', 'hand', 'caneta', 'pen'] },
                { emoji: '📄', keywords: ['papel', 'paper', 'documento', 'document', 'página', 'page', 'folha', 'sheet'] },
                { emoji: '🎓', keywords: ['formatura', 'graduation', 'universidade', 'university', 'estudo', 'study', 'diploma'] },
                { emoji: '🧠', keywords: ['cérebro', 'cerebro', 'brain', 'mente', 'mind', 'inteligência', 'inteligencia', 'pensar'] },
                
                // Comida e Alimentação
                { emoji: '🍎', keywords: ['maçã', 'maca', 'apple', 'fruta', 'fruit', 'saudável', 'saudavel', 'healthy'] },
                { emoji: '🥗', keywords: ['salada', 'salad', 'verde', 'green', 'vegetal', 'vegetable', 'saudável', 'saudavel'] },
                { emoji: '🥑', keywords: ['abacate', 'avocado', 'fruta', 'fruit', 'verde', 'green', 'saudável', 'saudavel'] },
                { emoji: '🥕', keywords: ['cenoura', 'carrot', 'vegetal', 'vegetable', 'laranja', 'orange', 'saudável', 'saudavel'] },
                { emoji: '🍌', keywords: ['banana', 'fruta', 'fruit', 'amarelo', 'yellow', 'potássio', 'potassio', 'potassium'] },
                { emoji: '🍇', keywords: ['uva', 'grape', 'fruta', 'fruit', 'roxo', 'purple', 'vinho', 'wine'] },
                { emoji: '🥜', keywords: ['noz', 'nut', 'castanha', 'nuts', 'proteína', 'proteina', 'protein', 'saudável'] },
                { emoji: '🥛', keywords: ['leite', 'milk', 'bebida', 'drink', 'cálcio', 'calcio', 'calcium', 'branco'] },
                { emoji: '🍞', keywords: ['pão', 'pao', 'bread', 'carboidrato', 'carb', 'energia', 'energy', 'café', 'cafe'] },
                { emoji: '🥚', keywords: ['ovo', 'egg', 'proteína', 'proteina', 'protein', 'café', 'cafe', 'manhã', 'manha'] },
                
                // Sono e Descanso
                { emoji: '😴', keywords: ['dormir', 'sleep', 'sono', 'sleepy', 'cama', 'bed', 'descanso', 'rest'] },
                { emoji: '🛌', keywords: ['cama', 'bed', 'dormir', 'sleep', 'sono', 'descanso', 'rest', 'repouso'] },
                { emoji: '💤', keywords: ['sono', 'sleep', 'zzz', 'dormir', 'sleepy', 'descanso', 'rest', 'repouso'] },
                { emoji: '🌙', keywords: ['lua', 'moon', 'noite', 'night', 'sono', 'sleep', 'escuro', 'dark'] },
                { emoji: '🌃', keywords: ['noite', 'night', 'cidade', 'city', 'sono', 'sleep', 'escuro', 'dark'] },
                { emoji: '⏰', keywords: ['despertador', 'alarm', 'hora', 'time', 'acordar', 'wake', 'manhã', 'manha'] },
                
                // Trabalho e Produtividade
                { emoji: '💼', keywords: ['trabalho', 'work', 'escritório', 'escritorio', 'office', 'negócio', 'negocio', 'business'] },
                { emoji: '💻', keywords: ['computador', 'computer', 'laptop', 'trabalho', 'work', 'tecnologia', 'technology'] },
                { emoji: '📊', keywords: ['gráfico', 'grafico', 'chart', 'dados', 'data', 'estatística', 'estatistica', 'analise'] },
                { emoji: '📈', keywords: ['crescimento', 'growth', 'subir', 'up', 'sucesso', 'success', 'progresso', 'progress'] },
                { emoji: '📋', keywords: ['lista', 'list', 'checklist', 'tarefas', 'tasks', 'organizar', 'organize'] },
                { emoji: '✏️', keywords: ['escrever', 'write', 'caneta', 'pen', 'lápis', 'lapis', 'pencil', 'anotar'] },
                { emoji: '📝', keywords: ['nota', 'note', 'escrever', 'write', 'anotação', 'anotacao', 'memorando'] },
                
                // Casa e Limpeza
                { emoji: '🏠', keywords: ['casa', 'house', 'lar', 'home', 'moradia', 'residência', 'residencia'] },
                { emoji: '🏡', keywords: ['casa', 'house', 'lar', 'home', 'jardim', 'garden', 'família', 'familia'] },
                { emoji: '🧹', keywords: ['vassoura', 'broom', 'limpeza', 'cleaning', 'limpar', 'clean', 'organizar'] },
                { emoji: '🧽', keywords: ['esponja', 'sponge', 'limpeza', 'cleaning', 'limpar', 'clean', 'cozinha'] },
                { emoji: '🧺', keywords: ['cesto', 'basket', 'roupa', 'clothes', 'lavar', 'wash', 'organizar'] },
                { emoji: '✨', keywords: ['brilho', 'shine', 'limpeza', 'cleaning', 'limpo', 'clean', 'perfeito', 'perfect'] },
                { emoji: '🌟', keywords: ['estrela', 'star', 'brilho', 'shine', 'especial', 'special', 'importante'] },
                
                // Saúde e Medicina
                { emoji: '🏥', keywords: ['hospital', 'médico', 'medico', 'doctor', 'saúde', 'saude', 'health', 'cuidado'] },
                { emoji: '💊', keywords: ['remédio', 'remedio', 'medicine', 'pílula', 'pilula', 'pill', 'saúde', 'saude'] },
                { emoji: '🩺', keywords: ['estetoscópio', 'stethoscope', 'médico', 'medico', 'doctor', 'exame', 'checkup'] },
                { emoji: '🩹', keywords: ['band-aid', 'curativo', 'bandage', 'ferida', 'wound', 'cuidado', 'care'] },
                { emoji: '🦷', keywords: ['dente', 'tooth', 'dentista', 'dentist', 'saúde', 'saude', 'health', 'boca'] },
                
                // Dinheiro e Finanças
                { emoji: '💰', keywords: ['dinheiro', 'money', 'carteira', 'wallet', 'poupança', 'poupanca', 'savings'] },
                { emoji: '💳', keywords: ['cartão', 'cartao', 'card', 'crédito', 'credito', 'credit', 'pagamento'] },
                { emoji: '💸', keywords: ['gastar', 'spend', 'dinheiro', 'money', 'comprar', 'buy', 'shopping'] },
                { emoji: '🏦', keywords: ['banco', 'bank', 'dinheiro', 'money', 'poupança', 'poupanca', 'savings'] },
                
                // Tecnologia
                { emoji: '📱', keywords: ['celular', 'phone', 'smartphone', 'tecnologia', 'technology', 'comunicação'] },
                { emoji: '⌨️', keywords: ['teclado', 'keyboard', 'digitar', 'type', 'computador', 'computer'] },
                { emoji: '🖥️', keywords: ['computador', 'computer', 'monitor', 'tela', 'screen', 'trabalho', 'work'] },
                { emoji: '📷', keywords: ['câmera', 'camera', 'foto', 'photo', 'fotografia', 'photography', 'imagem'] },
                { emoji: '🎮', keywords: ['jogo', 'game', 'videogame', 'diversão', 'diversao', 'fun', 'entretenimento'] },
                
                // Natureza e Meio Ambiente
                { emoji: '🌱', keywords: ['planta', 'plant', 'crescimento', 'growth', 'natureza', 'nature', 'verde', 'green'] },
                { emoji: '🌿', keywords: ['folha', 'leaf', 'planta', 'plant', 'natureza', 'nature', 'verde', 'green'] },
                { emoji: '🌳', keywords: ['árvore', 'arvore', 'tree', 'natureza', 'nature', 'verde', 'green', 'grande'] },
                { emoji: '🌸', keywords: ['flor', 'flower', 'rosa', 'pink', 'beleza', 'beauty', 'natureza', 'nature'] },
                { emoji: '🌺', keywords: ['flor', 'flower', 'tropical', 'natureza', 'nature', 'beleza', 'beauty'] },
                { emoji: '🌻', keywords: ['girassol', 'sunflower', 'amarelo', 'yellow', 'sol', 'sun', 'natureza'] },
                { emoji: '🌷', keywords: ['tulipa', 'tulip', 'flor', 'flower', 'primavera', 'spring', 'natureza'] },
                { emoji: '🌹', keywords: ['rosa', 'rose', 'flor', 'flower', 'amor', 'love', 'romance', 'vermelho'] },
                
                // Viagem e Transporte
                { emoji: '✈️', keywords: ['avião', 'aviao', 'airplane', 'viagem', 'travel', 'voo', 'flight', 'céu'] },
                { emoji: '🚗', keywords: ['carro', 'car', 'automóvel', 'automovel', 'dirigir', 'drive', 'viagem', 'travel'] },
                { emoji: '🚌', keywords: ['ônibus', 'onibus', 'bus', 'transporte', 'transport', 'público', 'publico'] },
                { emoji: '🚂', keywords: ['trem', 'train', 'ferrovia', 'railway', 'viagem', 'travel', 'locomotiva'] },
                { emoji: '🚢', keywords: ['navio', 'ship', 'barco', 'boat', 'mar', 'sea', 'oceano', 'ocean', 'viagem'] },
                { emoji: '🏖️', keywords: ['praia', 'beach', 'mar', 'sea', 'areia', 'sand', 'férias', 'ferias', 'verão'] },
                { emoji: '🏔️', keywords: ['montanha', 'mountain', 'pico', 'peak', 'altura', 'height', 'natureza', 'nature'] },
                { emoji: '🗺️', keywords: ['mapa', 'map', 'navegação', 'navegacao', 'direção', 'direcao', 'caminho', 'path'] },
                
                // Música e Arte
                { emoji: '🎵', keywords: ['música', 'musica', 'music', 'nota', 'note', 'som', 'sound', 'melodia'] },
                { emoji: '🎶', keywords: ['música', 'musica', 'music', 'notas', 'notes', 'melodia', 'melody', 'ritmo'] },
                { emoji: '🎸', keywords: ['guitarra', 'guitar', 'música', 'musica', 'music', 'instrumento', 'instrument'] },
                { emoji: '🎹', keywords: ['piano', 'teclado', 'keyboard', 'música', 'musica', 'music', 'instrumento'] },
                { emoji: '🎺', keywords: ['trompete', 'trumpet', 'música', 'musica', 'music', 'instrumento', 'brass'] },
                { emoji: '🎻', keywords: ['violino', 'violin', 'música', 'musica', 'music', 'instrumento', 'classical'] },
                { emoji: '🥁', keywords: ['bateria', 'drums', 'música', 'musica', 'music', 'ritmo', 'rhythm', 'percussão'] },
                { emoji: '🎤', keywords: ['microfone', 'microphone', 'cantar', 'sing', 'música', 'musica', 'music', 'vocal'] },
                { emoji: '🎨', keywords: ['arte', 'art', 'pintura', 'painting', 'desenho', 'drawing', 'criativo', 'creative'] },
                { emoji: '🖌️', keywords: ['pincel', 'brush', 'pintura', 'painting', 'arte', 'art', 'desenho', 'drawing'] },
                { emoji: '✏️', keywords: ['lápis', 'lapis', 'pencil', 'desenho', 'drawing', 'escrever', 'write', 'arte'] },
                
                // Família e Relacionamentos
                { emoji: '👨‍👩‍👧‍👦', keywords: ['família', 'familia', 'family', 'pais', 'parents', 'filhos', 'children', 'casa'] },
                { emoji: '👪', keywords: ['família', 'familia', 'family', 'pais', 'parents', 'filhos', 'children', 'casa'] },
                { emoji: '👶', keywords: ['bebê', 'bebe', 'baby', 'criança', 'crianca', 'child', 'pequeno', 'small'] },
                { emoji: '👧', keywords: ['menina', 'girl', 'criança', 'crianca', 'child', 'filha', 'daughter'] },
                { emoji: '👦', keywords: ['menino', 'boy', 'criança', 'crianca', 'child', 'filho', 'son'] },
                { emoji: '👥', keywords: ['pessoas', 'people', 'grupo', 'group', 'amigos', 'friends', 'social'] },
                { emoji: '👫', keywords: ['casal', 'couple', 'amor', 'love', 'relacionamento', 'relationship', 'romance'] },
                { emoji: '🤝', keywords: ['aperto', 'handshake', 'acordo', 'deal', 'amizade', 'friendship', 'parceria'] },
                { emoji: '👋', keywords: ['tchau', 'bye', 'olá', 'ola', 'hello', 'cumprimento', 'greeting', 'mão'] },
                { emoji: '🤗', keywords: ['abraço', 'hug', 'carinho', 'affection', 'amor', 'love', 'conforto', 'comfort'] },
                { emoji: '👏', keywords: ['palmas', 'clap', 'aplaudir', 'applaud', 'parabéns', 'parabens', 'congratulations'] },
                
                // Outros
                { emoji: '🔥', keywords: ['fogo', 'fire', 'quente', 'hot', 'energia', 'energy', 'paixão', 'passion'] },
                { emoji: '⭐', keywords: ['estrela', 'star', 'favorito', 'favorite', 'especial', 'special', 'importante'] },
                { emoji: '💎', keywords: ['diamante', 'diamond', 'precioso', 'precious', 'valioso', 'valuable', 'luxo'] },
                { emoji: '🎯', keywords: ['alvo', 'target', 'objetivo', 'goal', 'meta', 'foco', 'focus', 'precisão'] },
                { emoji: '🚫', keywords: ['proibido', 'forbidden', 'não', 'no', 'negativo', 'negative', 'evitar', 'avoid'] },
                { emoji: '💫', keywords: ['estrela', 'star', 'mágica', 'magic', 'especial', 'special', 'brilho', 'shine'] }
            ];
            
            // Função para criar botão de emoji
            function createEmojiButton(emoji) {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'emoji-btn w-12 h-12 text-2xl rounded-lg border-2 border-gray-200 hover:border-purple-500 hover:bg-purple-50 transition-all duration-200 hover:scale-110';
                button.dataset.emoji = emoji;
                button.textContent = emoji;
                
                button.addEventListener('click', function() {
                    selectEmoji(this);
                });
                
                return button;
            }
            
            // Função para selecionar emoji
            function selectEmoji(button) {
                // Remove seleção anterior
                document.querySelectorAll('.emoji-btn').forEach(btn => {
                    btn.classList.remove('border-purple-500', 'bg-purple-50', 'ring-2', 'ring-purple-200');
                    btn.classList.add('border-gray-200');
                });
                
                // Adiciona seleção atual
                button.classList.remove('border-gray-200');
                button.classList.add('border-purple-500', 'bg-purple-50', 'ring-2', 'ring-purple-200');
                
                // Atualiza input hidden
                emojiInput.value = button.dataset.emoji;
            }
            
            // Função de busca SUPER EFICIENTE
            function searchEmojis(query) {
                const searchTerm = query.toLowerCase().trim();
                
                if (searchTerm.length < 1) {
                    // Mostra emojis populares quando não há busca
                    showPopularEmojis();
                    return;
                }
                
                const results = [];
                
                // Busca super rápida e inteligente
                emojiDatabase.forEach(item => {
                    let score = 0;
                    
                    // Busca exata (maior prioridade)
                    item.keywords.forEach(keyword => {
                        if (keyword === searchTerm) {
                            score += 100;
                        }
                        // Busca por início da palavra
                        else if (keyword.startsWith(searchTerm)) {
                            score += 80;
                        }
                        // Busca por qualquer parte da palavra
                        else if (keyword.includes(searchTerm)) {
                            score += 60;
                        }
                        // Busca por acentos removidos
                        else if (keyword.normalize('NFD').replace(/[\u0300-\u036f]/g, '').includes(searchTerm.normalize('NFD').replace(/[\u0300-\u036f]/g, ''))) {
                            score += 40;
                        }
                    });
                    
                    if (score > 0) {
                        results.push({ emoji: item.emoji, score: score });
                    }
                });
                
                // Ordena por relevância
                results.sort((a, b) => b.score - a.score);
                
                // Limpa resultados anteriores
                emojiResults.innerHTML = '';
                
                // Adiciona emojis encontrados (máximo 32)
                results.slice(0, 32).forEach(item => {
                    const button = createEmojiButton(item.emoji);
                    emojiResults.appendChild(button);
                });
                
                // Se não encontrou nada, mostra mensagem
                if (results.length === 0) {
                    emojiResults.innerHTML = '<div class="col-span-8 text-center text-gray-500 py-8">Nenhum emoji encontrado. Tente outra palavra.</div>';
                }
            }
            
            // Mostra emojis populares
            function showPopularEmojis() {
                const popularEmojis = ['🎯', '💧', '🏃', '📚', '🍎', '😴', '🧘', '💪', '🚫', '☕', '🎵', '🌱', '🔥', '⭐', '💎', '🎨', '💊', '🏥', '💰', '📱', '🏠', '✈️', '🎸', '👨‍👩‍👧‍👦', '🤝', '💫', '🌺', '🎾', '🧹', '📊', '🎤', '🦷'];
                
                emojiResults.innerHTML = '';
                popularEmojis.forEach(emoji => {
                    const button = createEmojiButton(emoji);
                    emojiResults.appendChild(button);
                });
            }
            
            // Event listener para busca em tempo real
            searchInput.addEventListener('input', function() {
                searchEmojis(this.value);
            });
            
            // Inicializa com emojis populares
            showPopularEmojis();
            
            // Seleciona emoji atual do hábito
            if (emojiInput.value) {
                // Procura e seleciona o emoji atual
                setTimeout(() => {
                    const currentEmoji = emojiInput.value;
                    const emojiButton = document.querySelector(`[data-emoji="${currentEmoji}"]`);
                    if (emojiButton) {
                        selectEmoji(emojiButton);
                    }
                }, 100);
            }

            // Atualiza step do input baseado na unidade
            const unidadeSelect = document.querySelector('select[name="unidade"]');
            const metaInput = document.querySelector('input[name="meta"]');
            
            function updateStep() {
                const unidade = unidadeSelect.value;
                const unidadesInteiras = ['vezes', 'unidades', 'porções', 'páginas', 'repetições', 'passos', 'copos'];
                
                if (unidadesInteiras.includes(unidade)) {
                    metaInput.step = '1';
                    // Limpa decimais desnecessários para unidades inteiras
                    const valorAtual = parseFloat(metaInput.value);
                    if (!isNaN(valorAtual)) {
                        metaInput.value = Math.round(valorAtual).toString();
                    }
                } else {
                    metaInput.step = '0.1';
                }
            }
            
            unidadeSelect.addEventListener('change', updateStep);
            updateStep(); // Executa na inicialização
        });
    </script>
</x-app-layout>

