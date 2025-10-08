<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Habito;
use App\Models\UsuarioXp;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria emblemas
        $this->call(EmblemasSeeder::class);

        // Cria usuário Alexandre
        $alexandre = User::create([
            'name' => 'Alexandre',
            'email' => 'alexandre@equilibrio.app',
            'password' => Hash::make('password'),
            'biografia' => 'Buscando meu equilíbrio pessoal! 💪',
        ]);

        UsuarioXp::create([
            'usuario_id' => $alexandre->id,
            'xp_total' => 0,
            'nivel_atual' => 'Iniciante',
            'sequencia_dias_atual' => 0,
        ]);

        // Cria usuária Elisa
        $elisa = User::create([
            'name' => 'Elisa',
            'email' => 'elisa@equilibrio.app',
            'password' => Hash::make('password'),
            'biografia' => 'Focada em criar hábitos saudáveis! ✨',
        ]);

        UsuarioXp::create([
            'usuario_id' => $elisa->id,
            'xp_total' => 0,
            'nivel_atual' => 'Iniciante',
            'sequencia_dias_atual' => 0,
        ]);

        // Cria usuário demo
        $usuario = User::create([
            'name' => 'Usuário Demo',
            'email' => 'demo@equilibrio.app',
            'password' => Hash::make('password'),
            'biografia' => 'Buscando equilíbrio entre hábitos bons e ruins! 🎯',
        ]);

        // Inicializa XP do usuário demo
        UsuarioXp::create([
            'usuario_id' => $usuario->id,
            'xp_total' => 0,
            'nivel_atual' => 'Iniciante',
            'sequencia_dias_atual' => 0,
        ]);

        // Cria hábitos de exemplo
        $habitos = [
            [
                'nome' => 'Beber Água',
                'tipo' => 'bom',
                'emoji' => '💧',
                'meta' => 3,
                'unidade' => 'litros',
                'descricao' => 'Manter-se hidratado é essencial para a saúde',
                'frequencia_tipo' => 'diaria',
                'ordem' => 1,
            ],
            [
                'nome' => 'Exercício Físico',
                'tipo' => 'bom',
                'emoji' => '🏃',
                'meta' => 30,
                'unidade' => 'minutos',
                'descricao' => 'Movimentar o corpo diariamente',
                'frequencia_tipo' => 'diaria',
                'ordem' => 2,
            ],
            [
                'nome' => 'Leitura',
                'tipo' => 'bom',
                'emoji' => '📚',
                'meta' => 20,
                'unidade' => 'páginas',
                'descricao' => 'Ler um pouco todos os dias',
                'frequencia_tipo' => 'diaria',
                'ordem' => 3,
            ],
            [
                'nome' => 'Meditação',
                'tipo' => 'bom',
                'emoji' => '🧘',
                'meta' => 10,
                'unidade' => 'minutos',
                'descricao' => 'Momento de paz e reflexão',
                'frequencia_tipo' => 'diaria',
                'ordem' => 4,
            ],
            [
                'nome' => 'Cigarros',
                'tipo' => 'ruim',
                'emoji' => '🚬',
                'meta' => 5,
                'unidade' => 'unidades',
                'descricao' => 'Reduzir o consumo gradualmente',
                'frequencia_tipo' => 'diaria',
                'ordem' => 5,
            ],
            [
                'nome' => 'Redes Sociais',
                'tipo' => 'ruim',
                'emoji' => '📱',
                'meta' => 60,
                'unidade' => 'minutos',
                'descricao' => 'Limitar tempo nas redes sociais',
                'frequencia_tipo' => 'diaria',
                'ordem' => 6,
            ],
        ];

        foreach ($habitos as $habito) {
            Habito::create(array_merge($habito, ['usuario_id' => $usuario->id]));
        }

        $this->command->info('✅ Banco de dados populado com sucesso!');
        $this->command->info('');
        $this->command->info('👥 Usuários criados:');
        $this->command->info('📧 Alexandre: alexandre@equilibrio.app');
        $this->command->info('📧 Elisa: elisa@equilibrio.app');
        $this->command->info('📧 Demo: demo@equilibrio.app');
        $this->command->info('🔑 Senha (todos): password');
    }
}
