<?php

function getHoliday($year){
    $holiday = [
        '1-1' => '元日',
        '2-23' => '天皇誕生日',
        '5-4' => 'みどりの日',
        '5-5' => 'こどもの日'
    ];
    return $holiday;
}

$holiday = getHoliday(2024);
print_r($holiday);

$y = 2240; $m = 6;
$date = '2025-1-1';
function getWeekday($date){
    return date('w', strtotime($date));
}

echo getWeekday($date);
?>