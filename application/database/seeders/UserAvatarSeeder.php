<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserAvatarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $avatars = [];

        // Génère avatars/avatar1.webp → avatar21.webp
        for ($i = 1; $i <= 21; $i++) {
            $avatars[] = "avatars/avatar{$i}.webp";
        }

        $users = User::orderBy('id')->get();

        if ($users->isEmpty()) {

            $this->command->error('Aucun utilisateur trouvé.');

            return;
        }

        $this->command->info(
            'Attribution des avatars à '
            . $users->count()
            . ' utilisateurs...'
        );

        foreach ($users as $index => $user) {

            // Rotation automatique sur 21 avatars
            $avatarIndex = $index % count($avatars);

            $user->update([
                'avatar' => $avatars[$avatarIndex]
            ]);
        }

        $this->command->info('Avatars attribués avec succès.');
    }
}   