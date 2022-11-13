<?php

namespace Database\Seeders;

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
        // $this->call(UserTypeSeeder::class);
        // $this->call(UserSeeder::class);
        // $this->call(MemberSeeder::class);
        $this->call(ScoreRoomSeeder::class);
        $this->call(ColorSeeder::class);
    }
}
