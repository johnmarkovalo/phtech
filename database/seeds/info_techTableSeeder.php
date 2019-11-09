<?php

use Illuminate\Database\Seeder;

class info_techTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('info_tech')->insert([
            ['tech_id' => '1', 'info_id' => '1'],
            ['tech_id' => '2', 'info_id' => '1'],
            ['tech_id' => '3', 'info_id' => '1'],
            ['tech_id' => '4', 'info_id' => '1'],
            ['tech_id' => '5', 'info_id' => '2'],
            ['tech_id' => '6', 'info_id' => '2'],
            ['tech_id' => '7', 'info_id' => '2'],
            ['tech_id' => '8', 'info_id' => '2'],
            ['tech_id' => '1', 'info_id' => '3'],
            ['tech_id' => '4', 'info_id' => '3'],
            ['tech_id' => '2', 'info_id' => '3'],
            ['tech_id' => '8', 'info_id' => '3'],
            ['tech_id' => '2', 'info_id' => '4'],
            ['tech_id' => '5', 'info_id' => '4'],
            ['tech_id' => '7', 'info_id' => '4'],
            ['tech_id' => '8', 'info_id' => '4'],
        ]);
    }
}
