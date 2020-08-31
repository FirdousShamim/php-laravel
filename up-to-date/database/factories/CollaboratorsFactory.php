<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Collaborators;
use Faker\Generator as Faker;

$factory->define(Collaborators::class, function (Faker $faker) {
    $user_id=App\User::pluck('id')->all();
    $plan_id=App\Plans::pluck('id')->all();
    return [
        //

        'user_id'=>factory(\App\User::class),
        'plan_id'=>factory(\App\Plans::class),
    ];
});
