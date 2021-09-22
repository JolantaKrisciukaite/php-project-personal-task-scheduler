<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_EN');

        DB::table('users')->insert([
            'name' => 'Jolanta',
            'email' => 'jkrisciukaite@gmail.com',
            'password' => Hash::make('123'),
        ]);

        DB::table('users')->insert([
            'name' => 'Raudona',
            'email' => 'raudona.zeme@gmail.com',
            'password' => Hash::make('123'),
        ]);
        
        $statuses = ['under construction', 'underway', 'prepared', 'started', 'corrected', 'temporarily stoped', 'adjucted', 'postponed'];
        foreach (range(1, 30) as $_) {
            DB::table('statuses')->insert([
                'name' => $statuses[rand(0, count($statuses) - 1)],
            ]);
        }
        
        $tasks = ['programming', 'create new arrays', 'create faker', 'create css', 'create html', 'create blades', 'create controllers'];
        foreach(range(1, 200) as $_) {
            DB::table('tasks')->insert([
                'task_name' => $tasks[rand(0, count($tasks) - 1)],
                'task_description' => $faker->realText(300, 5),
                'statuse_id' => rand(1, 30),
                'add_date' => date('Y-m-d'),
                'completed_date' => date('Y-m-d'),
                'photo' =>  rand(0, 2) ? $faker->imageUrl(200, 200) : null, // nuotrauku idejimas
            ]);
        }
    }
}

