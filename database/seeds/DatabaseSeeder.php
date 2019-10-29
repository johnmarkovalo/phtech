<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TechnologyTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(InformationTableSeeder::class);
        $this->call(PointsTableSeeder::class);
        $this->call(info_techTableSeeder::class);
        $this->call(CommunityTableSeeder::class);
        $this->call(community_techTableSeeder::class);
        $this->call(user_communityTableSeeder::class);
    }
}
