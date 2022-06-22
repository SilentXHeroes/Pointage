<?php

    function addTime($time, $add){
        $time['S'] += $add['S'];
        if($time['S'] >= 60){
            $time['S'] = $time['S'] - 60;
            $time['M']++;
        }
        $time['M'] += $add['M'];
        if($time['M'] >= 60){
            $time['M'] = $time['M'] - 60;
            $time['H']++;
        }
        $time['H'] += $add['H'];

        return $time;
    }

    function timeToMinutes($time){
        if(is_object($time)){
            $times = explode(':', $time->format('H:i:s'));
            $time = array(
                'H' => $times[0],
                'M' => $times[1],
                'S' => $times[2]
            );
        }

        return ($time['H']*60) + $time['M'] + ($time['S'] / 60);
    }

    function minutesToTime($minutes){
        $H = intval($minutes / 60);
        $M = $minutes - ($H * 60);
        $S = ($minutes - intval($minutes)) * 60;

        return array(
            'H' => $H,
            'M' => $M,
            'S' => $S
        );
    }

?>