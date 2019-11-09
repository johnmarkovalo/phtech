<?php

use Illuminate\Database\Seeder;

class PointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('points')->insert([
            ['user_id' => '2', 'points' => '0'],
            ['user_id' => '3', 'points' => '0'],
            ['user_id' => '4', 'points' => '0'],
        ]);
    }
}
