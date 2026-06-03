<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Badge;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            // --- Victoires ---
            ['name' => 'Premier tir cadré', 'icon' => '🎯', 'condition_key' => 'first_win',     'description' => 'Obtenir son premier bon pronostic.',                          'category' => 'win'],
            ['name' => '5 victoires',        'icon' => '🔥', 'condition_key' => 'five_wins',     'description' => 'Réussir 5 bons pronostics.',                                 'category' => 'win'],
            ['name' => '10 victoires',       'icon' => '⚽', 'condition_key' => 'ten_wins',      'description' => 'Atteindre 10 pronostics corrects.',                          'category' => 'win'],
            ['name' => '20 victoires',       'icon' => '👑', 'condition_key' => 'twenty_wins',   'description' => 'Dominer le tournoi avec 20 bons résultats.',                 'category' => 'win'],

            // --- Séries positives ---
            ['name' => 'Série chaude x3',   'icon' => '🔥', 'condition_key' => 'streak_3',      'description' => 'Réussir 3 pronostics corrects consécutifs.',                 'category' => 'streak'],
            ['name' => 'Série en feu x5',   'icon' => '🚀', 'condition_key' => 'streak_5',      'description' => 'Atteindre une série de 5 victoires d\'affilée.',             'category' => 'streak'],
            ['name' => 'Invincible x10',     'icon' => '🐐', 'condition_key' => 'streak_10',     'description' => 'Réaliser une série incroyable de 10 bons pronostics.',       'category' => 'streak'],

            // --- Séries noires ---
            ['name' => 'Chat noir x3',       'icon' => '🐈‍⬛', 'condition_key' => 'cold_3',    'description' => 'Perdre 3 pronostics consécutifs.',                           'category' => 'cold'],
            ['name' => 'VAR contre moi',     'icon' => '🥶', 'condition_key' => 'cold_5',        'description' => 'Subir une série noire de 5 mauvais pronostics.',             'category' => 'cold'],

            // --- XP & niveaux ---
            ['name' => 'Rookie',             'icon' => '⭐', 'condition_key' => 'rookie',        'description' => 'Atteindre 50 XP.',                                          'category' => 'xp', 'threshold' => 50],
            ['name' => 'Expert VAR',         'icon' => '🧠', 'condition_key' => 'expert',        'description' => 'Accumuler 250 XP grâce à ses performances.',                'category' => 'xp', 'threshold' => 250],
            ['name' => 'Légende CNX',        'icon' => '🏆', 'condition_key' => 'legend',        'description' => 'Entrer dans la légende avec 500 XP.',                       'category' => 'xp', 'threshold' => 500],

            // --- Participation ---
            ['name' => 'Toujours présent',   'icon' => '📅', 'condition_key' => 'participation_10', 'description' => 'Participer à 10 matchs de pronostics.',                 'category' => 'participation', 'threshold' => 10],
            ['name' => 'Marathonien',        'icon' => '🏃', 'condition_key' => 'participation_50', 'description' => 'Participer à 50 matchs — présence constante.',           'category' => 'participation', 'threshold' => 50],

            // --- MVP ---
            ['name' => 'MVP service',        'icon' => '🏢', 'condition_key' => 'service_mvp',   'description' => 'Être le meilleur joueur de son service.',                   'category' => 'mvp'],
        ];

        foreach ($badges as $badge) {
            Badge::updateOrCreate(
                ['condition_key' => $badge['condition_key']],
                $badge
            );
        }
    }
}