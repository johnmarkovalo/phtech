<?php

use Illuminate\Database\Seeder;

class CommunityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('community')->insert([
            ['organizer_id' => '2', 'name' => 'GDG Zamboanga', 'description' => 'This is a group for anyone interested in Google Technology, IOT, Technopreneurship, Programming, Integrating Technology in Education and almost anything about tech. All skill levels are welcome. We started this group to meet like minded tech-enthusiasts. Looking forward to exploring technology with everybody.

            Disclaimer: GDG Zamboanga is an independent group; our activities and the opinions expressed here should in no way be linked to Google, the corporation. To learn more about the GDG program, visit https://developers.google.com/groups/', 'location' => '{"lat":6.921442399999999,"lng":122.07902669999999,"name":"Zamboanga","formatted_address":"Zamboanga, Philippines"}', 'photo' => 'https://res.cloudinary.com/mactimestwo/image/upload/v1572071482/phtechpark/community/default.jpg'],
        ]);
    }
}
