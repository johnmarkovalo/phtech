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
            ['code' => '18933732374','organizer_id' => '2', 'title' => 'GDG Meetup 2019', 'description' => "Let's get updated with the latest Google Technologies and at the same time have fun!", 'start' => '2019-10-02 09:00:00', 'end' => '2019-10-02 12:00:00', 'location' => '{"lat":6.921442399999999,"lng":122.07902669999999,"name":"Zamboanga","formatted_address":"Zamboanga, Philippines"}', 'photo' => 'https://res.cloudinary.com/mactimestwo/image/upload/v1572071482/phtechpark/community/default.jpg'
            ],
            ['code' => '52015721025','organizer_id' => '2', 'title' => 'DevFest 2019', 'description' => "This is a series of community-led events, where you can learn the essentials and best practices of Kotlin in Android, Google Cloud Platform, and multi-platform development.", 'start' => '2019-11-07 09:00:00', 'end' => '2019-11-07 12:00:00', 'location' => '{"lat":6.910295,"lng":122.07607459999997,"name":"Ateneo de Zamboanga University","formatted_address":"La Purisima St, Zamboanga, 7000 Zamboanga del Sur, Philippines"}', 'photo' => 'https://res.cloudinary.com/mactimestwo/image/upload/v1572071482/phtechpark/community/default.jpg'
            ],
            ['code' => '99069248424','organizer_id' => '2', 'title' => 'Kotlin is Life', 'description' => "This is a series of community-led events, where you can learn the essentials and best practices of Kotlin in Android, Google Cloud Platform, and multi-platform development.", 'start' => '2019-11-21 09:00:00', 'end' => '2019-11-21 12:00:00', 'location' => '{"lat":6.910295,"lng":122.07607459999997,"name":"Ateneo de Zamboanga University","formatted_address":"La Purisima St, Zamboanga, 7000 Zamboanga del Sur, Philippines"}', 'photo' => 'https://res.cloudinary.com/mactimestwo/image/upload/v1572071482/phtechpark/community/default.jpg'
            ],
        ]);
        
    }
}
