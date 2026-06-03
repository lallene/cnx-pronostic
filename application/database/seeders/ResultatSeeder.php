<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Services\GamificationService;

class ResultatSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = DB::table('admins')->value('id');

        if (!$adminId) {
            $this->command->error('Aucun admin trouvé. Exécute d’abord AdminSeeder.');
            return;
        }

        DB::table('predictions')->update([
            'gamification_processed' => false,
        ]);

        $matches = DB::table('matches')->orderBy('id')->take(72)->get();

        $this->command->info('Nombre de matchs trouvés : ' . $matches->count());

        if ($matches->isEmpty()) {
            return;
        }

        foreach ($matches as $match) {
            $results = [$match->home_team, 'Null', $match->away_team];

            DB::table('resultats')->updateOrInsert(
                ['match_id' => $match->id],
                [
                    'admin_id' => $adminId,
                    'resultat' => $results[array_rand($results)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );

            app(GamificationService::class)->processMatch((int) $match->id);
        }

        $this->command->info('Résultats en base : ' . DB::table('resultats')->count());
        $this->command->info('Badges attribués : ' . DB::table('user_badges')->count());
    }
}
