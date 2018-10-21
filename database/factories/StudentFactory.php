<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Student::class, function (Faker $faker) {
    return [
       'user_id' =>  $faker->randomFloat(2, 1, 3,4),
        'start_date' => $faker->date(),
        'end_date' =>$faker->date(),
        'course_id' => 1,
    ];
});
