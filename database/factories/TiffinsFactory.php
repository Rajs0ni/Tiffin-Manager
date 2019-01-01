<?php

use Faker\Generator as Faker;

$factory->define(App\Tiffin::class, function (Faker $faker) {
    $providerIds = App\User::all()->where('is_provider',1)->pluck('id')->toArray();
    return [
        'provider_id' => $faker->randomElement($providerIds),
        'name' => $faker->name,
        'detail' => $faker->paragraph(3),
        'price' => $faker->randomDigit($min = 50, $max = 100)
    ];
});
