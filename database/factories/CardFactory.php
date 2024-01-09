<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\Column;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CardFactory extends Factory
{
    protected $model = Card::class;

    public function definition() {
        $columnIds = Column::pluck('id');
        return [
            'title' => fake()->word(),
            'description' => fake()->text(50),
            'column_id' => fake()->randomElement($columnIds),
            'order' => fake()->randomNumber(),
            'created_at' =>fake()->dateTime(),
            'updated_at' => Carbon::now(),
            'deleted_at' => fake()->randomElement([now(), null])
        ];
    }
}
