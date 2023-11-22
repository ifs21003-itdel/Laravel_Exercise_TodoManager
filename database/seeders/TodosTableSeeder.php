<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Seeder;

class TodosTableSeeder extends Seeder
{
    public function run()
    {
        // Membuat 500 todo secara random
        Todo::factory()->count(500)->create();
    }
}