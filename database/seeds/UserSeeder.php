<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker\Factory::create();

        // generate data by accessing properties
        //  echo $faker->name;

        $user = new User;
        $user->name = $faker->name;
        $user->mobile_number = $faker->phoneNumber;
        $user->ticket_type = "student";
        $user->email = $faker->email;
        $user->save();
    }
}
