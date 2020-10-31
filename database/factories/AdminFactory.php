<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Admin::class, function (Faker $faker) {
    $date_time = $faker->date. ' ' . $faker->time;
    return [
        'username'  =>  $faker->name,
        'password' => '$2y$10$.4eoGRDQ0PojJ7AlQ/suKeIqL3PDC0YzcLpVv8r0rkZE/iRFkWOCO', // password
        'created_at'    =>  $date_time,
        'updated_at'    =>  $date_time,
    ];
});
