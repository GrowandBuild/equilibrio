<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Emblema;

class EmblemasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emblemas = [
            // Emblemas de Sequência
            [
                'nome' => '3 Dias de Fogo',
                'slug' => 'sequencia-3-dias',
                'descricao' => 'Mantenha uma sequência de 3 dias consecutivos',
                'icone' => '🥉',
                'tipo' => 'sequencia',
                'condicao' => ['dias' => 3],
            ],
            [
                'nome' => 'Semana Completa',
                'slug' => 'sequencia-7-dias',
                'descricao' => 'Mantenha uma sequência de 7 dias consecutivos',
                'icone' => '🥈',
                'tipo' => 'sequencia',
                'condicao' => ['dias' => 7],
            ],
            [
                'nome' => 'Duas Semanas Fortes',
                'slug' => 'sequencia-14-dias',
                'descricao' => 'Mantenha uma sequência de 14 dias consecutivos',
                'icone' => '🥇',
                'tipo' => 'sequencia',
                'condicao' => ['dias' => 14],
            ],
            [
                'nome' => 'Mês Perfeito',
                'slug' => 'sequencia-30-dias',
                'descricao' => 'Mantenha uma sequência de 30 dias consecutivos',
                'icone' => '👑',
                'tipo' => 'sequencia',
                'condicao' => ['dias' => 30],
            ],
            
            // Emblemas de Marcos
            [
                'nome' => 'Primeiro Passo',
                'slug' => 'primeiro-habito',
                'descricao' => 'Crie seu primeiro hábito',
                'icone' => '🎯',
                'tipo' => 'marco',
                'condicao' => ['tipo' => 'primeiro_habito'],
            ],
            [
                'nome' => 'Começando a Jornada',
                'slug' => 'primeiro-registro',
                'descricao' => 'Faça seu primeiro registro do dia',
                'icone' => '🌱',
                'tipo' => 'marco',
                'condicao' => ['tipo' => 'primeiro_registro'],
            ],
            [
                'nome' => 'Dedicado',
                'slug' => 'sete-registros',
                'descricao' => 'Complete 7 dias de registros (não precisa ser consecutivo)',
                'icone' => '💪',
                'tipo' => 'marco',
                'condicao' => ['tipo' => 'total_registros', 'quantidade' => 7],
            ],
            [
                'nome' => 'Semana Perfeita',
                'slug' => 'semana-perfeita',
                'descricao' => 'Cumpra todas as metas em uma semana',
                'icone' => '🎊',
                'tipo' => 'especial',
                'condicao' => ['tipo' => 'semana_perfeita'],
            ],
            [
                'nome' => 'Equilibrado',
                'slug' => 'trinta-registros',
                'descricao' => 'Complete 30 registros',
                'icone' => '🏆',
                'tipo' => 'marco',
                'condicao' => ['tipo' => 'total_registros', 'quantidade' => 30],
            ],
            
            // Emblemas de XP
            [
                'nome' => 'Iniciante Determinado',
                'slug' => 'nivel-constante',
                'descricao' => 'Alcance o nível Constante',
                'icone' => '⭐',
                'tipo' => 'xp',
                'condicao' => ['nivel' => 'Constante'],
            ],
            [
                'nome' => 'Guerreiro da Disciplina',
                'slug' => 'nivel-disciplinado',
                'descricao' => 'Alcance o nível Disciplinado',
                'icone' => '💎',
                'tipo' => 'xp',
                'condicao' => ['nivel' => 'Disciplinado'],
            ],
            [
                'nome' => 'Mestre Supremo',
                'slug' => 'nivel-mestre',
                'descricao' => 'Alcance o nível Mestre do Equilíbrio',
                'icone' => '👑',
                'tipo' => 'xp',
                'condicao' => ['nivel' => 'Mestre do Equilíbrio'],
            ],
        ];

        foreach ($emblemas as $emblema) {
            Emblema::create($emblema);
        }
    }
}

