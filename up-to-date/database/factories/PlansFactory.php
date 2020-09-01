<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Plans;
use Faker\Generator as Faker;

$factory->define(Plans::class, function (Faker $faker) {
    return [
        //
        'user_id'=>factory(\App\User::class),
        'title'=>$faker->sentence,
        'due_date'=>$faker->dateTimeThisMonth(),
        'end_date'=>$faker->dateTime(),


    ];
});
