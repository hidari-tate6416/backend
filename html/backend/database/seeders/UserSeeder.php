<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'member_id' => 1,
            'user_type_id' => 1,
            'user_name' => 'tatemichi',
            'status' => 1
        ]);
    }
}
