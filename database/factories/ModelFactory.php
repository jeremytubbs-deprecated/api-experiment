<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

// $factory->define(App\User::class, function (Faker\Generator $faker) {
//     return [
//         'name' => $faker->name,
//         'email' => $faker->email,
//         'password' => bcrypt(str_random(10)),
//         'remember_token' => str_random(10),
//     ];
// });
//

$factory->define(App\Models\Content::class, function ($faker) {
    $title = $faker->catchPhrase;
    return [
    	'user_id' => $faker->numberBetween(1,2),
    	'type_id' => $faker->numberBetween(1,6),
    	'category_id' => $faker->numberBetween(1,3),
        'title' => $title,
        'slug' => $title,
    ];
});
