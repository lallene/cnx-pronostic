<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WorldCup2026MatchSeeder extends Seeder
{
    public function run()
    {
        DB::table('matches')->truncate();

        $matches = [
            ['Mexique', 'Afrique du Sud', 'mx', 'za', '2026-06-11 19:00:00', 'Groupe A', 'Journée 1'],
            ['Corée du Sud', 'Tchéquie', 'kr', 'cz', '2026-06-12 02:00:00', 'Groupe A', 'Journée 1'],

            ['Canada', 'Bosnie-Herzégovine', 'ca', 'ba', '2026-06-12 19:00:00', 'Groupe B', 'Journée 1'],
            ['États-Unis', 'Paraguay', 'us', 'py', '2026-06-13 01:00:00', 'Groupe D', 'Journée 1'],

            ['Qatar', 'Suisse', 'qa', 'ch', '2026-06-13 19:00:00', 'Groupe B', 'Journée 1'],
            ['Brésil', 'Maroc', 'br', 'ma', '2026-06-13 22:00:00', 'Groupe C', 'Journée 1'],
            ['Haïti', 'Écosse', 'ht', 'gb-sct', '2026-06-14 01:00:00', 'Groupe C', 'Journée 1'],
            ['Australie', 'Turquie', 'au', 'tr', '2026-06-14 04:00:00', 'Groupe D', 'Journée 1'],

            ['Allemagne', 'Curaçao', 'de', 'cw', '2026-06-14 17:00:00', 'Groupe E', 'Journée 1'],
            ['Pays-Bas', 'Japon', 'nl', 'jp', '2026-06-14 20:00:00', 'Groupe F', 'Journée 1'],
            ['Côte d’Ivoire', 'Équateur', 'ci', 'ec', '2026-06-14 23:00:00', 'Groupe E', 'Journée 1'],
            ['Suède', 'Tunisie', 'se', 'tn', '2026-06-15 02:00:00', 'Groupe F', 'Journée 1'],

            ['Espagne', 'Cap-Vert', 'es', 'cv', '2026-06-15 16:00:00', 'Groupe H', 'Journée 1'],
            ['Belgique', 'Égypte', 'be', 'eg', '2026-06-15 19:00:00', 'Groupe G', 'Journée 1'],
            ['Arabie Saoudite', 'Uruguay', 'sa', 'uy', '2026-06-15 22:00:00', 'Groupe H', 'Journée 1'],
            ['Iran', 'Nouvelle-Zélande', 'ir', 'nz', '2026-06-16 01:00:00', 'Groupe G', 'Journée 1'],

            ['France', 'Sénégal', 'fr', 'sn', '2026-06-16 19:00:00', 'Groupe I', 'Journée 1'],
            ['Irak', 'Norvège', 'iq', 'no', '2026-06-16 22:00:00', 'Groupe I', 'Journée 1'],
            ['Argentine', 'Algérie', 'ar', 'dz', '2026-06-17 01:00:00', 'Groupe J', 'Journée 1'],
            ['Autriche', 'Jordanie', 'at', 'jo', '2026-06-17 04:00:00', 'Groupe J', 'Journée 1'],

            ['Portugal', 'RD Congo', 'pt', 'cd', '2026-06-17 17:00:00', 'Groupe K', 'Journée 1'],
            ['Angleterre', 'Croatie', 'gb-eng', 'hr', '2026-06-17 20:00:00', 'Groupe L', 'Journée 1'],
            ['Ghana', 'Panama', 'gh', 'pa', '2026-06-17 23:00:00', 'Groupe L', 'Journée 1'],
            ['Ouzbékistan', 'Colombie', 'uz', 'co', '2026-06-18 02:00:00', 'Groupe K', 'Journée 1'],

            ['Tchéquie', 'Afrique du Sud', 'cz', 'za', '2026-06-18 16:00:00', 'Groupe A', 'Journée 2'],
            ['Suisse', 'Bosnie-Herzégovine', 'ch', 'ba', '2026-06-18 19:00:00', 'Groupe B', 'Journée 2'],
            ['Canada', 'Qatar', 'ca', 'qa', '2026-06-18 22:00:00', 'Groupe B', 'Journée 2'],
            ['Mexique', 'Corée du Sud', 'mx', 'kr', '2026-06-19 01:00:00', 'Groupe A', 'Journée 2'],

            ['Turquie', 'Paraguay', 'tr', 'py', '2026-06-19 04:00:00', 'Groupe D', 'Journée 2'],
            ['États-Unis', 'Australie', 'us', 'au', '2026-06-19 19:00:00', 'Groupe D', 'Journée 2'],
            ['Écosse', 'Maroc', 'gb-sct', 'ma', '2026-06-19 22:00:00', 'Groupe C', 'Journée 2'],
            ['Brésil', 'Haïti', 'br', 'ht', '2026-06-20 00:30:00', 'Groupe C', 'Journée 2'],

            ['Pays-Bas', 'Suède', 'nl', 'se', '2026-06-20 17:00:00', 'Groupe F', 'Journée 2'],
            ['Allemagne', 'Côte d’Ivoire', 'de', 'ci', '2026-06-20 20:00:00', 'Groupe E', 'Journée 2'],
            ['Équateur', 'Curaçao', 'ec', 'cw', '2026-06-21 00:00:00', 'Groupe E', 'Journée 2'],
            ['Tunisie', 'Japon', 'tn', 'jp', '2026-06-21 04:00:00', 'Groupe F', 'Journée 2'],

            ['Espagne', 'Arabie Saoudite', 'es', 'sa', '2026-06-21 16:00:00', 'Groupe H', 'Journée 2'],
            ['Belgique', 'Iran', 'be', 'ir', '2026-06-21 19:00:00', 'Groupe G', 'Journée 2'],
            ['Uruguay', 'Cap-Vert', 'uy', 'cv', '2026-06-21 22:00:00', 'Groupe H', 'Journée 2'],
            ['Nouvelle-Zélande', 'Égypte', 'nz', 'eg', '2026-06-22 01:00:00', 'Groupe G', 'Journée 2'],

            ['Argentine', 'Autriche', 'ar', 'at', '2026-06-22 17:00:00', 'Groupe J', 'Journée 2'],
            ['France', 'Irak', 'fr', 'iq', '2026-06-22 21:00:00', 'Groupe I', 'Journée 2'],
            ['Norvège', 'Sénégal', 'no', 'sn', '2026-06-23 00:00:00', 'Groupe I', 'Journée 2'],
            ['Jordanie', 'Algérie', 'jo', 'dz', '2026-06-23 03:00:00', 'Groupe J', 'Journée 2'],

            ['Portugal', 'Ouzbékistan', 'pt', 'uz', '2026-06-23 17:00:00', 'Groupe K', 'Journée 2'],
            ['Angleterre', 'Ghana', 'gb-eng', 'gh', '2026-06-23 20:00:00', 'Groupe L', 'Journée 2'],
            ['Panama', 'Croatie', 'pa', 'hr', '2026-06-23 23:00:00', 'Groupe L', 'Journée 2'],
            ['Colombie', 'RD Congo', 'co', 'cd', '2026-06-24 02:00:00', 'Groupe K', 'Journée 2'],

            ['Suisse', 'Canada', 'ch', 'ca', '2026-06-24 19:00:00', 'Groupe B', 'Journée 3'],
            ['Bosnie-Herzégovine', 'Qatar', 'ba', 'qa', '2026-06-24 19:00:00', 'Groupe B', 'Journée 3'],
            ['Écosse', 'Brésil', 'gb-sct', 'br', '2026-06-24 22:00:00', 'Groupe C', 'Journée 3'],
            ['Maroc', 'Haïti', 'ma', 'ht', '2026-06-24 22:00:00', 'Groupe C', 'Journée 3'],
            ['Tchéquie', 'Mexique', 'cz', 'mx', '2026-06-25 01:00:00', 'Groupe A', 'Journée 3'],
            ['Afrique du Sud', 'Corée du Sud', 'za', 'kr', '2026-06-25 01:00:00', 'Groupe A', 'Journée 3'],

            ['Curaçao', 'Côte d’Ivoire', 'cw', 'ci', '2026-06-25 20:00:00', 'Groupe E', 'Journée 3'],
            ['Équateur', 'Allemagne', 'ec', 'de', '2026-06-25 20:00:00', 'Groupe E', 'Journée 3'],
            ['Japon', 'Suède', 'jp', 'se', '2026-06-25 23:00:00', 'Groupe F', 'Journée 3'],
            ['Tunisie', 'Pays-Bas', 'tn', 'nl', '2026-06-25 23:00:00', 'Groupe F', 'Journée 3'],
            ['Turquie', 'États-Unis', 'tr', 'us', '2026-06-26 02:00:00', 'Groupe D', 'Journée 3'],
            ['Paraguay', 'Australie', 'py', 'au', '2026-06-26 02:00:00', 'Groupe D', 'Journée 3'],

            ['Norvège', 'France', 'no', 'fr', '2026-06-26 19:00:00', 'Groupe I', 'Journée 3'],
            ['Sénégal', 'Irak', 'sn', 'iq', '2026-06-26 19:00:00', 'Groupe I', 'Journée 3'],
            ['Cap-Vert', 'Arabie Saoudite', 'cv', 'sa', '2026-06-27 00:00:00', 'Groupe H', 'Journée 3'],
            ['Uruguay', 'Espagne', 'uy', 'es', '2026-06-27 00:00:00', 'Groupe H', 'Journée 3'],
            ['Égypte', 'Iran', 'eg', 'ir', '2026-06-27 03:00:00', 'Groupe G', 'Journée 3'],
            ['Nouvelle-Zélande', 'Belgique', 'nz', 'be', '2026-06-27 03:00:00', 'Groupe G', 'Journée 3'],

            ['Panama', 'Angleterre', 'pa', 'gb-eng', '2026-06-27 21:00:00', 'Groupe L', 'Journée 3'],
            ['Croatie', 'Ghana', 'hr', 'gh', '2026-06-27 21:00:00', 'Groupe L', 'Journée 3'],
            ['Colombie', 'Portugal', 'co', 'pt', '2026-06-27 23:30:00', 'Groupe K', 'Journée 3'],
            ['RD Congo', 'Ouzbékistan', 'cd', 'uz', '2026-06-27 23:30:00', 'Groupe K', 'Journée 3'],
            ['Algérie', 'Autriche', 'dz', 'at', '2026-06-28 02:00:00', 'Groupe J', 'Journée 3'],
            ['Jordanie', 'Argentine', 'jo', 'ar', '2026-06-28 02:00:00', 'Groupe J', 'Journée 3'],
        ];

        $data = [];

        foreach ($matches as $match) {
            $data[] = [
                'home_team' => $match[0],
                'away_team' => $match[1],
                'home_team_avatar' => "https://flagcdn.com/w80/{$match[2]}.webp",
                'away_team_avatar' => "https://flagcdn.com/w80/{$match[3]}.webp",
                'match_date' => Carbon::createFromFormat('Y-m-d H:i:s', $match[4], 'UTC'),
                'competition' => 'Coupe du Monde 2026',
                'phase' => 'Phase de groupes',
                'journee' => $match[6],
                'groupe' => $match[5],
                'coefficient' => $this->getCoefficient($match[0], $match[1]),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('matches')->insert($data);
    }

    private function getCoefficient(string $home, string $away): int
{
    $topTeams = [
        'France',
        'Espagne',
        'Argentine',
        'Angleterre',
        'Portugal',
        'Brésil',
        'Pays-Bas',
        'Maroc',
        'Belgique',
        'Allemagne',
    ];

    $strongTeams = [
        'Uruguay',
        'Croatie',
        'Sénégal',
        'Japon',
        'Colombie',
        'Suisse',
        'Norvège',
        'États-Unis',
        'Mexique',
        'Turquie',
        'Côte d’Ivoire',
        'Algérie',
        'Suisse',
        'Equateur',
        'Turquie',
    ];

    if (in_array($home, $topTeams) && in_array($away, $topTeams)) {
        return 3;
    }

    if (in_array($home, $topTeams) || in_array($away, $topTeams)) {
        return 2;
    }

    if (in_array($home, $strongTeams) || in_array($away, $strongTeams)) {
        return 2;
    }

    return 1;
}
}
