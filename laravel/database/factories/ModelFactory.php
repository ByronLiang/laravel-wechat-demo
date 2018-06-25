<?php


/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Models\Catagory::class, function () {
    $faker = Faker\Factory::create('zh_CN');
    return [
        'name' => $faker->streetName,
    ];
});
