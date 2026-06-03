<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Matche;
use App\Models\Prediction;

class PredictionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::orderBy('id')->take(500)->get();

        $matches = Matche::whereDoesntHave('resultats')->orderBy('id')->take(72)->get();

        if ($users->isEmpty() || $matches->isEmpty()) {
            $this->command->error('Aucun utilisateur ou match trouvé.');
            return;
        }

        $this->command->info('Création des pronostics...');

        foreach ($users as $user) {
            foreach ($matches as $match) {
                $predictions = [$match->home_team, 'Null', $match->away_team];

                Prediction::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'match_id' => $match->id,
                    ],
                    [
                        'prediction' => $predictions[array_rand($predictions)],
                        'gamification_processed' => false,
                    ],
                );
            }
        }

        $this->command->info('Pronostics générés avec succès.');
    }
}
