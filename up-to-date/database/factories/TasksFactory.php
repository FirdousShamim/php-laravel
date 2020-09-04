<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tasks;
use Faker\Generator as Faker;

$factory->define(Tasks::class, function (Faker $faker) {
    return [
        //

        'plan_id'=>factory(\App\Plans::class),
        'title'=>$faker->sentence,
        'due_date'=>$faker->dateTimeThisMonth(),
        'user_assigned'=>$faker->randomDigit(),
        
    ];
});
