<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Member::create([
            'name' => 'tate',
            'login_id' => 'tate6416',
            'password' => password_hash('tatemiti1', PASSWORD_DEFAULT),
            'user_member_id' => 0,
            'approved_flag' => 1,
            'status' => 1
        ]);
    }
}
