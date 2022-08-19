<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
class BusinessAccountSeeder extends Seeder
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
        foreach(range(1,20) as $index){
            DB::table('business_accounts')->insert([
                "user_id" => $index,
                "business_name" => $faker->name,
                "business_descripition"=> $faker->paragraph(3),
                "opening_time"=> date("H:i", strtotime($faker->time)),
                "closing_time"=> date("H:i", strtotime($faker->time)),
                "email"=> $faker->email,
                "phone"=> $faker->phoneNumber,
                "business_sub_category"=> "Driving Instructor",
                "full_address"=> $faker->address,
                "house_no"=> $faker->buildingNumber,
                "postal_code"=> $faker->postcode,
                "city_or_town"=>  "San Francisco",
                "county_locality"=> $faker->cityPrefix,
                "country_nation"=> $faker->country,
                "latitude"=> $faker->latitude,
                "longtitude"=> $faker->longitude,
                //"active_days"=> "[Monday, Tuesday]",
                'created_at' => $faker->dateTimeThisYear, 
                'updated_at' =>$faker->dateTimeThisYear, 
            ]);
        }
    }
}
