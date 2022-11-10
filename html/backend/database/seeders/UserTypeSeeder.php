<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserType;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_types = array(
            'マスター',
            'アドミンマネージャー',
            'メンバーマネージャー',
            'メンバー招待許可'
        );

        foreach ($user_types as $user_type) {
            UserType::create([
                'type_name' => $user_type,
                'status' => 1
            ]);
        }
    }
}
