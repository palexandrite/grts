<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'email' => 'gratus@example.com',
        ]);

        $number = rand(30, 50);
        \App\Models\User::factory($number)->create();
    }
}
