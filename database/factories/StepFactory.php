<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Step;
use App\Task;
use Faker\Generator as Faker;

$factory->define(Step::class, function (Faker $faker) {
    return [
        'name'=>$faker->sentence(),
        'completion'=>$faker->boolean(),
        'task_id'=>Task::all()->random()->id
    ];
});
