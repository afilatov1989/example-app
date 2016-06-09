<?php

use App\Meal;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $admin = Role::getByName('admin');
        $manager = Role::getByName('manager');

        // create Admin
        $userAdmin = User::create([
            'name'             => 'John Smith',
            'email'            => 'admin@test.com',
            'password'         => 'qwerty123',
            'calories_per_day' => User::CALORIES_PER_DAY_DEFAULT,
        ]);

        $userAdmin->attachRole($admin);

        // create Manager
        $userManager = User::create([
            'name'             => 'Jack Doe',
            'email'            => 'manager@test.com',
            'password'         => 'qwerty123',
            'calories_per_day' => User::CALORIES_PER_DAY_DEFAULT,
        ]);

        $userManager->attachRole($manager);

        // create 50 common users
        for ($i = 1; $i <= 50; $i++) {
            $user = User::create([
                'name'             => $faker->name(),
                'email'            => "user{$i}@test.com",
                'password'         => 'qwerty123',
                'calories_per_day' => User::CALORIES_PER_DAY_DEFAULT,
            ]);

            // create meals for users
            for ($j = 0; $j < rand(3, 10); $j++) {
                $dateObj = $faker->dateTimeThisMonth();
                $meal = new Meal([
                    'date'     => $dateObj->format('Y-m-d'),
                    'time'     => $dateObj->format('H:s'),
                    'text'     => $faker->text(100),
                    'calories' => rand(100, 2500),
                ]);
                $user->meals()->save($meal);
            }
        }
    }
}
