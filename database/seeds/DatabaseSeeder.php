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
        $this->call(info_techTableSeeder::class);
    }
}
