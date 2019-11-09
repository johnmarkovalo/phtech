<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'John Mark Ovalo', 'email' => 'john@me.com', 'user_type' => 'admin', 'password' => '$2y$10$p1n5m3u79Blk2wdIidG3b.TV33IE5Sm2hHiFhKVC1mtAlCwq9P0He'],
            ['name' => 'Daphnie Rea Magpantay', 'email' => 'dapdap@me.com', 'user_type' => 'user', 'password' => '$2y$10$p1n5m3u79Blk2wdIidG3b.TV33IE5Sm2hHiFhKVC1mtAlCwq9P0He'],
            ['name' => 'Anthony Villaflores', 'email' => 'ton@me.com', 'user_type' => 'user', 'password' => '$2y$10$p1n5m3u79Blk2wdIidG3b.TV33IE5Sm2hHiFhKVC1mtAlCwq9P0He'],
            ['name' => 'Fatima Mercy Onrubia', 'email' => 'tima@me.com', 'user_type' => 'user', 'password' => '$2y$10$p1n5m3u79Blk2wdIidG3b.TV33IE5Sm2hHiFhKVC1mtAlCwq9P0He'],
        ]);
    }
}
