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
        Column::create(['title' => 'To Do', 'order' => 0]);
        Column::create(['title' => 'Doing', 'order' => 1]);
        Column::create(['title' => 'Done', 'order' => 2]);

        Card::factory(10)->create();
    }
}
