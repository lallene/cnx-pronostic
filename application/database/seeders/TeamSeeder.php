<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        // Les 48 pays qualifiés, formatés exactement comme ta liste
        $worldCupTeams = [
            // --- CONCACAF ---
            'mx' => 'Mexique',
            'ca' => 'Canada',
            'us' => 'États-Unis',
            'ht' => 'Haïti',
            'pa' => 'Panama',
            'cw' => 'Curaçao',

            // --- UEFA ---
            'cz' => 'Tchéquie',
            'ba' => 'Bosnie-Herzégovine',
            'ch' => 'Suisse',
            'gb-eng' => 'Angleterre',
            'gb-sct' => 'Écosse',
            'tr' => 'Turquie',
            'de' => 'Allemagne',
            'nl' => 'Pays-Bas',
            'se' => 'Suède',
            'es' => 'Espagne',
            'be' => 'Belgique',
            'fr' => 'France',
            'no' => 'Norvège',
            'at' => 'Autriche',
            'pt' => 'Portugal',
            'hr' => 'Croatie',

            // --- CAF ---
            'za' => 'Afrique du Sud',
            'ma' => 'Maroc',
            'ci' => 'Côte d’Ivoire',
            'cv' => 'Cap-Vert',
            'eg' => 'Égypte',
            'sn' => 'Sénégal',
            'dz' => 'Algérie',
            'cd' => 'RD Congo',
            'gh' => 'Ghana',
            'tn' => 'Tunisie',

            // --- AFC ---
            'kr' => 'Corée du Sud',
            'qa' => 'Qatar',
            'au' => 'Australie',
            'jp' => 'Japon',
            'sa' => 'Arabie saoudite',
            'ir' => 'Iran',
            'iq' => 'Irak',
            'jo' => 'Jordanie',
            'uz' => 'Ouzbékistan',

            // --- CONMEBOL ---
            'py' => 'Paraguay',
            'br' => 'Brésil',
            'ec' => 'Équateur',
            'uy' => 'Uruguay',
            'ar' => 'Argentine',
            'co' => 'Colombie',

            // --- OFC ---
            'nz' => 'Nouvelle-Zélande',
        ];

        foreach ($worldCupTeams as $code => $name) {
            Team::updateOrCreate(
                ['name' => $name],
                ['avatar' => "https://flagcdn.com/w320/{$code}.webp"]
            );
        }
    }
}