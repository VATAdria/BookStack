<?php

namespace Database\Seeders;

use BookStack\Auth\User;
use BookStack\Entities\Models\Handover;
use Illuminate\Database\Eloquent\Model;
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
        Model::unguard();

        // $this->call(UserTableSeeder::class);

        Model::reguard();

        // Create the default dev accounts corresponding to VATSIM Connect
        for ($i = 1; $i <= 11; $i++) {

            $name_first = "Web";
            $name_last = "X";
            $email = "auth.dev".$i."@vatsim.net";

            $rating_id = 1;
            $group = null;

            switch($i){
                case 1:
                    $name_last = "One";                 
                    break;
                case 2:
                    $name_last = "Two";
                    $rating_id = 2;
                    break;
                case 3:
                    $name_last = "Three";
                    $rating_id = 3;
                    break;
                case 4:
                    $name_last = "Four";
                    $rating_id = 4;
                    break;
                case 5:
                    $name_last = "Five";
                    $rating_id = 5;
                    break;
                case 6:
                    $name_last = "Six";
                    $rating_id = 7;
                    break;
                case 7:
                    $name_last = "Seven";
                    $rating_id = 8;
                    $group = 3;
                    break;
                case 8:
                    $name_last = "Eight";
                    $rating_id = 10;
                    $group = 3;
                    break;
                case 9:
                    $name_last = "Nine";
                    $rating_id = 11;
                    $group = 2;
                    break;
                case 10:
                    $name_first = "Team";
                    $name_last = "Web";
                    $rating_id = 12;
                    $email = "noreply@vatsim.net";
                    $group = 1;
                    break;
                case 11:
                    $name_first = "Suspended";
                    $name_last = "User";
                    $rating_id = 0;
                    $email = "suspended@vatsim.net";
                    break;
            }

            User::factory()->create([
                'id' => 10000000 + $i,
            ]);

            Handover::factory()->create([
                'id' => 10000000 + $i,
                'email' => $email,
                'first_name' => $name_first,
                'last_name' => $name_last,
                'rating' => $rating_id,
                'rating_short' => rand(0, 10),
                'rating_long' => rand(0, 10),
                'region' => "EMEA",
                'division' => "EUD",
                'subdivision' => "SCA",
            ]);
        }

        // Create random Scandinavian users
        for ($i = 12; $i <= 125; $i++) {
            User::factory()->create([
                'id' => 10000000 + $i,
            ]);
            Handover::factory()->create([
                'id' => 10000000 + $i,
                'region' => "EMEA",
                'division' => "EUD",
                'subdivision' => "SCA",
            ]);
        }

        // Create random users
        for ($i = 126; $i <= 250; $i++) {
            User::factory()->create([
                'id' => 10000000 + $i,
            ]);
            Handover::factory()->create([
                'id' => 10000000 + $i,
            ]);
        }
    }
}

    
