<?php

use Illuminate\Database\Seeder;
use App\Models\Authors;

class AuthorSeed extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 5; $i < 10; $i++) {
            Authors::create([
                'name' => $faker->firstNameMale,
                'avatar' => 'https://picsum.photos/50/'. rand(101, 150),
                'introduction' => $faker->sentence,
                'number' => ($i + 1)
            ]);
        }
    }
}
