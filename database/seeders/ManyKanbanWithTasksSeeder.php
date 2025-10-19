<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ManyKanbanWithTasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            [
                'first_name' => 'john',
                'last_name' => 'doe',
                'email' => 'johndoe@gmail.com',
            ],
            [
                'password' => Hash::make('password'),
            ]
        );
        $path = database_path('data/kanban.json');
        if (!File::exists($path)) {
            $this->command->error("Le fichier JSON $path est introuvable.");
            return;
        }

        $kanbans = json_decode(File::get($path), true);

        foreach ($kanbans as $kanbanData) {
            $kanban = $user->kanbans()->create([
                'title' => $kanbanData['title'],
                'description' => $kanbanData['description'],
                'color' => $kanbanData['color'],
            ]);
            $kanban->tasks()->createMany($kanbanData['tasks']);
        }

        $this->command->info('✅ Données Kanban et Tâches générées avec succès !');
    }
}
