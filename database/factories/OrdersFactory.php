<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    $providerIds = App\User::all()->where('is_provider',1)->pluck('id')->toArray();
    $customerIds = App\User::all()->where('is_provider',0)->pluck('id')->toArray();
    $tiffinsIds = App\Tiffin::all()->pluck('id')->toArray();
    
    return [
        'customer_id' => $faker->randomElement($customerIds),
        'provider_id' => $faker->randomElement($providerIds),
        'tiffin_id' => $faker->randomElement($tiffinsIds),
        'no_of_tiffin' => 1,
        'is_lunch' => 1,
        'price' => $faker->randomDigit($min = 50, $max = 100),
        'total_amount' => $faker->randomDigit($min = 50, $max = 100)
    ];
});