<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $todo = Column::create(['title' => 'To Do', 'order' => 0]);
        $doing = Column::create(['title' => 'Doing', 'order' => 1]);
        $done = Column::create(['title' => 'Done', 'order' => 2]);

        $todoCards = [
            ['title' => 'Research market trends for upcoming project', 'order' => 0],
            ['title' => 'Create wireframes for new website layout', 'order' => 1],
            ['title' => 'Draft initial project proposal', 'order' => 2],
            ['title' => 'Conduct client meeting to gather requirements', 'order' => 3],
            ['title' => 'Review and prioritize bug reports', 'order' => 4],
            ['title' => 'Define scope and objectives for next sprint', 'order' => 5],
            ['title' => 'Brainstorm ideas for marketing campaign', 'order' => 6],
            ['title' => 'Set up development environment for new feature', 'order' => 7],
            ['title' => 'Collect user feedback on current product version', 'order' => 8]
        ];

        $doingCards = [
            ['title' => 'Developing login functionality for the app', 'order' => 0],
            ['title' => 'Testing website performance on different browsers', 'order' => 1],
            ['title' => 'Writing code documentation for recent feature', 'order' => 2],
            ['title' => 'Implementing design changes based on client feedback', 'order' => 3],
            ['title' => 'Conducting user acceptance testing (UAT)', 'order' => 4],
            ['title' => 'Collaborating with marketing team on campaign visuals', 'order' => 5],
            ['title' => 'Holding sprint planning meeting with the team', 'order' => 6],
        ];

        $doneCards = [
            ['title' => 'Completed initial draft of project proposal', 'order' => 0],
            ['title' => 'Conducted successful client meeting and finalized requirements', 'order' => 1],
            ['title' => 'Implemented login functionality for the app', 'order' => 2],
            ['title' => 'Published blog post on company website', 'order' => 3],
            ['title' => 'Resolved and closed 10 bug reports)', 'order' => 4],
        ];

        foreach ($todoCards as $card) {
            $todo->cards()->create($card);
        }
        foreach ($doingCards as $card) {
            $doing->cards()->create($card);
        }
        foreach ($doneCards as $card) {
            $done->cards()->create($card);
        }
    }
}
