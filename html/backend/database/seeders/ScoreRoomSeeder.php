<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ScoreRoom;

class ScoreRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 1;

        while(true) {

            if (10 < $count) {
                break;
            }
            
            ScoreRoom::create([
                'status' => 1
            ]);

            $count++;
        }
    }
}
