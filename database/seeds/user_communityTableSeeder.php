<?php

use Illuminate\Database\Seeder;

class user_communityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_community')->insert([
            ['user_id' => '2', 'community_id' => '1', 'position' => 'organizer'],
        ]);
    }
}
