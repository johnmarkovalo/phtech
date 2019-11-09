<?php

use Illuminate\Database\Seeder;

class InformationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('information')->insert([
            ['user_id' => '1', 'lastname' => 'Ovalo', 'firstname' => 'John Mark', 'affiliation' => 'Dreame.rs', 'position' => 'Frond-End Developer', 'occupation' => 'Frond-End Developer','address' => '{"lat":6.921442399999999,"lng":122.07902669999999,"name":"Zamboanga","formatted_address":"Zamboanga, Philippines"}' , 'bio' => 'Frond-End Developer at Dreame.rs', 'avatar' => 'phtechpark/profiles/mac'],
            ['user_id' => '2', 'lastname' => 'Magpantay', 'firstname' => 'Daphnie Rea', 'affiliation' => 'Dreame.rs', 'position' => 'Frond-End Developer', 'occupation' => 'Frond-End Developer','address' => '{"lat":6.921442399999999,"lng":122.07902669999999,"name":"Zamboanga","formatted_address":"Zamboanga, Philippines"}' , 'bio' => 'Frond-End Developer at Dreame.rs', 'avatar' => 'phtechpark/profiles/daph'],
            ['user_id' => '3', 'lastname' => 'Villaflores', 'firstname' => 'Anthony', 'affiliation' => 'Western Mindanao State University', 'position' => 'BS Computer Science', 'occupation' => 'Student','address' => '{"lat":6.921442399999999,"lng":122.07902669999999,"name":"Zamboanga","formatted_address":"Zamboanga, Philippines"}' ,'bio' => 'Student at Western Mindanao State University', 'avatar' => 'phtechpark/profiles/default'],
            ['user_id' => '4', 'lastname' => 'Onrubia', 'firstname' => 'Fatima Mercy', 'affiliation' => 'Western Mindanao State University', 'position' => 'BS Computer Science', 'occupation' => 'Student','address' => '{"lat":6.921442399999999,"lng":122.07902669999999,"name":"Zamboanga","formatted_address":"Zamboanga, Philippines"}' ,'bio' => 'Student at Western Mindanao State University', 'avatar' => 'phtechpark/profiles/default'],
        ]);
    }
}
