<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event')->insert([
            ['code' => '18933732374','organizer_id' => '2', 'title' => 'GDG Meetup 2019', 'description' => "Let's get updated with the latest Google Technologies and at the same time have fun!", 'start' => '2019-11-02 09:00:00', 'end' => '2019-11-02 12:00:00', 'location' => '{"lat":6.921442399999999,"lng":122.07902669999999,"name":"Zamboanga","formatted_address":"Zamboanga, Philippines"}', 'photo' => 'https://res.cloudinary.com/mactimestwo/image/upload/v1572071482/phtechpark/community/default.jpg'],
        ]);
    }
}
