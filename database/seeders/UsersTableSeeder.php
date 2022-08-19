<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create('en_GB');
        foreach(range(1,30) as $index){
            DB::table('users')->insert([
                'name' => $faker->firstName,
                'fullname' => $faker->name,
                'email' => $faker->firstName.'@gmail.com',
                'bio' => $faker->sentence(5),
                'password' => Hash::make("oloo"),
                'phone' => $faker->phoneNumber,
                'has_professional_acc' => '1',
                'business_id' => $index,
                'created_at' => $faker->dateTimeThisYear, 
                'updated_at' =>$faker->dateTimeThisYear, 
            ]);
        }
      

    }
}
