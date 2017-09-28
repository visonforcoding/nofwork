<?php

print_r(getdate(time()));
//跨天了则 定到23点


function fn($time1, $time2)
{
    $date1 = getdate($time1);
    if ($date1['yday'] != getdate($time2)['yday']) {
        $tiemStr = sprintf('%d-%d-%d 23:00:00', $date1['year'], $date1['mon'], $date1['mday']);
        $newTime2  = strtotime($tiemStr);
        if ($time1<$newTime2) {
            $time2 = $newTime2;
        }
    }
    return $time2;
}

$date1 = '2017-9-13 22:14:47';
$date2 = '2017-9-14 10:00:00';
$time1= strtotime($date1);
$time2 = strtotime($date2);
$time2 = fn($time1, $time2);
echo date('Y-m-d H:i:s', $time2);

var_dump(strtotime($time2));

function praseNumDate($string){
    preg_match('/(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/',$string,$matchs);
    if(count($matchs)==7){
        return $matchs[1].'-'.$matchs[2].'-'.$matchs[3].' '.$matchs[4].':'.$matchs[5].':'.$matchs[6];
    }else{
        return false;
    }
    return $matchs;
}

var_dump(praseNumDate('20160725152626'));

$a = null;

var_dump(is_null($a));
