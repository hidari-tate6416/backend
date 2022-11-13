<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrays = array(
            [
                'code' => '#000000',
                'name_en' => 'black',
                'name_ja' => '黒',
                'white' => true,
            ],
            [
                'code' => '#808080',
                'name_en' => 'gray',
                'name_ja' => '灰',
                'white' => true,
            ],
            [
                'code' => '#FFFFFF',
                'name_en' => 'white',
                'name_ja' => '白',
            ],
            [
                'code' => '#FF0000',
                'name_en' => 'red',
                'name_ja' => '赤',
            ],
            [
                'code' => '#0000FF',
                'name_en' => 'blue',
                'name_ja' => '青',
                'white' => true,
            ],
            [
                'code' => '#008000',
                'name_en' => 'green',
                'name_ja' => '緑',
                'white' => true,
            ],
            [
                'code' => '#FFFF00',
                'name_en' => 'yellow',
                'name_ja' => '黄',
            ],
            [
                'code' => '#800080',
                'name_en' => 'purple',
                'name_ja' => '紫',
                'white' => true,
            ],
            [
                'code' => '#800000',
                'name_en' => 'maroon',
                'name_ja' => '焦赤',
                'white' => true,
            ],
            [
                'code' => '#00FF00',
                'name_en' => 'lime',
                'name_ja' => 'ライム',
            ],
            [
                'code' => '#00FFFF',
                'name_en' => 'aqua',
                'name_ja' => '水',
            ]
        );

        foreach($arrays as $array) {

            $text_color_name_en = 'black';
            $text_color_name_ja = '黒';

            if (!empty($array['white'])) {
                $text_color_name_en = 'white';
                $text_color_name_ja = '白';
            }
            
            Color::create([
                'code' => $array['code'],
                'name_en' => $array['name_en'],
                'name_ja' => $array['name_ja'],
                'text_color_name_en' => $text_color_name_en,
                'text_color_name_ja' => $text_color_name_ja
            ]);
        }
    }
}
