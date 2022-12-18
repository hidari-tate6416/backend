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

    public function listScoreRoom()
    {
        $results = array(
            'result' => false,
            'rooms' => array()
        );

        $now_date = date("Y-m-d H:i:s");
        $score_rooms = ScoreRoom::where('status', '=', 1)
            ->whereNotNull('expired_at')
            ->get();

        if ($score_rooms->isEmpty()) {
            $results['result'] = true;
            return $results;
        }

        $rooms = array();

        foreach ($score_rooms as $score_room) {

            $rooms[] = array(
                'room_id' => $score_room->id,
                'room_name' => $score_room->room_name
            );
        }

        $results['result'] = true;
        $results['rooms'] = $rooms;

        return $results;
    }

    public function getScoreRoom(Request $request)
    {
        $results = array(
            'result' => false,
            'room' => array()
        );

        $score_room = ScoreRoom::where('status', '=', 1)
            ->find($request->input('score_room_id'));

        if (empty($score_room)) {
            return $results;
        }

        $guests = array();

        for ($index = 1; $index < 5; $index++) {
            $guest = array();

            $guest_color_id = 'guest' . (string)$index . '_member_color_id';
            $guest_member_id = 'guest' . (string)$index . '_member_id';

            if (!empty($score_room->$guest_color_id)) {
                $guest['use'] = (!empty($score_room->$guest_member_id)) ? true : false;
                $guest['member_no'] = $index;
                $guest['color_id'] = DBU::getColor($score_room->$guest_color_id);

                $guests[] = $guest;
            }
        }

        $room = array(
            'room_id' => $score_room->id,
            'guests' => $guests,
        );

        $results['result'] = true;
        $results['room'] = $room;

        return $results;
    }

    public function joinScoreRoom(Request $request, $member_id)
    {
        $result = false;

        $score_room_id = $request->input('score_room_id');
        $member_no = $request->input('member_no');
        $room_password = $request->input('room_password');

        $score_room = ScoreRoom::where('status', '=', 1)
            ->where('room_password', '=', $room_password)
            ->find($score_room_id);

        if (empty($score_room)) {
            return $result;
        }

        try {
            DBU::beginTransaction();

            $guest_member_id = 'guest' . (string)$member_no . '_member_id';
            $score_room->$guest_member_id = $member_id;
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

    public function getDetailScoreRoom(Request $request)
    {
        $result = array();
        $member_no = $request->input('member_no');
        $now_date = date("Y-m-d H:i:s");

        $score_room = ScoreRoom::find($request->input('score_room_id'));

        if (empty($score_room) or $score_room->expired_at < $now_date or $member_no > 4 or $member_no < 0) {
            return $result;
        }

        $save = $this->updateScoreRoomExp($score_room);
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

            $member_name = '';

            if (0 == $index) {
                $member_name = DBU::getName($score_room->host_member_id);
                $other_member[$index] = [
                    "name" => $member_name,
                    "score" => $score_room->host_member_score,
                    "color" => DBU::getColor($score_room->host_member_color_id)
                ];
            }
            else {
                $other_member_id = 'guest' . (string)$index . '_member_id';
                if (!empty($score_room->$other_member_id)) {
                    $member_name = DBU::getName($score_room->$other_member_id);
                }
                $other_member_color_id = 'guest' . (string)$index . '_member_color_id';
                $other_member_score = 'guest' . (string)$index . '_member_score';
                if (!empty($score_room->$other_member_color_id)) {
                    $other_member[$index] = [
                        "name" => $member_name,
                        "score" => $score_room->$other_member_score,
                        "color" => DBU::getColor($score_room->$other_member_color_id)
                    ];
                }
            }
        }

        $result['other_member'] = $other_member;

        return $result;
    }

    public function updateScoreRoom(Request $request)
    {
        $results = array();

        $scores = $request->input('scores');
        $now_date = date("Y-m-d H:i:s");

        $score_room = ScoreRoom::find($request->input('score_room_id'));

        if (empty($score_room) or $score_room->expired_at < $now_date) {
            return $results;
        }

        $save = $this->updateScoreRoomExp($score_room);
        if (!$save) {
            return $results;
        }

        try {
            DBU::beginTransaction();

            $total_score = 0;
            $total_member = 0;
            foreach ($scores as $key => $score) {
                if (0 == $key) {
                    $score_room->host_member_score = $score_room->host_member_score + $score;
                    $total_member++;
                    $total_score += $score_room->host_member_score;
                }
                else {
                    $member_score = 'guest' . (string)$key . '_member_score';
                    $score_room->$member_score = $score_room->$member_score + $score;

                    $other_member_color_id = 'guest' . (string)$key . '_member_color_id';
                    if (!empty($score_room->$other_member_color_id)) {
                        $total_member++;
                    }
                    $total_score += $score_room->$member_score;
                }

                $score_room->save();
            }

            DBU::commit();
            $results['result'] = true;

            $true_total_score = $score_room->default_score * $total_member;
            $results['difference_score'] = $total_score - $true_total_score;

        }
        catch (\Exception $e) {
            DBU::rollBack();
            // echo $e;
            return $results;
        }

        return $results;
    }

    public function updateScoreRoomExp($score_room)
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
        $results = array(
            'result' => false,
            'empty_room' => 0
        );

        $now_date = date("Y-m-d H:i:s");
        $score_rooms = ScoreRoom::where('status', '=', 1)
            ->whereNotNull('expired_at')
            ->get();

        if ($score_rooms->isEmpty()) {
            
            $score_room = ScoreRoom::where('status', '=', 1)
                ->whereNull('expired_at')
                ->count();
    
            $results['result'] = true;
            $results['empty_room'] = $score_room;
            return $results;
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
                $score_room->guest1_member_id = null;
                $score_room->guest2_member_id = null;
                $score_room->guest3_member_id = null;
                $score_room->guest4_member_id = null;
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
            $results['result'] = true;

        }
        catch (\Exception $e) {
            DBU::rollBack();
            // echo $e;
            return $results;
        }

        $score_room = ScoreRoom::where('status', '=', 1)
            ->whereNull('expired_at')
            ->count();

        $results['empty_room'] = $score_room;

        return $results;
    }

    public function logoutScoreRoom(Request $request, $member_id)
    {
        $result = false;

        $score_room = ScoreRoom::where('host_member_id', '=', $member_id)
            ->find($request->input('score_room_id'));

        if (empty($score_room)) {
            return $result;
        }

        try {
            DBU::beginTransaction();

            $score_room->room_name = null;
            $score_room->room_password = null;
            $score_room->expired_at = null;
            $score_room->host_member_id = null;
            $score_room->guest1_member_id = null;
            $score_room->guest2_member_id = null;
            $score_room->guest3_member_id = null;
            $score_room->guest4_member_id = null;
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

    public function logoutGuestScoreRoom(Request $request, $member_id)
    {
        $result = false;
        $member_no = $request->input('member_no');

        $score_room = ScoreRoom::find($request->input('score_room_id'));

        if (empty($score_room)) {
            return $result;
        }

        try {
            DBU::beginTransaction();

            $other_member_id = 'guest' . (string)$member_no . '_member_id';
            $other_member_score = 'guest' . (string)$member_no . '_member_score';

            $score_room->$other_member_id = null;
            $score_room->$other_member_score = $score_room->default_score;

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
}