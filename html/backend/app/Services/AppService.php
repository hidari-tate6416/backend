<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Utils\DBU;

use App\Models\ScoreRoom;

class AppService
{
    public function createScoreRoom(Request $request, $member_id)
    {
        $results = array(
            'result' => false,
            'score_room_id' => 0,
        );

        $default_score = $request->input('default_score');
        $room_name = $request->input('room_name');
        $room_password = $request->input('room_password');
        $host_color = $request->input('host_color');
        $guest1_color = $request->input('guest1_color');
        $guest2_color = $request->input('guest2_color');
        $guest3_color = $request->input('guest3_color');
        $guest4_color = $request->input('guest4_color');

        $score_room = ScoreRoom::where('status', '=', 1)
            ->whereNull('expired_at')
            ->first();

        if (empty($score_room)) {
            $results['result'] = true;
            return $results;
        }

        try {
            DBU::beginTransaction();

            $score_room->room_name = $room_name;
            $score_room->room_password = $room_password;
            $score_room->expired_at = date("Y-m-d H:i:s", strtotime('+1 hours'));
            $score_room->host_member_id = $member_id;
            $score_room->host_member_color_id = $host_color;
            $score_room->guest1_member_color_id = (!empty($guest1_color)) ? $guest1_color : 0;
            $score_room->guest2_member_color_id = (!empty($guest2_color)) ? $guest2_color : 0;
            $score_room->guest3_member_color_id = (!empty($guest3_color)) ? $guest3_color : 0;
            $score_room->guest4_member_color_id = (!empty($guest4_color)) ? $guest4_color : 0;
            $score_room->default_score = $default_score;
            $score_room->host_member_score = $default_score;
            $score_room->guest1_member_score = (!empty($guest1_color)) ? $default_score : 0;
            $score_room->guest2_member_score = (!empty($guest2_color)) ? $default_score : 0;
            $score_room->guest3_member_score = (!empty($guest3_color)) ? $default_score : 0;
            $score_room->guest4_member_score = (!empty($guest4_color)) ? $default_score : 0;

            $score_room->save();

            DBU::commit();
            $results['result'] = true;
            $results['score_room_id'] = $score_room->id;

        }
        catch (\Exception $e) {
            DBU::rollBack();
            // echo $e;
            return $results;
        }

        return $results;
    }

    public function getScoreRoom(Request $request)
    {
        $result = array();
        $member_no = $request->input('member_no');
        $now_date = date("Y-m-d H:i:s");

        $score_room = ScoreRoom::whereDate('expired_at', '>=', $now_date)
            ->find($request->input('score_room_id'));

        if (empty($score_room) or $member_no > 4 or $member_no < 0) {
            return $result;
        }

        $save = $this->updateSoreRoom($score_room);
        if (!$save) {
            return $result;
        }

        $result['room_name'] = $score_room->room_name;
        $result['default_score'] = $score_room->default_score;

        if (0 == $member_no) {
            $result['my_score'] = $score_room->host_member_score;
            $result['my_color'] = DBU::getColor($score_room->host_member_color_id);
        }
        else {
            $member_color_id = 'guest' . (string)$member_no . '_member_color_id';
            $member_score = 'guest' . (string)$member_no . '_member_score';
            $result['my_score'] = $score_room->$member_score;
            $result['my_color'] = DBU::getColor($score_room->$member_color_id);
        }

        $other_member = array();

        for ($index = 0; $index < 5; $index++) {

            if ($index == $member_no) {
                continue;
            }

            if (0 == $index) {
                $other_member[$index] = [
                    "score" => $score_room->host_member_score,
                    "color" => DBU::getColor($score_room->host_member_color_id)
                ];
            }
            else {
                $other_member_color_id = 'guest' . (string)$index . '_member_color_id';
                $other_member_score = 'guest' . (string)$index . '_member_score';
                if (!empty($score_room->$other_member_color_id)) {
                    $other_member[$index] = [
                        "score" => $score_room->$other_member_score,
                        "color" => DBU::getColor($score_room->$other_member_color_id)
                    ];
                }
            }
        }

        $result['other_member'] = $other_member;

        return $result;
    }

    public function updateSoreRoom($score_room)
    {
        $result = false;

        try {
            DBU::beginTransaction();

            $score_room->expired_at = date("Y-m-d H:i:s", strtotime('+1 hours'));
            $score_room->save();

            DBU::commit();
            $result = true;
        }
        catch (\Exception $e) {
            DBU::rollBack();
            // echo $e;
            return $result;
        }

        return $result;
    }

    public function resetScoreRoom()
    {
        $result = false;

        $now_date = date("Y-m-d H:i:s");
        $score_rooms = ScoreRoom::where('status', '=', 1)
            ->whereNotNull('expired_at')
            ->get();

        if ($score_rooms->isEmpty()) {
            $result = true;
            return $result;
        }

        try {
            DBU::beginTransaction();

            foreach ($score_rooms as $score_room) {
                if ($score_room->expired_at >= $now_date) {
                    continue;
                }

                $score_room->room_name = null;
                $score_room->room_password = null;
                $score_room->expired_at = null;
                $score_room->host_member_id = null;
                $score_room->host_member_color_id = 0;
                $score_room->guest1_member_color_id = 0;
                $score_room->guest2_member_color_id = 0;
                $score_room->guest3_member_color_id = 0;
                $score_room->guest4_member_color_id = 0;
                $score_room->default_score = 0;
                $score_room->host_member_score = 0;
                $score_room->guest1_member_score = 0;
                $score_room->guest2_member_score = 0;
                $score_room->guest3_member_score = 0;
                $score_room->guest4_member_score = 0;

                $score_room->save();
            }

            DBU::commit();
            $result = true;

        }
        catch (\Exception $e) {
            DBU::rollBack();
            // echo $e;
            return $result;
        }

        return $result;
    }
}