<?php

use Illuminate\Database\Seeder;

class community_techTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('community_tech')->insert([
            ['tech_id' => '1', 'community_id' => '1'],
            ['tech_id' => '2', 'community_id' => '1'],
            ['tech_id' => '3', 'community_id' => '1'],
            ['tech_id' => '4', 'community_id' => '1'],
        ]);
    }
}
