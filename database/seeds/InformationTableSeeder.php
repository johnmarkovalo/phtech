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
            ['user_id' => '1', 'lastname' => 'Ovalo', 'firstname' => 'John Mark', 'affiliation' => 'Dreame.rs', 'position' => 'Frond-End Developer', 'avatar' => 'phtechpark/profiles/mac'],
            ['user_id' => '2', 'lastname' => 'Magpantay', 'firstname' => 'Daphnie Rea', 'affiliation' => 'Dreame.rs', 'position' => 'Frond-End Developer', 'avatar' => 'phtechpark/profiles/daph'],
            ['user_id' => '3', 'lastname' => 'Villaflores', 'firstname' => 'Anthony', 'affiliation' => 'Western Mindanao State University', 'position' => 'BS Computer Science', 'avatar' => 'phtechpark/profiles/default'],
        ]);
    }
}
