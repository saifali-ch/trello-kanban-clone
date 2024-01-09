<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Card;
use App\Models\Column;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Create dummy columns
        Column::create(['title' => 'To Do']);
        Column::create(['title' => 'Doing']);
        Column::create(['title' => 'Done']);

        Card::factory(10)->create();
    }
}
