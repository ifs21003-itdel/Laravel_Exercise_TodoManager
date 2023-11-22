<?php

namespace Database\Factories;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    protected $model = Todo::class;
    
    public function definition()
    {
        // Pilih user_id secara acak (tidak termasuk user_id 1 yaitu admin)
        $user = User::where('id', '<>', 1)->inRandomOrder()->first();
        
        return [
            'user_id' => $user->id,
            'activity' => $this->faker->sentence,
            'status' => $this->faker->randomElement([0, 1]),
        ];
    }
}
